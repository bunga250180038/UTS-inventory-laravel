<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderManagementController extends Controller
{
    /**
     * Menampilkan daftar pesanan Pembeli untuk Admin dan Staff.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', '');

        $orders = Order::with('buyer', 'items.product')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', '%' . $search . '%')
                        ->orWhere('customer_phone', 'like', '%' . $search . '%')
                        ->orWhereHas('buyer', function ($buyerQuery) use ($search) {
                            $buyerQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when(
                in_array($status, ['pending', 'confirmed', 'rejected', 'cancelled'], true),
                function ($query) use ($status) {
                    $query->where('status', $status);
                }
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders', 'search', 'status'));
    }

    /**
     * Menampilkan detail pesanan untuk Admin dan Staff.
     */
    public function show(Order $order)
    {
        $order->load([
            'buyer',
            'items.product',
            'sale',
        ]);

        return view('orders.show', compact('order'));
    }

    /**
     * Menyetujui pesanan dan membuat transaksi penjualan.
     *
     * Stok diperiksa dan dikunci sebelum diubah.
     * Semua perubahan disimpan dalam satu transaksi database.
     */
    public function confirm(Order $order)
    {
        $orderId = $order->id;

        DB::transaction(function () use ($orderId) {
            $lockedOrder = Order::whereKey($orderId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Pesanan ini sudah diproses dan tidak dapat dikonfirmasi lagi.',
                ]);
            }

            $items = $lockedOrder->items()
                ->orderBy('product_id')
                ->get();

            if ($items->isEmpty()) {
                throw ValidationException::withMessages([
                    'status' => 'Pesanan tidak memiliki barang.',
                ]);
            }

            $productIds = $items->pluck('product_id')
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->sort()
                ->values();

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Periksa semua produk sebelum mengurangi stok.
            foreach ($items as $item) {
                $product = $products->get((int) $item->product_id);

                if (!$product) {
                    throw ValidationException::withMessages([
                        'status' => 'Produk pada pesanan tidak ditemukan.',
                    ]);
                }

                if ((int) $item->quantity < 1) {
                    throw ValidationException::withMessages([
                        'status' => 'Jumlah barang pada pesanan tidak valid.',
                    ]);
                }

                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'status' => 'Stok produk ' . $product->name
                            . ' tidak mencukupi. Stok tersedia: '
                            . $product->stock . '. Pesanan belum dikonfirmasi.',
                    ]);
                }
            }

            // Buat nomor penjualan yang unik.
            do {
                $saleNumber = 'PJ-' . now()->format('Ymd-His')
                    . '-' . Str::upper(Str::random(6));
            } while (Sale::where('sale_number', $saleNumber)->exists());

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'sale_number' => $saleNumber,
                'total' => $lockedOrder->total,
                'status' => 'completed',
                'sold_at' => now(),
            ]);

            // Buat item penjualan berdasarkan harga yang disimpan saat memesan.
            foreach ($items as $item) {
                $product = $products->get((int) $item->product_id);

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->subtotal,
                ]);

                $product->decrement('stock', $item->quantity);
            }

            // Tandai pesanan sebagai telah dikonfirmasi.
            $lockedOrder->update([
                'status' => 'confirmed',
                'sale_id' => $sale->id,
                'confirmed_at' => now(),
            ]);
        }, 3);

        return redirect()
            ->route('orders.show', $orderId)
            ->with(
                'success',
                'Pesanan berhasil disetujui, transaksi penjualan dibuat, dan stok diperbarui.'
            );
    }

    /**
     * Menolak pesanan yang masih menunggu konfirmasi.
     * Penolakan tidak mengurangi stok.
     */
    public function reject(Order $order)
    {
        $orderId = $order->id;

        DB::transaction(function () use ($orderId) {
            $lockedOrder = Order::whereKey($orderId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Hanya pesanan yang menunggu konfirmasi yang dapat ditolak.',
                ]);
            }

            $lockedOrder->update([
                'status' => 'rejected',
            ]);
        }, 3);

        return redirect()
            ->route('orders.show', $orderId)
            ->with('success', 'Pesanan berhasil ditolak. Stok produk tidak berubah.');
    }
}

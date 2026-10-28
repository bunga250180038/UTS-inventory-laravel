<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    /**
     * Daftar penjualan dengan pencarian, filter tanggal,
     * filter status, dan pagination.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => [
                'nullable',
                Rule::in(['completed', 'cancelled']),
            ],
            'date_from' => ['nullable', 'date'],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);

        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';
        $dateFrom = $validated['date_from'] ?? '';
        $dateTo = $validated['date_to'] ?? '';

        $sales = Sale::with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('sale_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($dateFrom !== '', function ($query) use ($dateFrom) {
                $query->whereDate('sold_at', '>=', $dateFrom);
            })
            ->when($dateTo !== '', function ($query) use ($dateTo) {
                $query->whereDate('sold_at', '<=', $dateTo);
            })
            ->orderByDesc('sold_at')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact(
            'sales',
            'search',
            'status',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Menampilkan formulir penjualan.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('sales.create', compact('products'));
    }

    /**
     * Menyimpan penjualan dengan beberapa produk.
     * Harga diambil dari database dan stok dikurangi
     * hanya jika seluruh transaksi berhasil.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_number' => [
                'required',
                'string',
                'max:100',
                'unique:sales,sale_number',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
            ],
            'items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $sale = DB::transaction(function () use ($validated) {
            $productIds = collect($validated['items'])
                ->pluck('product_id')
                ->map(fn ($id) => (int) $id)
                ->sort()
                ->values();

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Periksa stok semua produk sebelum mengubah data.
            foreach ($validated['items'] as $item) {
                $productId = (int) $item['product_id'];
                $quantity = (int) $item['quantity'];
                $product = $products->get($productId);

                if (!$product) {
                    throw ValidationException::withMessages([
                        'items' => 'Produk tidak ditemukan.',
                    ]);
                }

                if ($quantity < 1) {
                    throw ValidationException::withMessages([
                        'items' => 'Jumlah produk harus lebih dari nol.',
                    ]);
                }

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' =>
                            'Stok produk ' . $product->name .
                            ' tidak mencukupi. Stok tersedia: ' .
                            $product->stock . '.',
                    ]);
                }
            }

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'sale_number' => $validated['sale_number'],
                'total' => 0,
                'status' => 'completed',
                'sold_at' => now(),
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $productId = (int) $item['product_id'];
                $quantity = (int) $item['quantity'];
                $product = $products->get($productId);

                // Harga selalu diambil dari database.
                $unitPrice = (float) $product->selling_price;
                $subtotal = round($unitPrice * $quantity, 2);

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $quantity);
                $total += $subtotal;
            }

            $sale->update([
                'total' => round($total, 2),
            ]);

            return $sale;
        }, 3);

        return redirect()
            ->route('sales.show', $sale)
            ->with('success', 'Transaksi penjualan berhasil disimpan.');
    }

    /**
     * Menampilkan detail penjualan.
     */
    public function show(Sale $sale)
    {
        $sale->load([
            'user',
            'items.product',
        ]);

        return view('sales.show', compact('sale'));
    }

    /**
     * Penjualan yang sudah selesai tidak diedit.
     */
    public function edit(Sale $sale)
    {
        return redirect()
            ->route('sales.show', $sale)
            ->with(
                'error',
                'Transaksi penjualan yang sudah selesai tidak dapat diedit.'
            );
    }

    public function update(Request $request, Sale $sale)
    {
        return redirect()
            ->route('sales.show', $sale)
            ->with(
                'error',
                'Transaksi penjualan yang sudah selesai tidak dapat diubah.'
            );
    }

    /**
     * Riwayat penjualan tidak dihapus permanen.
     */
    public function destroy(Sale $sale)
    {
        return redirect()
            ->route('sales.show', $sale)
            ->with(
                'error',
                'Riwayat penjualan tidak dapat dihapus permanen.'
            );
    }

    /**
     * Membatalkan penjualan dan mengembalikan stok.
     */
    public function cancel(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            $lockedSale = Sale::whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedSale->status !== 'completed') {
                throw ValidationException::withMessages([
                    'status' =>
                        'Hanya penjualan yang selesai yang dapat dibatalkan.',
                ]);
            }

            $items = $lockedSale->items()
                ->orderBy('product_id')
                ->get();

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

            // Periksa dahulu seluruh produk.
            foreach ($items as $item) {
                $product = $products->get((int) $item->product_id);

                if (!$product) {
                    throw ValidationException::withMessages([
                        'status' =>
                            'Produk pada transaksi tidak ditemukan. ' .
                            'Pembatalan dibatalkan untuk menjaga data stok.',
                    ]);
                }
            }

            // Kembalikan stok setiap item.
            foreach ($items as $item) {
                $products->get((int) $item->product_id)
                    ->increment('stock', $item->quantity);
            }

            $lockedSale->update([
                'status' => 'cancelled',
            ]);
        }, 3);

        return redirect()
            ->route('sales.show', $sale)
            ->with(
                'success',
                'Penjualan dibatalkan dan stok produk telah dikembalikan.'
            );
    }
}

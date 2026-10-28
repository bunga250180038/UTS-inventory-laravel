<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BuyerOrderController extends Controller
{
    /**
     * Menyimpan pesanan baru dari pembeli.
     * Stok belum dikurangi pada tahap ini.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'customer_phone' => [
                'required',
                'string',
                'max:30',
            ],
            'shipping_address' => [
                'required',
                'string',
                'max:2000',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'payment_method' => [
                'required',
                'string',
                'in:cod,bank_transfer,e_wallet',
            ],
        ]);

        $orderNumber = 'ORD-' . now()->format('YmdHis')
            . '-' . Str::upper(Str::random(6));

        $order = DB::transaction(function () use (
            $validated,
            $orderNumber
        ) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];

            if ($product->stock < $quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok produk ' . $product->name
                        . ' tidak mencukupi. Stok tersedia saat ini: '
                        . $product->stock . '.',
                ]);
            }

            $unitPrice = (float) $product->selling_price;
            $subtotal = round($unitPrice * $quantity, 2);

            $order = Order::create([
                'buyer_id' => auth()->id(),
                'order_number' => $orderNumber,
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'] ?? null,
                'total' => $subtotal,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',
                'status' => 'pending',
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);

            return $order;
        }, 3);

        return redirect()
            ->route('buyer.orders.show', $order)
            ->with(
                'success',
                'Pesanan berhasil dibuat dan sedang menunggu konfirmasi.'
            );
    }

    /**
     * Menampilkan riwayat pesanan milik pembeli.
     */
    public function index()
    {
        $orders = Order::where('buyer_id', auth()->id())
            ->where('status', '!=', 'cancelled')
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('buyer-orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan milik pembeli.
     */
    public function show(Order $order)
    {
        abort_unless(
            (int) $order->buyer_id === (int) auth()->id(),
            403,
            'Kamu tidak memiliki izin untuk melihat pesanan ini.'
        );

        if ($order->status === 'cancelled') {
            return redirect()
                ->route('buyer.orders.index')
                ->with('success', 'Pesanan ini sudah dibatalkan dan tidak lagi ditampilkan.');
        }

        $order->load([
            'buyer',
            'items.product',
            'sale',
        ]);

        return view('buyer-orders.show', compact('order'));
    }

    /**
     * Membatalkan pesanan yang masih menunggu konfirmasi.
     */
    public function cancel(Order $order)
    {
        abort_unless(
            (int) $order->buyer_id === (int) auth()->id(),
            403,
            'Kamu tidak memiliki izin untuk membatalkan pesanan ini.'
        );

        $cancelled = DB::transaction(function () use ($order) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                (int) $lockedOrder->buyer_id === (int) auth()->id(),
                403,
                'Kamu tidak memiliki izin untuk membatalkan pesanan ini.'
            );

            // Pesanan hanya boleh dibatalkan saat masih pending.
            if ($lockedOrder->status !== 'pending') {
                return false;
            }

            $lockedOrder->status = 'cancelled';
            $lockedOrder->save();

            return true;
        }, 3);

        if (!$cancelled) {
            return redirect()
                ->route('buyer.orders.show', $order)
                ->with(
                    'error',
                    'Pesanan tidak dapat dibatalkan karena sudah tidak menunggu konfirmasi.'
                );
        }

        return redirect()
            ->route('buyer.orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan dan tidak lagi ditampilkan pada daftar pesanan.');
    }
}


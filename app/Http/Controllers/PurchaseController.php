<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    /**
     * Menampilkan daftar pembelian dengan pencarian,
     * filter status, filter tanggal, dan pagination.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => [
                'nullable',
                Rule::in(['draft', 'confirmed', 'cancelled']),
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

        $purchases = Purchase::with(['supplier', 'user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'purchase_number',
                        'like',
                        "%{$search}%"
                    )->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                        $supplierQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    })->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($dateFrom !== '', function ($query) use ($dateFrom) {
                $query->whereDate('purchased_at', '>=', $dateFrom);
            })
            ->when($dateTo !== '', function ($query) use ($dateTo) {
                $query->whereDate('purchased_at', '<=', $dateTo);
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('purchases.index', compact(
            'purchases',
            'search',
            'status',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Menampilkan formulir pembelian.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact(
            'suppliers',
            'products'
        ));
    }

    /**
     * Menyimpan draft pembelian dengan beberapa produk.
     * Stok belum berubah sampai pembelian dikonfirmasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => [
                'required',
                'integer',
                'exists:suppliers,id',
            ],
            'purchase_number' => [
                'required',
                'string',
                'max:100',
                'unique:purchases,purchase_number',
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
            'items.*.unit_cost' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $purchase = DB::transaction(function () use ($validated) {
            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'purchase_number' => $validated['purchase_number'],
                'total' => 0,
                'status' => 'draft',
                'purchased_at' => null,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $quantity = (int) $item['quantity'];
                $unitCost = round((float) $item['unit_cost'], 2);
                $subtotal = round($quantity * $unitCost, 2);

                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $purchase->update([
                'total' => round($total, 2),
            ]);

            return $purchase;
        });

        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'success',
                'Draft pembelian berhasil disimpan. Stok belum berubah.'
            );
    }

    /**
     * Menampilkan detail pembelian.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load([
            'supplier',
            'user',
            'items.product',
        ]);

        return view('purchases.show', compact('purchase'));
    }

    /**
     * Konfirmasi pembelian dan tambahkan stok.
     */
    public function confirm(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            $lockedPurchase = Purchase::whereKey($purchase->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPurchase->status !== 'draft') {
                throw ValidationException::withMessages([
                    'status' =>
                        'Hanya pembelian berstatus draft yang dapat dikonfirmasi.',
                ]);
            }

            $items = $lockedPurchase->items()
                ->orderBy('product_id')
                ->get();

            if ($items->isEmpty()) {
                throw ValidationException::withMessages([
                    'items' => 'Pembelian tidak memiliki item produk.',
                ]);
            }

            foreach ($items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $product->increment('stock', $item->quantity);
            }

            $lockedPurchase->update([
                'status' => 'confirmed',
                'purchased_at' => now(),
            ]);
        }, 3);

        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'success',
                'Pembelian berhasil dikonfirmasi dan stok produk telah bertambah.'
            );
    }

    /**
     * Membatalkan draft atau pembelian yang sudah dikonfirmasi.
     * Jika sudah dikonfirmasi, stok dikurangi kembali.
     */
    public function cancel(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            $lockedPurchase = Purchase::whereKey($purchase->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!in_array(
                $lockedPurchase->status,
                ['draft', 'confirmed'],
                true
            )) {
                throw ValidationException::withMessages([
                    'status' => 'Pembelian ini sudah dibatalkan.',
                ]);
            }

            $items = $lockedPurchase->items()
                ->orderBy('product_id')
                ->get();

            $lockedProducts = [];

            if ($lockedPurchase->status === 'confirmed') {
                // Kunci dan periksa semua produk terlebih dahulu.
                foreach ($items as $item) {
                    $product = Product::whereKey($item->product_id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    if ($product->stock < $item->quantity) {
                        throw ValidationException::withMessages([
                            'status' =>
                                'Pembatalan tidak dapat dilakukan karena stok '
                                . $product->name
                                . ' tidak mencukupi untuk mengembalikan '
                                . 'persediaan ke kondisi semula.',
                        ]);
                    }

                    $lockedProducts[$item->id] = $product;
                }

                // Kurangi stok setelah semua produk lolos pemeriksaan.
                foreach ($items as $item) {
                    $lockedProducts[$item->id]
                        ->decrement('stock', $item->quantity);
                }
            }

            $lockedPurchase->update([
                'status' => 'cancelled',
            ]);
        }, 3);

        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'success',
                'Pembelian berhasil dibatalkan. Penyesuaian stok telah diproses.'
            );
    }

    /**
     * Pembelian tidak diedit setelah dibuat.
     */
    public function edit(Purchase $purchase)
    {
        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'error',
                'Pembelian tidak dapat diedit. Batalkan draft dan buat transaksi baru.'
            );
    }

    public function update(Request $request, Purchase $purchase)
    {
        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'error',
                'Pembelian tidak dapat diubah. Batalkan draft dan buat transaksi baru.'
            );
    }

    /**
     * Riwayat pembelian tidak dihapus permanen.
     */
    public function destroy(Purchase $purchase)
    {
        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'error',
                'Riwayat pembelian tidak dapat dihapus permanen.'
            );
    }
}

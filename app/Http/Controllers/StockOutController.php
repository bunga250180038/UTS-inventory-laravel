<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::with(['product', 'user'])
            ->latest()
            ->paginate(10);

        return view('stock-outs.index', compact('stockOuts'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('stock-outs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'reference_number' => 'required|string|max:100|unique:stock_outs,reference_number',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($product->stock < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok tidak mencukupi. Stok tersedia: '
                        . $product->stock . ' unit.',
                ]);
            }

            StockOut::create([
                'product_id' => $product->id,
                'reference_number' => $validated['reference_number'],
                'quantity' => $validated['quantity'],
                'unit_price' => $validated['unit_price'],
                'transaction_date' => $validated['transaction_date'],
                'customer_name' => $validated['customer_name'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'user_id' => auth()->id(),
            ]);

            $product->decrement('stock', $validated['quantity']);
        });

        return redirect()
            ->route('stock-outs.index')
            ->with('success', 'Transaksi stok keluar berhasil disimpan dan stok produk berkurang.');
    }

    public function show(StockOut $stockOut)
    {
        $stockOut->load(['product', 'user']);

        return view('stock-outs.show', compact('stockOut'));
    }

    public function edit(StockOut $stockOut)
    {
        return redirect()
            ->route('stock-outs.index')
            ->with('error', 'Transaksi stok keluar tidak dapat diedit.');
    }

    public function update(Request $request, StockOut $stockOut)
    {
        return redirect()
            ->route('stock-outs.index')
            ->with('error', 'Transaksi stok keluar tidak dapat diubah.');
    }

    public function destroy(StockOut $stockOut)
    {
        return redirect()
            ->route('stock-outs.index')
            ->with('error', 'Riwayat stok keluar tidak dapat dihapus agar catatan persediaan tetap akurat.');
    }
}

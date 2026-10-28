<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index()
    {
        $stockIns = StockIn::with(['product', 'supplier', 'user'])
            ->latest()
            ->paginate(10);

        return view('stock-ins.index', compact('stockIns'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('stock-ins.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'reference_number' => 'required|string|max:100|unique:stock_ins,reference_number',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            StockIn::create([
                'product_id' => $validated['product_id'],
                'supplier_id' => $validated['supplier_id'] ?? null,
                'reference_number' => $validated['reference_number'],
                'quantity' => $validated['quantity'],
                'unit_cost' => $validated['unit_cost'],
                'transaction_date' => $validated['transaction_date'],
                'notes' => $validated['notes'] ?? null,
                'user_id' => auth()->id(),
            ]);

            $product->increment('stock', $validated['quantity']);
        });

        return redirect()
            ->route('stock-ins.index')
            ->with('success', 'Transaksi stok masuk berhasil disimpan dan stok produk bertambah.');
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load(['product', 'supplier', 'user']);

        return view('stock-ins.show', compact('stockIn'));
    }

    public function edit(StockIn $stockIn)
    {
        return redirect()
            ->route('stock-ins.index')
            ->with('error', 'Transaksi stok masuk tidak dapat diedit. Buat transaksi koreksi jika diperlukan.');
    }

    public function update(Request $request, StockIn $stockIn)
    {
        return redirect()
            ->route('stock-ins.index')
            ->with('error', 'Transaksi stok masuk tidak dapat diubah.');
    }

    public function destroy(StockIn $stockIn)
    {
        return redirect()
            ->route('stock-ins.index')
            ->with('error', 'Riwayat stok masuk tidak dapat dihapus agar catatan persediaan tetap akurat.');
    }
}

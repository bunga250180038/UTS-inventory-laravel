<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Sale;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $totalProducts = Product::count();

        $totalStock = Product::sum('stock');

        $lowStock = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        return view('reports.index', compact(
            'products',
            'totalProducts',
            'totalStock',
            'lowStock',
            'search'
        ));
    }

    
public function transactions(Request $request)
{
    $allowedTypes = ['all', 'in', 'out', 'purchase', 'sale'];

    $type = $request->input('type', 'all');

    if (!in_array($type, $allowedTypes, true)) {
        $type = 'all';
    }

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Stok Masuk lama
    $stockIns = StockIn::with(['product', 'supplier', 'user'])
        ->when(
            in_array($type, ['all', 'in'], true),
            function ($query) use ($startDate, $endDate) {
                $query->when($startDate, fn ($q) =>
                    $q->whereDate('transaction_date', '>=', $startDate)
                );

                $query->when($endDate, fn ($q) =>
                    $q->whereDate('transaction_date', '<=', $endDate)
                );
            },
            fn ($query) => $query->whereRaw('1 = 0')
        )
        ->get();

    // Stok Keluar lama
    $stockOuts = StockOut::with(['product', 'user'])
        ->when(
            in_array($type, ['all', 'out'], true),
            function ($query) use ($startDate, $endDate) {
                $query->when($startDate, fn ($q) =>
                    $q->whereDate('transaction_date', '>=', $startDate)
                );

                $query->when($endDate, fn ($q) =>
                    $q->whereDate('transaction_date', '<=', $endDate)
                );
            },
            fn ($query) => $query->whereRaw('1 = 0')
        )
        ->get();

    // Pembelian yang sudah dikonfirmasi
    $purchases = Purchase::with(['items.product', 'supplier', 'user'])
        ->where('status', 'confirmed')
        ->when(
            in_array($type, ['all', 'purchase'], true),
            function ($query) use ($startDate, $endDate) {
                $query->when($startDate, fn ($q) =>
                    $q->whereDate('purchased_at', '>=', $startDate)
                );

                $query->when($endDate, fn ($q) =>
                    $q->whereDate('purchased_at', '<=', $endDate)
                );
            },
            fn ($query) => $query->whereRaw('1 = 0')
        )
        ->get();

    // Penjualan yang sudah selesai
    $sales = Sale::with(['items.product', 'user'])
        ->where('status', 'completed')
        ->when(
            in_array($type, ['all', 'sale'], true),
            function ($query) use ($startDate, $endDate) {
                $query->when($startDate, fn ($q) =>
                    $q->whereDate('sold_at', '>=', $startDate)
                );

                $query->when($endDate, fn ($q) =>
                    $q->whereDate('sold_at', '<=', $endDate)
                );
            },
            fn ($query) => $query->whereRaw('1 = 0')
        )
        ->get();

    // Ubah Stok Masuk menjadi baris laporan
    $transactions = $stockIns->map(function ($item) {
        return [
            'date' => $item->transaction_date,
            'reference' => $item->reference_number,
            'type' => 'Stok Masuk',
            'product' => $item->product?->name ?? '-',
            'quantity' => $item->quantity,
            'price' => $item->unit_cost,
            'party' => $item->supplier?->name ?? '-',
        ];
    });

    // Tambahkan Stok Keluar
    $transactions = $transactions->concat(
        $stockOuts->map(function ($item) {
            return [
                'date' => $item->transaction_date,
                'reference' => $item->reference_number,
                'type' => 'Stok Keluar',
                'product' => $item->product?->name ?? '-',
                'quantity' => $item->quantity,
                'price' => $item->unit_price,
                'party' => $item->customer_name ?: '-',
            ];
        })
    );

    // Tambahkan semua item pembelian yang dikonfirmasi
    $transactions = $transactions->concat(
        $purchases->flatMap(function ($purchase) {
            return $purchase->items->map(function ($item) use ($purchase) {
                return [
                    'date' => $purchase->purchased_at,
                    'reference' => $purchase->purchase_number,
                    'type' => 'Pembelian',
                    'product' => $item->product?->name ?? '-',
                    'quantity' => $item->quantity,
                    'price' => $item->unit_cost,
                    'party' => $purchase->supplier?->name ?? '-',
                ];
            });
        })
    );

    // Tambahkan semua item penjualan yang selesai
    $transactions = $transactions->concat(
        $sales->flatMap(function ($sale) {
            return $sale->items->map(function ($item) use ($sale) {
                return [
                    'date' => $sale->sold_at,
                    'reference' => $sale->sale_number,
                    'type' => 'Penjualan',
                    'product' => $item->product?->name ?? '-',
                    'quantity' => $item->quantity,
                    'price' => $item->unit_price,
                    'party' => '-',
                ];
            });
        })
    );

    // Urutkan semua jenis transaksi dari tanggal terbaru
    $transactions = $transactions
        ->sortByDesc('date')
        ->values();

    return view('reports.transactions', compact(
        'transactions',
        'type',
        'startDate',
        'endDate'
    ));
    }
}
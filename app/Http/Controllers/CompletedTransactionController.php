<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompletedTransactionController extends Controller
{
    public function index(Request $request)
    {
        $purchaseQuery = DB::table('purchases')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('users', 'purchases.user_id', '=', 'users.id')
            ->where('purchases.status', 'confirmed')
            ->select([
                'purchases.id as transaction_id',
                'purchases.purchase_number as transaction_number',
                'purchases.purchased_at as transaction_date',
                'suppliers.name as party',
                'purchases.total as total',
                'purchases.status as status',
                'users.name as user_name',
            ])
            ->selectRaw("'Pembelian' as transaction_type");

        $salesQuery = DB::table('sales')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->where('sales.status', 'completed')
            ->select([
                'sales.id as transaction_id',
                'sales.sale_number as transaction_number',
                'sales.sold_at as transaction_date',
                DB::raw('NULL as party'),
                'sales.total as total',
                'sales.status as status',
                'users.name as user_name',
            ])
            ->selectRaw("'Penjualan' as transaction_type");

        $unionQuery = $purchaseQuery->unionAll($salesQuery);

        $transactions = DB::query()
            ->fromSub($unionQuery, 'completed_transactions');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $transactions->where(function ($query) use ($search) {
                $query->where(
                    'transaction_number',
                    'like',
                    "%{$search}%"
                )->orWhere(
                    'party',
                    'like',
                    "%{$search}%"
                )->orWhere(
                    'user_name',
                    'like',
                    "%{$search}%"
                );
            });
        }

        if ($request->filled('from_date')) {
            $transactions->whereDate(
                'transaction_date',
                '>=',
                $request->input('from_date')
            );
        }

        if ($request->filled('to_date')) {
            $transactions->whereDate(
                'transaction_date',
                '<=',
                $request->input('to_date')
            );
        }

        $transactions = $transactions
            ->orderByDesc('transaction_date')
            ->orderByDesc('transaction_id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'completed-transactions.index',
            compact('transactions')
        );
    }
}

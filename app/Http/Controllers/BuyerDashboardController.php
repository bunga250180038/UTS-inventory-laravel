<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $buyerId = auth()->id();

        // Ringkasan pesanan milik pembeli yang sedang login.
        $totalOrders = Order::where('buyer_id', $buyerId)->count();

        $pendingOrders = Order::where('buyer_id', $buyerId)
            ->where('status', 'pending')
            ->count();

        $confirmedOrders = Order::where('buyer_id', $buyerId)
            ->where('status', 'confirmed')
            ->count();

        $unpaidOrders = Order::where('buyer_id', $buyerId)
            ->where('payment_status', 'unpaid')
            ->count();

        // Lima pesanan terbaru milik pembeli ini saja.
        $recentOrders = Order::with(['items.product'])
            ->where('buyer_id', $buyerId)
            ->latest()
            ->take(5)
            ->get();

        // Produk yang stoknya masih tersedia.
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('buyer.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'confirmedOrders',
            'unpaidOrders',
            'recentOrders',
            'products'
        ));
    }
}
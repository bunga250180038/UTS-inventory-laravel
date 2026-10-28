<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BuyerCatalogController extends Controller
{
    /**
     * Menampilkan katalog produk untuk pembeli.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $products = Product::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('sku', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('catalog.index', compact('products', 'search'));
    }

    /**
     * Menampilkan detail satu produk.
     */
    public function show(Product $product)
    {
        $product->load('category');

        return view('catalog.show', compact('product'));
    }
}
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerAuthController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\BuyerCatalogController;
use App\Http\Controllers\BuyerOrderController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\CompletedTransactionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StaffProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\ReportController;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Sale;


// ==================================================
// HALAMAN UTAMA DAN LOGIN
// ==================================================

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/buyer/register', [BuyerAuthController::class, 'showRegister'])
    ->name('buyer.register');

Route::post('/buyer/register', [BuyerAuthController::class, 'register'])
    ->name('buyer.register.store');


// ==================================================
// ROUTE UNTUK PENGGUNA YANG SUDAH LOGIN
// ==================================================

Route::middleware('auth')->group(function () {

    // ----------------------------------------------
    // KHUSUS PEMBELI
    // ----------------------------------------------

    Route::middleware('role:buyer')->group(function () {

        // Dashboard Pembeli
        Route::get('/buyer/dashboard', [
            BuyerDashboardController::class,
            'index'
        ])->name('buyer.dashboard');

        // Katalog Produk
        Route::get('/catalog', [
            BuyerCatalogController::class,
            'index'
        ])->name('catalog.index');

        Route::get('/catalog/{product}', [
            BuyerCatalogController::class,
            'show'
        ])->name('catalog.show');

        // Membuat Pesanan
        Route::post('/buyer/orders', [
            BuyerOrderController::class,
            'store'
        ])->name('buyer.orders.store');

        // Riwayat Pesanan Pembeli
        Route::get('/buyer/orders', [
            BuyerOrderController::class,
            'index'
        ])->name('buyer.orders.index');

        // Detail Pesanan Pembeli
        Route::get('/buyer/orders/{order}', [
            BuyerOrderController::class,
            'show'
        ])->name('buyer.orders.show');

        // Membatalkan Pesanan Pembeli
        Route::patch('/buyer/orders/{order}/cancel', [
            BuyerOrderController::class,
            'cancel'
        ])->name('buyer.orders.cancel');
    });


    // ----------------------------------------------
    // LOGOUT
    // ----------------------------------------------

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    // ----------------------------------------------
    // DASHBOARD ADMIN DAN STAFF
    // ----------------------------------------------

    Route::get('/dashboard', function () {

        $completedSales = Sale::where('status', 'completed');

        $totalTransactions =
            Purchase::where('status', 'confirmed')->count()
            + Sale::where('status', 'completed')->count();

        $salesToday = Sale::where('status', 'completed')
            ->whereDate('sold_at', today())
            ->sum('total');

        $salesThisMonth = Sale::where('status', 'completed')
            ->whereYear('sold_at', now()->year)
            ->whereMonth('sold_at', now()->month)
            ->sum('total');

        return view('dashboard', [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalSuppliers' => Supplier::count(),

            'lowStockProducts' => Product::whereColumn(
                'stock',
                '<=',
                'minimum_stock'
            )->count(),

            'totalTransactions' => $totalTransactions,
            'totalSales' => (clone $completedSales)->count(),
            'salesToday' => $salesToday,
            'salesThisMonth' => $salesThisMonth,
        ]);

    })->middleware('role:admin,staff')->name('dashboard');


    // ----------------------------------------------
    // KHUSUS ADMIN
    // ----------------------------------------------

    Route::middleware('role:admin')->group(function () {

        // Manajemen kategori, produk, dan supplier
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);

        // Manajemen pengguna
        Route::resource('users', UserManagementController::class)
            ->except(['show']);

        // Konfirmasi pembelian
        Route::post(
            '/purchases/{purchase}/confirm',
            [PurchaseController::class, 'confirm']
        )->name('purchases.confirm');

        // Membatalkan pembelian
        Route::post(
            '/purchases/{purchase}/cancel',
            [PurchaseController::class, 'cancel']
        )->name('purchases.cancel');

        // Membatalkan penjualan
        Route::post(
            '/sales/{sale}/cancel',
            [SaleController::class, 'cancel']
        )->name('sales.cancel');
    });


    // ----------------------------------------------
    // ADMIN DAN STAFF
    // ----------------------------------------------

    Route::middleware('role:admin,staff')->group(function () {

        // Manajemen stok masuk dan keluar
        Route::resource('stock-ins', StockInController::class);
        Route::resource('stock-outs', StockOutController::class);

        // Pembelian
        Route::resource('purchases', PurchaseController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Pengelolaan Pesanan Pembeli
        Route::get('/orders', [
            OrderManagementController::class,
            'index'
        ])->name('orders.index');

        Route::get('/orders/{order}', [
            OrderManagementController::class,
            'show'
        ])->name('orders.show');

        Route::post('/orders/{order}/confirm', [
            OrderManagementController::class,
            'confirm'
        ])->name('orders.confirm');

        Route::post('/orders/{order}/reject', [
            OrderManagementController::class,
            'reject'
        ])->name('orders.reject');

        // Penjualan
        Route::resource('sales', SaleController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Tampilan produk khusus Staff
        Route::get('/data-produk', [
            StaffProductController::class,
            'index'
        ])->name('products.readonly');

        // Laporan
        Route::get('/reports', [
            ReportController::class,
            'index'
        ])->name('reports.index');

        Route::get('/reports/transactions', [
            ReportController::class,
            'transactions'
        ])->name('reports.transactions');

        // Transaksi selesai
        Route::get('/completed-transactions', [
            CompletedTransactionController::class,
            'index'
        ])->name('completed-transactions.index');
    });
});

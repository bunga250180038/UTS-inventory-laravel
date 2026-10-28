<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Inventory</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 235px;
            overflow-y: auto;
            padding: 25px 15px;
            background: #172554;
            color: white;
        }

        .sidebar h2 {
            font-size: 21px;
            margin: 0 0 30px;
        }

        .sidebar a {
            display: block;
            color: #dbeafe;
            text-decoration: none;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 7px;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        .main {
            margin-left: 235px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 27px;
        }

        .muted {
            color: #64748b;
            font-size: 13px;
            line-height: 1.7;
        }

        .card {
            background: white;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 3px 12px rgba(15,23,42,.03);
        }

        .notice {
            padding: 13px 15px;
            background: #eff6ff;
            color: #1e40af;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.7;
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin: 18px 0;
        }

        .search-form input {
            flex: 1;
            min-width: 0;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn {
            padding: 11px 16px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
        }

        .btn.secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            white-space: nowrap;
        }

        th {
            background: #f8fafc;
            color: #475569;
        }

        .badge {
            display: inline-block;
            border-radius: 20px;
            padding: 5px 9px;
            font-size: 11px;
            font-weight: bold;
        }

        .normal {
            background: #dcfce7;
            color: #166534;
        }

        .low {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            padding: 30px;
            text-align: center;
            color: #64748b;
        }

        .pagination {
            margin-top: 20px;
        }

        .logout {
            margin-top: 25px;
        }

        .logout button {
            width: 100%;
            padding: 12px;
            border: 1px solid #64748b;
            border-radius: 8px;
            background: transparent;
            color: white;
            cursor: pointer;
        }

        @media(max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            h1 {
                font-size: 23px;
            }

            .search-form {
                flex-wrap: wrap;
            }

            .search-form input {
                flex-basis: 100%;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>📦 Inventory</h2>

        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('categories.index') }}">🗂️ Kategori</a>
            <a href="{{ route('products.index') }}">📦 Kelola Produk</a>
            <a href="{{ route('suppliers.index') }}">🚚 Supplier</a>
        @else
            <a href="{{ route('products.readonly') }}" class="active">
                📋 Data Produk
            </a>
        @endif

        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a href="{{ route('reports.transactions') }}">🧾 Laporan Transaksi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">↪ Keluar dari Aplikasi</button>
        </form>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Data Produk</h1>
                <div class="muted">
                    Lihat informasi produk dan ketersediaan stok.
                </div>
            </div>
        </div>

        <section class="card">
            <div class="notice">
                ℹ️ Halaman ini hanya untuk melihat data produk.
                Perubahan, penambahan, dan penghapusan produk hanya dapat
                dilakukan oleh Admin.
            </div>

            <div class="muted">
                Total produk pada halaman ini: {{ $products->count() }}
            </div>

            <form action="{{ route('products.readonly') }}" method="GET"
                  class="search-form">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama produk atau SKU..."
                >

                <button type="submit" class="btn">Cari</button>

                <a href="{{ route('products.readonly') }}"
                   class="btn secondary">Reset</a>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Stok Minimum</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $products->firstItem() + $loop->index }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category?->name ?? '-' }}</td>
                                <td>
                                    Rp {{ number_format((float) $product->purchase_price, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ number_format($product->stock, 0, ',', '.') }}
                                    {{ $product->unit }}
                                </td>
                                <td>{{ number_format($product->minimum_stock, 0, ',', '.') }}</td>
                                <td>
                                    @if($product->stock <= $product->minimum_stock)
                                        <span class="badge low">Stok Menipis</span>
                                    @else
                                        <span class="badge normal">Normal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="empty">
                                    Tidak ada produk yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>
        </section>
    </main>
</body>
</html>

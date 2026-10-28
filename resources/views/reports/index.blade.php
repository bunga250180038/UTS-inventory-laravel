<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Persediaan - Inventory</title>
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
            width: 235px;
            height: 100vh;
            background: #172554;
            padding: 25px 15px;
            color: white;
        }
        .sidebar h2 { font-size: 21px; margin: 0 0 30px; }
        .sidebar a {
            display: block;
            color: #dbeafe;
            text-decoration: none;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 7px;
        }
        .sidebar a:hover, .sidebar .active { background: #2563eb; }
        .main { margin-left: 235px; padding: 30px; }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }
        h1 { margin: 0 0 8px; font-size: 27px; }
        h3 { margin-top: 0; }
        .muted { color: #64748b; font-size: 14px; }
        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }
        .stat {
            background: white;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 3px 12px #0f172a0a;
        }
        .stat-label { color: #64748b; font-size: 14px; }
        .stat-number { font-size: 29px; font-weight: bold; margin-top: 12px; }
        .card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 3px 12px #0f172a0a;
            margin-bottom: 22px;
        }
        .btn {
            display: inline-block;
            padding: 11px 16px;
            background: #2563eb;
            color: white;
            border: 0;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }
        .secondary { background: #e2e8f0; color: #334155; }
        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }
        .search-form input {
            flex: 1;
            min-width: 200px;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
        }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            white-space: nowrap;
        }
        th { background: #f8fafc; color: #475569; }
        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .low { background: #fee2e2; color: #b91c1c; }
        .normal { background: #dcfce7; color: #166534; }
        .empty { text-align: center; color: #64748b; padding: 30px; }
        .pagination { margin-top: 20px; }
        .logout { margin-top: 25px; }
        .logout button {
            width: 100%;
            padding: 12px;
            border: 1px solid #64748b;
            border-radius: 8px;
            background: transparent;
            color: white;
            cursor: pointer;
        }
        @media(max-width: 900px) {
            .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media(max-width: 700px) {
            .sidebar { position: static; width: 100%; height: auto; }
            .main { margin-left: 0; padding: 18px; }
            .cards { grid-template-columns: 1fr; }
            h1 { font-size: 23px; }
        }
        @media print {
            .sidebar, .no-print, .pagination { display: none !important; }
            .main { margin: 0; padding: 0; }
            body { background: white; }
            .card, .stat { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>📦 Inventory</h2>
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('categories.index') }}">🗂️ Kategori</a>
            <a href="{{ route('products.index') }}">📦 Produk</a>
            <a href="{{ route('suppliers.index') }}">🚚 Supplier</a>
        @endif
        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a href="{{ route('reports.index') }}" class="active">📊 Laporan Persediaan</a>
        <a href="{{ route('reports.transactions') }}">🧾 Laporan Transaksi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">Keluar ↗</button>
        </form>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Laporan Persediaan</h1>
                <div class="muted">Ringkasan kondisi persediaan produk saat ini.</div>
            </div>
            <button class="btn no-print" onclick="window.print()">🖨️ Cetak Laporan</button>
        </div>

        <section class="cards">
            <div class="stat">
                <div class="stat-label">Total Jenis Produk</div>
                <div class="stat-number">{{ number_format($totalProducts, 0, ',', '.') }}</div>
            </div>
            <div class="stat">
                <div class="stat-label">Total Unit Stok</div>
                <div class="stat-number">{{ number_format($totalStock, 0, ',', '.') }}</div>
            </div>
            <div class="stat">
                <div class="stat-label">Produk Stok Menipis</div>
                <div class="stat-number">{{ number_format($lowStock, 0, ',', '.') }}</div>
            </div>
        </section>

        <section class="card">
            <h3>Daftar Persediaan Produk</h3>
            <p class="muted">Cari produk berdasarkan nama atau kode SKU.</p>

            <form action="{{ route('reports.index') }}" method="GET" class="search-form no-print">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Masukkan nama produk atau SKU..."
                >
                <button type="submit" class="btn">Cari</button>
                <a href="{{ route('reports.index') }}" class="btn secondary">Reset</a>
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
                                <td>Rp {{ number_format((float) $product->purchase_price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}</td>
                                <td>{{ number_format($product->stock, 0, ',', '.') }} {{ $product->unit }}</td>
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
                                <td colspan="9" class="empty">Belum ada produk yang sesuai.</td>
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Keluar - Inventory</title>
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
        .muted { color: #64748b; font-size: 14px; }
        .card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 3px 12px #0f172a0a;
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
        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
            font-size: 14px;
        }
        th { background: #f8fafc; color: #475569; }
        .empty { text-align: center; color: #64748b; padding: 35px; }
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
        .pagination { margin-top: 20px; }
        @media(max-width: 700px) {
            .sidebar { position: static; width: 100%; height: auto; }
            .main { margin-left: 0; padding: 18px; }
            h1 { font-size: 23px; }
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
        <a href="{{ route('stock-outs.index') }}" class="active">📤 Stok Keluar</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">Keluar ↗</button>
        </form>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Stok Keluar</h1>
                <div class="muted">Catatan barang yang keluar dari persediaan.</div>
            </div>
            <a href="{{ route('stock-outs.create') }}" class="btn">+ Tambah Stok Keluar</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="error">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card">
            <div class="muted">
                Total transaksi pada halaman ini: {{ $stockOuts->count() }}
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>No. Referensi</th>
                            <th>Produk</th>
                            <th>Jumlah Keluar</th>
                            <th>Harga per Unit</th>
                            <th>Nama Pelanggan</th>
                            <th>Dicatat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockOuts as $item)
                            <tr>
                                <td>{{ $stockOuts->firstItem() + $loop->index }}</td>
                                <td>{{ $item->transaction_date?->format('d-m-Y') ?? '-' }}</td>
                                <td>{{ $item->reference_number }}</td>
                                <td>{{ $item->product?->name ?? '-' }}</td>
                                <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}</td>
                                <td>{{ $item->customer_name ?: '-' }}</td>
                                <td>{{ $item->user?->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty">
                                    Belum ada transaksi stok keluar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $stockOuts->links() }}
            </div>
        </section>
    </main>
</body>
</html>

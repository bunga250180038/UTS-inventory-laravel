<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan - Inventory</title>

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

        .sidebar h2 { font-size: 21px; margin: 0 0 30px; }

        .sidebar a {
            display: block;
            color: #dbeafe;
            text-decoration: none;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 7px;
            font-size: 13px;
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
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 { margin: 0 0 8px; font-size: 27px; }
        h3 { margin: 0 0 18px; font-size: 17px; }

        .muted {
            color: #64748b;
            font-size: 13px;
            line-height: 1.7;
        }

        .card {
            background: white;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            padding: 23px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px rgba(15,23,42,.03);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .label {
            color: #64748b;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .value {
            font-size: 14px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 13px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        th {
            background: #f8fafc;
            color: #475569;
        }

        .total-row td {
            font-weight: 800;
            background: #f8fafc;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .completed { background: #dcfce7; color: #166534; }
        .cancelled { background: #fee2e2; color: #991b1b; }

        .alert {
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.7;
        }

        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }

        .btn {
            display: inline-block;
            padding: 11px 16px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-secondary { background: #e2e8f0; color: #334155; }
        .btn-danger { background: #dc2626; }

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

        @media(max-width: 700px) {
            .sidebar { position: relative; width: 100%; height: auto; }
            .main { margin-left: 0; padding: 18px; }
            .grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('products.index') }}">📦 Kelola Produk</a>
            <a href="{{ route('suppliers.index') }}">🚚 Supplier</a>
        @else
            <a href="{{ route('products.readonly') }}">📋 Data Produk</a>
        @endif

        <a href="{{ route('purchases.index') }}">🛒 Pembelian</a>
        <a href="{{ route('sales.index') }}" class="active">🧾 Penjualan</a>
        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a href="{{ route('reports.transactions') }}">📈 Laporan Transaksi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">↪ Keluar dari Aplikasi</button>
        </form>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Detail Penjualan</h1>
                <div class="muted">
                    Rincian produk, harga, dan status transaksi penjualan.
                </div>
            </div>

            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                ← Kembali ke Penjualan
            </a>
        </div>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert error">
                <strong>Transaksi tidak dapat diproses:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card">
            <h3>Informasi Transaksi</h3>

            <div class="grid">
                <div>
                    <div class="label">Nomor Penjualan</div>
                    <div class="value">{{ $sale->sale_number }}</div>
                </div>

                <div>
                    <div class="label">Tanggal Penjualan</div>
                    <div class="value">
                        {{ $sale->sold_at?->format('d-m-Y H:i') ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="label">Dibuat Oleh</div>
                    <div class="value">{{ $sale->user?->name ?? '-' }}</div>
                </div>

                <div>
                    <div class="label">Status Transaksi</div>
                    <div class="value">
                        @if($sale->status === 'completed')
                            <span class="badge completed">Selesai</span>
                        @else
                            <span class="badge cancelled">Dibatalkan</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="card">
            <h3>Daftar Produk yang Dijual</h3>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga per Unit</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sale->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product?->sku ?? '-' }}</td>
                                <td>{{ $item->product?->name ?? '-' }}</td>
                                <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                <td>
                                    Rp {{ number_format((float)$item->unit_price, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format((float)$item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:25px;">
                                    Tidak ada item penjualan.
                                </td>
                            </tr>
                        @endforelse

                        <tr class="total-row">
                            <td colspan="5" style="text-align:right;">TOTAL PENJUALAN</td>
                            <td>
                                Rp {{ number_format((float)$sale->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        @if(auth()->user()->role === 'admin' && $sale->status === 'completed')
            <section class="card">
                <h3>Tindakan Admin</h3>

                <p class="muted">
                    Pembatalan akan mengembalikan jumlah stok yang terjual.
                    Jika produk tidak ditemukan, pembatalan akan ditolak agar
                    perubahan stok tidak dilakukan sebagian.
                </p>

                <form action="{{ route('sales.cancel', $sale) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Batalkan Penjualan dan Kembalikan Stok
                    </button>
                </form>
            </section>
        @endif
    </main>
</body>
</html>

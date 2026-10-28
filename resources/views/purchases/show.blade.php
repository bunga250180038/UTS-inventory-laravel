<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembelian - Inventory</title>

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
            flex-wrap: wrap;
            gap: 15px;
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

        .draft { background: #fef3c7; color: #92400e; }
        .confirmed { background: #dcfce7; color: #166534; }
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

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 16px;
            border: 0;
            border-radius: 8px;
            color: white;
            background: #2563eb;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover { background: #1d4ed8; }

        .btn-secondary { background: #e2e8f0; color: #334155; }
        .btn-secondary:hover { background: #cbd5e1; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }

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
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

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

        <a href="{{ route('purchases.index') }}" class="active">🛒 Pembelian</a>
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
                <h1>Detail Pembelian</h1>
                <div class="muted">
                    Rincian transaksi pembelian dan produk yang dipesan.
                </div>
            </div>

            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                ← Kembali ke Pembelian
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
                <strong>Transaksi belum dapat diproses:</strong>
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
                    <div class="label">Nomor Pembelian</div>
                    <div class="value">{{ $purchase->purchase_number }}</div>
                </div>

                <div>
                    <div class="label">Supplier</div>
                    <div class="value">{{ $purchase->supplier?->name ?? '-' }}</div>
                </div>

                <div>
                    <div class="label">Tanggal Dibuat</div>
                    <div class="value">{{ $purchase->created_at?->format('d-m-Y H:i') ?? '-' }}</div>
                </div>

                <div>
                    <div class="label">Dikonfirmasi Pada</div>
                    <div class="value">{{ $purchase->purchased_at?->format('d-m-Y H:i') ?? '-' }}</div>
                </div>

                <div>
                    <div class="label">Dibuat Oleh</div>
                    <div class="value">{{ $purchase->user?->name ?? '-' }}</div>
                </div>

                <div>
                    <div class="label">Status Pembelian</div>
                    <div class="value">
                        @if($purchase->status === 'draft')
                            <span class="badge draft">Draft</span>
                        @elseif($purchase->status === 'confirmed')
                            <span class="badge confirmed">Dikonfirmasi</span>
                        @else
                            <span class="badge cancelled">Dibatalkan</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="card">
            <h3>Daftar Item Pembelian</h3>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($purchase->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product?->sku ?? '-' }}</td>
                                <td>{{ $item->product?->name ?? '-' }}</td>
                                <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float)$item->unit_cost, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float)$item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:25px;">
                                    Belum ada item pembelian.
                                </td>
                            </tr>
                        @endforelse

                        <tr class="total-row">
                            <td colspan="5" style="text-align:right;">TOTAL PEMBELIAN</td>
                            <td>Rp {{ number_format((float)$purchase->total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        @if(auth()->user()->role === 'admin' && $purchase->status === 'draft')
            <section class="card">
                <h3>Tindakan Admin</h3>

                <p class="muted">
                    Pastikan supplier, produk, kuantitas, dan total pembelian sudah benar sebelum mengonfirmasi.
                    Stok baru bertambah setelah pembelian dikonfirmasi.
                </p>

                <div class="actions">
                    <form action="{{ route('purchases.confirm', $purchase) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">
                            ✓ Konfirmasi Pembelian
                        </button>
                    </form>

                    <form action="{{ route('purchases.cancel', $purchase) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Batalkan Draft
                        </button>
                    </form>
                </div>
            </section>
        @elseif(auth()->user()->role === 'admin' && $purchase->status === 'confirmed')
            <section class="card">
                <h3>Tindakan Admin</h3>

                <p class="muted">
                    Pembelian sudah dikonfirmasi. Pembatalan akan mengurangi kembali stok yang sebelumnya ditambahkan
                    jika jumlah stok masih mencukupi.
                </p>

                <form action="{{ route('purchases.cancel', $purchase) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Batalkan Pembelian
                    </button>
                </form>
            </section>
        @endif
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Inventory System</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 245px;
            flex-shrink: 0;
            padding: 25px 16px;
            background: #172554;
            color: white;
        }

        .brand {
            margin-bottom: 30px;
            font-size: 21px;
            font-weight: bold;
        }

        .menu {
            display: block;
            padding: 12px;
            margin-bottom: 6px;
            border-radius: 8px;
            color: #dbeafe;
            font-size: 13px;
            text-decoration: none;
        }

        .menu:hover, .menu.active {
            background: #2563eb;
            color: white;
        }

        .logout-button {
            width: 100%;
            padding: 12px;
            margin-top: 22px;
            border: 1px solid #64748b;
            border-radius: 8px;
            background: transparent;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 30px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #4338ca;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
            overflow-wrap: anywhere;
        }

        h2 {
            margin: 0 0 20px;
            font-size: 19px;
        }

        .muted {
            color: #64748b;
            font-size: 13px;
            line-height: 1.7;
        }

        .page-heading {
            margin-bottom: 25px;
        }

        .card {
            margin-bottom: 22px;
            padding: 24px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .04);
        }

        .alert {
            padding: 14px 16px;
            margin-bottom: 18px;
            border-radius: 9px;
            font-size: 14px;
            line-height: 1.7;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .order-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 22px;
        }

        .order-number {
            margin-bottom: 7px;
            font-size: 19px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .rejected, .cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-unknown {
            background: #e2e8f0;
            color: #334155;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .info-item {
            min-width: 0;
            padding: 15px;
            background: #f8fafc;
            border-radius: 9px;
        }

        .info-label {
            margin-bottom: 7px;
            color: #64748b;
            font-size: 12px;
        }

        .info-value {
            font-size: 14px;
            font-weight: bold;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 650px;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px 10px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            font-size: 13px;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 180px;
        }

        .product-image,
        .product-placeholder {
            width: 65px;
            height: 65px;
            flex-shrink: 0;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
        }

        .product-image {
            object-fit: contain;
            padding: 3px;
        }

        .product-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }

        .product-name {
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .product-sku {
            margin-top: 5px;
            color: #64748b;
            font-size: 11px;
        }

        .total-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
            padding: 18px;
            border-radius: 10px;
            background: #eef2ff;
        }

        .total-label {
            font-size: 14px;
            font-weight: bold;
        }

        .total-value {
            color: #3730a3;
            font-size: 23px;
            font-weight: bold;
        }

        .notice {
            padding: 15px;
            background: #f8fafc;
            color: #475569;
            border-radius: 9px;
            font-size: 13px;
            line-height: 1.8;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        .button {
            display: inline-block;
            padding: 12px 17px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .button-primary {
            background: #15803d;
            color: white;
        }

        .button-danger {
            background: #dc2626;
            color: white;
        }

        .button-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .button:hover {
            opacity: .87;
        }

        footer {
            padding: 25px;
            text-align: center;
            color: #64748b;
            font-size: 13px;
        }

        @media (max-width: 800px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
                padding: 18px;
            }

            .brand {
                margin-bottom: 15px;
            }

            .main {
                padding: 18px;
            }

            h1 {
                font-size: 23px;
            }

            .card {
                padding: 17px;
            }
        }

        @media (max-width: 550px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }

            .total-value {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">📦 Inventory System</div>

        <a class="menu" href="{{ route('dashboard') }}">🏠 Dashboard</a>
        <a class="menu active" href="{{ route('orders.index') }}">🛍️ Pesanan Pembeli</a>
        <a class="menu" href="{{ route('purchases.index') }}">🛒 Pembelian</a>
        <a class="menu" href="{{ route('sales.index') }}">🧾 Penjualan</a>
        <a class="menu" href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a class="menu" href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a class="menu" href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a class="menu" href="{{ route('reports.transactions') }}">📈 Laporan Transaksi</a>
        <a class="menu" href="{{ route('completed-transactions.index') }}">✅ Transaksi Selesai</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-button" type="submit">Keluar</button>
        </form>
    </aside>

    <main class="main">
        <a href="{{ route('orders.index') }}" class="back-link">
            ← Kembali ke Daftar Pesanan
        </a>

        <div class="page-heading">
            <h1>Detail Pesanan Pembeli</h1>
            <div class="muted">
                Periksa data pesanan sebelum mengambil tindakan.
            </div>
        </div>

        @if (session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <strong>Pesanan belum berhasil diproses:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $statusLabels = [
                'pending' => 'Menunggu Konfirmasi',
                'confirmed' => 'Disetujui',
                'rejected' => 'Ditolak',
                'cancelled' => 'Dibatalkan',
            ];

            $statusClasses = [
                'pending' => 'pending',
                'confirmed' => 'confirmed',
                'rejected' => 'rejected',
                'cancelled' => 'cancelled',
            ];
        @endphp

        <section class="card">
            <div class="order-heading">
                <div>
                    <div class="order-number">
                        {{ $order->order_number }}
                    </div>

                    <div class="muted">
                        Dibuat pada {{ $order->created_at->format('d-m-Y H:i') }}
                    </div>
                </div>

                <span class="status {{ $statusClasses[$order->status] ?? 'status-unknown' }}">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </span>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nama Pembeli</div>
                    <div class="info-value">
                        {{ $order->buyer->name ?? '-' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Email Pembeli</div>
                    <div class="info-value">
                        {{ $order->buyer->email ?? '-' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Nomor HP</div>
                    <div class="info-value">
                        {{ $order->customer_phone ?: '-' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Alamat Pengiriman</div>
                    <div class="info-value">
                        {{ $order->shipping_address ?: '-' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Tanggal Konfirmasi</div>
                    <div class="info-value">
                        {{ $order->confirmed_at ? $order->confirmed_at->format('d-m-Y H:i') : 'Belum dikonfirmasi' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Nomor Transaksi Penjualan</div>
                    <div class="info-value">
                        {{ $order->sale->sale_number ?? 'Belum ada transaksi penjualan' }}
                    </div>
                </div>
            </div>

            @if ($order->notes)
                <div class="info-item" style="margin-top: 15px;">
                    <div class="info-label">Catatan Pembeli</div>
                    <div class="info-value">{{ $order->notes }}</div>
                </div>
            @endif
        </section>

        <section class="card">
            <h2>Barang yang Dipesan</h2>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($order->items as $item)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    @if ($item->product && $item->product->image)
                                        <img
                                            class="product-image"
                                            src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="Foto {{ $item->product->name }}"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="product-placeholder">📦</div>
                                    @endif

                                    <div>
                                        <div class="product-name">
                                            {{ $item->product->name ?? 'Produk tidak tersedia' }}
                                        </div>

                                        <div class="product-sku">
                                            SKU: {{ $item->product->sku ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->quantity }}
                                {{ $item->product->unit ?? 'unit' }}
                            </td>

                            <td>
                                <strong>
                                    Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:25px;">
                                Pesanan tidak memiliki barang.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="total-box">
                <span class="total-label">Total Pesanan</span>

                <span class="total-value">
                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                </span>
            </div>
        </section>

        <section class="card">
            <h2>Tindakan Pengelola</h2>

            @if ($order->status === 'pending')
                <div class="notice">
                    Pesanan masih menunggu konfirmasi. Sebelum menyetujui, pastikan
                    stok seluruh barang mencukupi. Jika disetujui, sistem akan
                    membuat transaksi penjualan dan mengurangi stok sesuai jumlah
                    yang dipesan. Jika ditolak, stok tidak berubah.
                </div>

                <div class="actions">
                    <form
                        action="{{ route('orders.confirm', $order) }}"
                        method="POST"
                    >
                        @csrf

                        <button type="submit" class="button button-primary">
                            ✓ Setujui Pesanan
                        </button>
                    </form>

                    <form
                        action="{{ route('orders.reject', $order) }}"
                        method="POST"
                        onsubmit="return confirm('Tolak pesanan ini? Stok tidak akan dikurangi.');"
                    >
                        @csrf

                        <button type="submit" class="button button-danger">
                            ✕ Tolak Pesanan
                        </button>
                    </form>
                </div>
            @elseif ($order->status === 'confirmed')
                <div class="notice">
                    Pesanan telah disetujui dan transaksi penjualannya sudah dibuat.
                    Periksa nomor transaksi di atas untuk menelusuri penjualan.
                </div>
            @elseif ($order->status === 'rejected')
                <div class="notice">
                    Pesanan ini telah ditolak. Tidak ada stok yang dikurangi oleh
                    proses penolakan.
                </div>
            @elseif ($order->status === 'cancelled')
                <div class="notice">
                    Pesanan ini telah dibatalkan.
                </div>
            @endif

            <div class="actions">
                <a href="{{ route('orders.index') }}" class="button button-secondary">
                    Kembali ke Daftar Pesanan
                </a>
            </div>
        </section>
    </main>
</div>

<footer>
    Inventory Management System © {{ date('Y') }}
</footer>
</body>
</html>

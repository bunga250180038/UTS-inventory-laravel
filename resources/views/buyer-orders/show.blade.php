<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan | Inventory Store</title>

    <style>
        :root {
            --navy: #172554;
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --soft: #e8efff;
            --bg: #f4f7fc;
            --text: #17233f;
            --muted: #64748b;
            --border: #e2e8f0;
            --green: #15803d;
            --green-bg: #dcfce7;
            --orange: #b45309;
            --orange-bg: #fef3c7;
            --red: #b91c1c;
            --red-bg: #fee2e2;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a { text-decoration: none; color: inherit; }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .navbar {
            max-width: 1250px;
            min-height: 75px;
            padding: 13px 24px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .logo {
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: white;
            font-size: 22px;
            background: linear-gradient(135deg, var(--navy), var(--blue));
        }

        .brand-name {
            color: var(--navy);
            font-size: 18px;
            font-weight: 800;
        }

        .brand small {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-links a {
            padding: 11px 13px;
            border-radius: 9px;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--blue);
            background: var(--soft);
        }

        .account {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: var(--navy);
            background: #dbeafe;
            font-weight: 800;
        }

        .account-info {
            color: var(--muted);
            font-size: 11px;
        }

        .account-info strong {
            display: block;
            margin-top: 3px;
            color: var(--text);
            font-size: 12px;
        }

        .logout {
            padding: 10px 12px;
            border: 0;
            border-radius: 8px;
            background: var(--red-bg);
            color: var(--red);
            font-weight: 700;
            cursor: pointer;
        }

        .container {
            max-width: 1150px;
            min-height: calc(100vh - 160px);
            margin: auto;
            padding: 28px 24px 45px;
        }

        .breadcrumb {
            margin-bottom: 10px;
            color: var(--muted);
            font-size: 12px;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 23px;
        }

        .page-heading h1 {
            margin: 0 0 7px;
            color: var(--navy);
            font-size: 28px;
        }

        .page-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .back-button {
            display: inline-block;
            padding: 11px 15px;
            color: var(--blue);
            background: white;
            border: 1px solid var(--border);
            border-radius: 9px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .back-button:hover {
            background: var(--soft);
        }

        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 25px 28px;
            margin-bottom: 22px;
            color: white;
            background: linear-gradient(115deg, #1e3a8a, #2458d6 65%, #3978f6);
            border-radius: 15px;
            box-shadow: 0 9px 22px rgba(37, 99, 235, .10);
        }

        .hero h2 {
            margin: 0 0 9px;
            font-size: 21px;
            overflow-wrap: anywhere;
        }

        .hero p {
            margin: 0;
            color: #e7edff;
            font-size: 12px;
            line-height: 1.7;
        }

        .hero-icon {
            width: 70px;
            height: 70px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 17px;
            background: #ffffff20;
            font-size: 35px;
        }

        .layout {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(270px, .9fr);
            align-items: start;
            gap: 20px;
        }

        .panel {
            overflow: hidden;
            min-width: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            box-shadow: 0 4px 14px rgba(23, 37, 84, .025);
        }

        .panel-heading {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
        }

        .panel-heading h3 {
            margin: 0 0 6px;
            color: var(--navy);
            font-size: 15px;
        }

        .panel-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .panel-body {
            padding: 20px;
        }

        .status-box {
            margin-bottom: 20px;
            padding: 17px;
            background: #f8faff;
            border: 1px solid #e8edf7;
            border-radius: 10px;
        }

        .status-title {
            margin-bottom: 13px;
            color: var(--navy);
            font-size: 12px;
            font-weight: 800;
        }

        .badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .badge {
            display: inline-block;
            padding: 8px 11px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 800;
            line-height: 1.5;
        }

        .pending {
            color: var(--orange);
            background: var(--orange-bg);
        }

        .confirmed, .paid {
            color: var(--green);
            background: var(--green-bg);
        }

        .rejected, .failed {
            color: var(--red);
            background: var(--red-bg);
        }

        .unpaid, .default {
            color: #475569;
            background: #eef2f7;
        }

        .item-list {
            display: grid;
            gap: 12px;
        }

        .item-row {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .item-icon {
            width: 47px;
            height: 47px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 10px;
            background: var(--soft);
            font-size: 23px;
        }

        .item-info {
            flex: 1;
            min-width: 0;
        }

        .item-name {
            color: var(--navy);
            font-size: 12px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .item-meta {
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .item-subtotal {
            flex-shrink: 0;
            color: var(--blue-dark);
            font-size: 12px;
            font-weight: 800;
            text-align: right;
        }

        .total-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 13px;
            margin-top: 17px;
            padding: 17px;
            background: var(--soft);
            border-radius: 10px;
        }

        .total-box span {
            color: #334155;
            font-size: 12px;
            font-weight: 700;
        }

        .total-box strong {
            color: var(--blue-dark);
            font-size: 20px;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .info-list {
            display: grid;
            gap: 14px;
        }

        .info-row {
            display: grid;
            grid-template-columns: 1fr minmax(0, 1.25fr);
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #edf0f6;
        }

        .info-row:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .info-label {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .info-value {
            color: var(--navy);
            font-size: 11px;
            font-weight: 700;
            line-height: 1.7;
            text-align: right;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        .notes {
            margin-top: 17px;
            padding: 14px;
            color: #475569;
            background: #f8faff;
            border: 1px solid #e8edf7;
            border-radius: 9px;
            font-size: 11px;
            line-height: 1.8;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        .notes strong {
            display: block;
            margin-bottom: 5px;
            color: var(--navy);
        }

        .information-note {
            margin-top: 18px;
            padding: 14px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #1e40af;
            border-radius: 10px;
            font-size: 11px;
            line-height: 1.8;
        }

        .information-note strong {
            display: block;
            margin-bottom: 4px;
        }

        .footer-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 16px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 800;
        }

        .button-primary {
            color: white;
            background: var(--blue);
        }

        .button-primary:hover {
            background: var(--blue-dark);
        }

        .button-secondary {
            color: var(--blue);
            background: white;
            border: 1px solid var(--border);
        }

        .button-secondary:hover {
            background: var(--soft);
        }

        .footer {
            padding: 23px 15px;
            color: var(--muted);
            background: white;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 11px;
            line-height: 1.8;
        }

        .footer strong {
            color: var(--navy);
        }

        @media (max-width: 850px) {
            .account-info { display: none; }
            .layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 620px) {
            .navbar {
                padding: 12px 14px;
                flex-wrap: wrap;
            }

            .brand { flex: 1; }
            .brand small { display: none; }

            .nav-links {
                order: 3;
                width: 100%;
                display: flex;
                overflow-x: auto;
                padding-top: 8px;
                border-top: 1px solid var(--border);
            }

            .nav-links a {
                padding: 10px;
                font-size: 11px;
            }

            .container {
                padding: 20px 14px 32px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .hero {
                padding: 21px;
            }

            .hero h2 { font-size: 19px; }
            .hero-icon { display: none; }

            .panel-body { padding: 15px; }

            .item-row {
                align-items: flex-start;
                flex-wrap: wrap;
                gap: 10px;
            }

            .item-subtotal {
                width: 100%;
                text-align: left;
                padding-left: 57px;
            }

            .footer-actions .button { flex: 1; }
        }
    </style>
</head>

<body>

<header class="topbar">
    <div class="navbar">

        <a href="{{ route('buyer.dashboard') }}" class="brand">
            <div class="logo">📦</div>
            <div>
                <div class="brand-name">Inventory Store</div>
                <small>Belanja mudah dan praktis</small>
            </div>
        </a>

        <nav class="nav-links" aria-label="Menu Pembeli">
            <a href="{{ route('buyer.dashboard') }}">🏠 Beranda</a>
            <a href="{{ route('catalog.index') }}">🛍️ Katalog Produk</a>
            <a href="{{ route('buyer.orders.index') }}" class="active">📦 Pesanan Saya</a>
        </nav>

        <div class="account">
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
            </div>

            <div class="account-info">
                Halo,
                <strong>{{ auth()->user()->name ?? 'Pembeli' }}</strong>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout" type="submit">Keluar</button>
            </form>
        </div>

    </div>
</header>

<main class="container">

    <div class="breadcrumb">
        Inventory Store / Pesanan Saya / Detail Pesanan
    </div>

    <div class="page-heading">
        <div>
            <h1>Detail Pesanan</h1>
            <p>Periksa informasi produk, pengiriman, dan pembayaran pesananmu.</p>
        </div>

        <a href="{{ route('buyer.orders.index') }}" class="back-button">
            ← Kembali ke Pesanan
        </a>
    </div>

    <section class="hero">
        <div>
            <h2>Pesanan {{ $order->order_number }}</h2>
            <p>
                Dibuat pada
                {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}.
                Simpan nomor pesanan ini untuk memeriksa statusnya.
            </p>
        </div>

        <div class="hero-icon">📦</div>
    </section>

    <div class="layout">

        <section class="panel">

            <div class="panel-heading">
                <h3>🛍️ Produk yang Dipesan</h3>
                <p>Rincian jumlah barang dan harga pada pesanan ini.</p>
            </div>

            <div class="panel-body">

                <div class="status-box">
                    <div class="status-title">Status Pesanan dan Pembayaran</div>

                    <div class="badges">
                        @if ($order->status === 'pending')
                            <span class="badge pending">Menunggu Konfirmasi</span>
                        @elseif ($order->status === 'confirmed')
                            <span class="badge confirmed">Pesanan Dikonfirmasi</span>
                        @elseif ($order->status === 'rejected')
                            <span class="badge rejected">Pesanan Ditolak</span>
                        @else
                            <span class="badge default">
                                {{ ucfirst(str_replace('_', ' ', $order->status ?? 'Diproses')) }}
                            </span>
                        @endif

                        @if (($order->payment_status ?? 'unpaid') === 'paid')
                            <span class="badge paid">Sudah Dibayar</span>
                        @elseif (($order->payment_status ?? '') === 'failed')
                            <span class="badge failed">Pembayaran Gagal</span>
                        @else
                            <span class="badge unpaid">Belum Dibayar</span>
                        @endif
                    </div>
                </div>

                <div class="item-list">
                    @forelse ($order->items as $item)
                        <div class="item-row">

                            <div class="item-icon">📦</div>

                            <div class="item-info">
                                <div class="item-name">
                                    {{ $item->product?->name ?? 'Produk tidak tersedia' }}
                                </div>

                                <div class="item-meta">
                                    Kode:
                                    {{ $item->product?->sku ?? '-' }}
                                    <br>
                                    Jumlah: {{ $item->quantity }}
                                    × Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="item-subtotal">
                                Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                            </div>

                        </div>
                    @empty
                        <p>Detail barang untuk pesanan ini tidak tersedia.</p>
                    @endforelse
                </div>

                <div class="total-box">
                    <span>Total Pesanan</span>
                    <strong>Rp {{ number_format((float) $order->total, 0, ',', '.') }}</strong>
                </div>

                <div class="information-note">
                    <strong>ℹ️ Informasi Pembayaran</strong>
                    Status pembayaran mengikuti catatan sistem. Jika status masih
                    Belum Dibayar, pesanan belum tercatat sebagai pembayaran lunas.
                    Pastikan instruksi pembayaran diperoleh dari pihak toko.
                </div>

            </div>
        </section>

        <aside>

            <section class="panel">
                <div class="panel-heading">
                    <h3>📋 Informasi Pesanan</h3>
                    <p>Metode pembayaran dan nomor transaksi.</p>
                </div>

                <div class="panel-body">
                    <div class="info-list">

                        <div class="info-row">
                            <span class="info-label">Nomor Pesanan</span>
                            <span class="info-value">{{ $order->order_number }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Tanggal Pesanan</span>
                            <span class="info-value">
                                {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Metode Pembayaran</span>
                            <span class="info-value">
                                @switch($order->payment_method)
                                    @case('cod')
                                        Bayar di Tempat (COD)
                                        @break
                                    @case('bank_transfer')
                                        Transfer Bank
                                        @break
                                    @case('e_wallet')
                                        E-Wallet
                                        @break
                                    @default
                                        Belum dipilih
                                @endswitch
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Status Pembayaran</span>
                            <span class="info-value">
                                @if (($order->payment_status ?? 'unpaid') === 'paid')
                                    Sudah Dibayar
                                @elseif (($order->payment_status ?? '') === 'failed')
                                    Gagal
                                @else
                                    Belum Dibayar
                                @endif
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Dikonfirmasi Pada</span>
                            <span class="info-value">
                                {{ $order->confirmed_at?->format('d M Y, H:i') ?? 'Belum dikonfirmasi' }}
                            </span>
                        </div>

                        @if ($order->sale)
                            <div class="info-row">
                                <span class="info-label">Nomor Penjualan</span>
                                <span class="info-value">
                                    {{ $order->sale->sale_number ?? $order->sale->invoice_number ?? '-' }}
                                </span>
                            </div>
                        @endif

                    </div>
                </div>
            </section>

            <section class="panel" style="margin-top:18px;">
                <div class="panel-heading">
                    <h3>🚚 Informasi Pengiriman</h3>
                    <p>Data tujuan pengiriman pesanan.</p>
                </div>

                <div class="panel-body">
                    <div class="info-list">

                        <div class="info-row">
                            <span class="info-label">Nama Penerima</span>
                            <span class="info-value">
                                {{ $order->buyer?->name ?? auth()->user()->name }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Nomor Telepon</span>
                            <span class="info-value">
                                {{ $order->customer_phone ?: '-' }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Alamat Pengiriman</span>
                            <span class="info-value">
                                {{ $order->shipping_address ?: '-' }}
                            </span>
                        </div>

                    </div>

                    @if ($order->notes)
                        <div class="notes">
                            <strong>Catatan Pesanan</strong>
                            {{ $order->notes }}
                        </div>
                    @endif

                </div>
            </section>

        </aside>

    </div>

    <div class="footer-actions">
        <a href="{{ route('buyer.orders.index') }}" class="button button-primary">
            ← Kembali ke Pesanan Saya
        </a>

        <a href="{{ route('catalog.index') }}" class="button button-secondary">
            🛍️ Lihat Katalog Produk
        </a>
    </div>

</main>

<footer class="footer">
    <strong>Inventory Store</strong><br>
    Inventory Management System © {{ date('Y') }}
</footer>

</body>
</html>

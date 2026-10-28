<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembeli - Inventory Store</title>

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
            background: white;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar {
            max-width: 1300px;
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
            flex-shrink: 0;
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
            font-size: 13px;
            font-weight: 700;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--blue);
            background: var(--soft);
        }

        .account {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #dbeafe;
            color: var(--navy);
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
            max-width: 1300px;
            margin: auto;
            padding: 28px 24px 45px;
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 10px;
        }

        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .page-title h1 {
            margin: 0 0 7px;
            color: var(--navy);
            font-size: 28px;
        }

        .page-title p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .date {
            padding: 11px 13px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: white;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .hero {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 35px;
            color: white;
            background: linear-gradient(115deg, #1e3a8a, #2458d6 65%, #3978f6);
            border-radius: 18px;
            box-shadow: 0 12px 25px #2563eb18;
        }

        .hero-content {
            max-width: 760px;
            position: relative;
            z-index: 1;
        }

        .hero-label {
            display: inline-block;
            margin-bottom: 14px;
            padding: 8px 12px;
            border-radius: 25px;
            background: #ffffff20;
            font-size: 11px;
            font-weight: 700;
        }

        .hero h2 {
            margin: 0 0 12px;
            font-size: clamp(25px, 3vw, 35px);
            line-height: 1.3;
        }

        .hero p {
            margin: 0;
            max-width: 620px;
            color: #e7edff;
            font-size: 13px;
            line-height: 1.8;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 16px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 800;
        }

        .btn-white {
            background: white;
            color: var(--navy);
        }

        .btn-outline {
            border: 1px solid #ffffff66;
            color: white;
            background: #ffffff14;
        }

        .hero-icon {
            width: 130px;
            height: 130px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 50%;
            background: #ffffff18;
            font-size: 65px;
        }

        .section { margin-top: 30px; }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .section-heading h2 {
            margin: 0 0 6px;
            color: var(--navy);
            font-size: 21px;
        }

        .section-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .text-link {
            color: var(--blue);
            font-size: 12px;
            font-weight: 800;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
        }

        .stat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 19px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .stat-number {
            margin-top: 9px;
            color: var(--navy);
            font-size: 29px;
            font-weight: 800;
        }

        .stat-note {
            margin-top: 6px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 12px;
            background: var(--soft);
            font-size: 22px;
        }

        .orange { background: var(--orange-bg); }
        .green { background: var(--green-bg); }

        .columns {
            display: grid;
            grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }

        .panel {
            min-width: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 18px;
            border-bottom: 1px solid var(--border);
        }

        .panel-heading h3 {
            margin: 0 0 5px;
            color: var(--navy);
            font-size: 15px;
        }

        .panel-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 11px;
        }

        .panel-body { padding: 18px; }

        .order {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            padding: 15px 0;
            border-bottom: 1px solid #edf0f6;
        }

        .order:first-child { padding-top: 0; }
        .order:last-child { padding-bottom: 0; border-bottom: 0; }

        .order-number {
            color: var(--navy);
            font-size: 12px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .muted {
            margin-top: 6px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.6;
        }

        .order-products {
            margin-top: 8px;
            color: #475569;
            font-size: 11px;
            line-height: 1.6;
        }

        .total {
            margin-top: 9px;
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 800;
        }

        .order-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 7px;
            flex-shrink: 0;
        }

        .pill {
            display: inline-block;
            max-width: 145px;
            padding: 7px 9px;
            border-radius: 7px;
            text-align: center;
            font-size: 10px;
            font-weight: 800;
            line-height: 1.4;
        }

        .pending { color: var(--orange); background: var(--orange-bg); }
        .confirmed, .paid { color: var(--green); background: var(--green-bg); }
        .rejected, .failed { color: var(--red); background: var(--red-bg); }
        .unpaid, .default { color: #475569; background: #eef2f7; }

        .empty {
            padding: 24px 10px;
            text-align: center;
        }

        .empty-icon { font-size: 38px; margin-bottom: 9px; }

        .empty h4 {
            margin: 0 0 7px;
            color: var(--navy);
        }

        .empty p {
            max-width: 280px;
            margin: 0 auto 15px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .product {
            overflow: hidden;
            min-width: 0;
            border: 1px solid var(--border);
            border-radius: 11px;
        }

        .product img, .placeholder {
            display: block;
            width: 100%;
            height: 150px;
            padding: 10px;
            object-fit: contain;
            background: #f3f6fc;
        }

        .placeholder {
            display: grid;
            place-items: center;
            font-size: 43px;
        }

        .product-info { padding: 12px; }

        .category {
            display: inline-block;
            margin-bottom: 8px;
            padding: 5px 7px;
            color: var(--blue-dark);
            background: var(--soft);
            border-radius: 5px;
            font-size: 9px;
            font-weight: 800;
        }

        .product h4 {
            margin: 0;
            color: var(--navy);
            font-size: 12px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .sku {
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;
        }

        .price {
            margin-top: 10px;
            color: var(--blue-dark);
            font-size: 15px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .stock {
            margin-top: 7px;
            color: var(--green);
            font-size: 10px;
            font-weight: 700;
        }

        .product-button {
            display: block;
            margin-top: 11px;
            padding: 10px 6px;
            color: white;
            background: var(--blue);
            border-radius: 7px;
            text-align: center;
            font-size: 11px;
            font-weight: 800;
        }

        .product-button:hover { background: var(--blue-dark); }

        .no-products {
            padding: 25px;
            color: var(--muted);
            text-align: center;
            font-size: 12px;
            line-height: 1.7;
        }

        .payments {
            padding: 20px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .payment {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px;
            background: #f8faff;
            border: 1px solid #e7edf7;
            border-radius: 10px;
        }

        .payment-icon { font-size: 23px; }

        .payment strong {
            display: block;
            margin-bottom: 4px;
            color: var(--navy);
            font-size: 11px;
        }

        .payment small {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .help {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-top: 20px;
            padding: 20px;
            color: white;
            background: var(--navy);
            border-radius: 12px;
        }

        .help h3 { margin: 0 0 7px; font-size: 15px; }

        .help p {
            margin: 0;
            color: #dbeafe;
            font-size: 11px;
            line-height: 1.7;
        }

        .help a {
            flex-shrink: 0;
            padding: 11px 13px;
            color: var(--navy);
            background: white;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
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

        .footer strong { color: var(--navy); }

        @media (max-width: 1050px) {
            .account-info { display: none; }
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .columns { grid-template-columns: 1fr; }
        }

        @media (max-width: 720px) {
            .navbar { padding: 12px 14px; flex-wrap: wrap; gap: 10px; }
            .brand { flex: 1; }
            .brand small { display: none; }
            .nav-links {
                order: 3;
                width: 100%;
                overflow-x: auto;
                padding-top: 8px;
                border-top: 1px solid var(--border);
            }
            .nav-links a { white-space: nowrap; padding: 10px; font-size: 12px; }
            .container { padding: 20px 14px 32px; }
            .page-title { align-items: flex-start; flex-direction: column; }
            .hero { padding: 26px 21px; }
            .hero h2 { font-size: 25px; }
            .hero-icon { width: 85px; height: 85px; font-size: 42px; }
            .stats { gap: 10px; }
            .stat { padding: 14px; align-items: flex-start; flex-direction: column-reverse; }
            .stat-number { font-size: 25px; }
            .products { gap: 10px; }
            .payment-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 430px) {
            .brand-name { font-size: 16px; }
            .hero-icon { display: none; }
            .order { flex-direction: column; }
            .order-status { align-items: flex-start; }
            .help { align-items: flex-start; flex-direction: column; }
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

        <nav class="nav-links">
            <a href="{{ route('buyer.dashboard') }}" class="active">🏠 Beranda</a>
            <a href="{{ route('catalog.index') }}">🛍️ Katalog Produk</a>
            <a href="{{ route('buyer.orders.index') }}">📦 Pesanan Saya</a>
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
    <div class="breadcrumb">Inventory Store / Beranda Pembeli</div>

    <div class="page-title">
        <div>
            <h1>Dashboard Pembeli</h1>
            <p>Selamat datang! Pantau pesanan dan temukan produk yang kamu butuhkan.</p>
        </div>
        <div class="date">📅 {{ now()->format('d M Y') }}</div>
    </div>

    @if (session('success'))
        <div style="margin-bottom:18px;padding:13px 16px;border-radius:9px;color:#166534;background:#dcfce7;font-size:13px">
            ✅ {{ session('success') }}
        </div>
    @endif

    <section class="hero">
        <div class="hero-content">
            <span class="hero-label">✨ INVENTORY STORE · PEMBELI</span>
            <h2>Hai, {{ auth()->user()->name ?? 'Pembeli' }}!<br>Siap menemukan produk favoritmu?</h2>
            <p>
                Jelajahi produk yang tersedia, pesan dengan mudah, pilih metode
                pembayaran, dan pantau status pesananmu dari satu halaman.
            </p>
            <div class="hero-actions">
                <a href="{{ route('catalog.index') }}" class="btn btn-white">🛍️ Mulai Belanja</a>
                <a href="{{ route('buyer.orders.index') }}" class="btn btn-outline">📦 Lihat Pesanan</a>
            </div>
        </div>
        <div class="hero-icon">🛒</div>
    </section>

    <section class="section">
        <div class="section-heading">
            <div>
                <h2>Ringkasan Aktivitas</h2>
                <p>Ringkasan pesanan dari akun kamu.</p>
            </div>
        </div>

        <div class="stats">
            <div class="stat">
                <div>
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
                    <div class="stat-note">Semua pesanan akun kamu</div>
                </div>
                <div class="stat-icon">📦</div>
            </div>

            <div class="stat">
                <div>
                    <div class="stat-label">Menunggu Konfirmasi</div>
                    <div class="stat-number">{{ $pendingOrders ?? 0 }}</div>
                    <div class="stat-note">Menunggu diproses toko</div>
                </div>
                <div class="stat-icon orange">⏳</div>
            </div>

            <div class="stat">
                <div>
                    <div class="stat-label">Pesanan Dikonfirmasi</div>
                    <div class="stat-number">{{ $confirmedOrders ?? 0 }}</div>
                    <div class="stat-note">Pesanan telah disetujui</div>
                </div>
                <div class="stat-icon green">✅</div>
            </div>

            <div class="stat">
                <div>
                    <div class="stat-label">Belum Dibayar</div>
                    <div class="stat-number">{{ $unpaidOrders ?? 0 }}</div>
                    <div class="stat-note">Sesuai status pembayaran</div>
                </div>
                <div class="stat-icon orange">💳</div>
            </div>
        </div>
    </section>

    <section class="section columns">
        <div class="panel">
            <div class="panel-heading">
                <div>
                    <h3>Pesanan Terbaru</h3>
                    <p>Riwayat pesanan terbaru kamu.</p>
                </div>
                <a class="text-link" href="{{ route('buyer.orders.index') }}">Lihat Semua →</a>
            </div>

            <div class="panel-body">
                @forelse (($recentOrders ?? collect()) as $order)
                    <div class="order">
                        <div>
                            <div class="order-number">{{ $order->order_number }}</div>
                            <div class="muted">{{ $order->created_at?->format('d M Y, H:i') ?? '-' }}</div>

                            <div class="order-products">
                                {{ $order->items->pluck('product.name')->filter()->implode(', ') ?: 'Detail produk tidak tersedia' }}
                            </div>

                            <div class="total">
                                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                            </div>

                            <div class="muted">
                                Metode:
                                @switch($order->payment_method)
                                    @case('cod') COD @break
                                    @case('bank_transfer') Transfer Bank @break
                                    @case('e_wallet') E-Wallet @break
                                    @default Belum dipilih
                                @endswitch
                            </div>
                        </div>

                        <div class="order-status">
                            @if ($order->status === 'pending')
                                <span class="pill pending">Menunggu Konfirmasi</span>
                            @elseif ($order->status === 'confirmed')
                                <span class="pill confirmed">Dikonfirmasi</span>
                            @elseif ($order->status === 'rejected')
                                <span class="pill rejected">Ditolak</span>
                            @else
                                <span class="pill default">
                                    {{ ucfirst(str_replace('_', ' ', $order->status ?? 'Diproses')) }}
                                </span>
                            @endif

                            @if (($order->payment_status ?? 'unpaid') === 'paid')
                                <span class="pill paid">Sudah Dibayar</span>
                            @elseif (($order->payment_status ?? '') === 'failed')
                                <span class="pill failed">Pembayaran Gagal</span>
                            @else
                                <span class="pill unpaid">Belum Dibayar</span>
                            @endif

                            <a class="text-link" href="{{ route('buyer.orders.show', $order) }}">Detail →</a>
                        </div>
                    </div>
                @empty
                    <div class="empty">
                        <div class="empty-icon">🛍️</div>
                        <h4>Belum Ada Pesanan</h4>
                        <p>
                            Kamu belum membuat pesanan. Jelajahi katalog
                            untuk menemukan produk yang kamu butuhkan.
                        </p>
                        <a class="btn" style="background:#2563eb;color:white" href="{{ route('catalog.index') }}">
                            Mulai Belanja →
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <div>
                    <h3>Produk Tersedia</h3>
                    <p>Pilihan produk dengan stok tersedia.</p>
                </div>
                <a class="text-link" href="{{ route('catalog.index') }}">Katalog →</a>
            </div>

            <div class="panel-body">
                @if (isset($products) && $products->isNotEmpty())
                    <div class="products">
                        @foreach ($products as $product)
                            <article class="product">
                                <a href="{{ route('catalog.show', $product) }}">
                                    @if ($product->image)
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="placeholder">📦</div>
                                    @endif
                                </a>

                                <div class="product-info">
                                    <span class="category">
                                        {{ optional($product->category)->name ?? 'Umum' }}
                                    </span>

                                    <h4>{{ $product->name }}</h4>
                                    <div class="sku">Kode: {{ $product->sku ?? '-' }}</div>

                                    <div class="price">
                                        Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                                    </div>

                                    <div class="stock">✓ Stok: {{ $product->stock }}</div>

                                    <a class="product-button" href="{{ route('catalog.show', $product) }}">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="no-products">
                        Belum ada produk dengan stok tersedia.
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="section payments">
        <div class="section-heading">
            <div>
                <h2>Metode Pembayaran</h2>
                <p>Pilihan yang tersedia saat membuat pesanan.</p>
            </div>
        </div>

        <div class="payment-grid">
            <div class="payment">
                <span class="payment-icon">🚚</span>
                <div>
                    <strong>COD</strong>
                    <small>Bayar di tempat sesuai proses toko.</small>
                </div>
            </div>

            <div class="payment">
                <span class="payment-icon">🏦</span>
                <div>
                    <strong>Transfer Bank</strong>
                    <small>Ikuti informasi resmi dari toko.</small>
                </div>
            </div>

            <div class="payment">
                <span class="payment-icon">📱</span>
                <div>
                    <strong>E-Wallet</strong>
                    <small>Gunakan petunjuk pembayaran resmi.</small>
                </div>
            </div>
        </div>
    </section>

    <section class="help">
        <div>
            <h3>Butuh memeriksa pesanan?</h3>
            <p>
                Buka Pesanan Saya untuk memeriksa rincian, metode pembayaran,
                dan status pesanan kamu.
            </p>
        </div>
        <a href="{{ route('buyer.orders.index') }}">Buka Pesanan Saya →</a>
    </section>
</main>

<footer class="footer">
    <strong>Inventory Store</strong><br>
    Sistem informasi produk dan pesanan pembeli.
</footer>

</body>
</html>

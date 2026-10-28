<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | Inventory Store</title>

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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: inherit;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            background: white;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(23, 37, 84, .04);
        }

        .navbar {
            max-width: 1300px;
            min-height: 76px;
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
            font-size: 13px;
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
            font-size: 12px;
            cursor: pointer;
        }

        .container {
            max-width: 1200px;
            min-height: calc(100vh - 155px);
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
            gap: 16px;
            margin-bottom: 23px;
        }

        .page-heading h1 {
            margin: 0 0 7px;
            color: var(--navy);
            font-size: 29px;
            letter-spacing: -.5px;
        }

        .page-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .order-count {
            flex-shrink: 0;
            padding: 12px 15px;
            color: var(--blue-dark);
            background: var(--soft);
            border-radius: 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 27px 30px;
            margin-bottom: 25px;
            color: white;
            background: linear-gradient(115deg, #1e3a8a, #2458d6 65%, #3978f6);
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(37, 99, 235, .1);
        }

        .hero h2 {
            margin: 0 0 9px;
            font-size: 23px;
        }

        .hero p {
            margin: 0;
            color: #e7edff;
            font-size: 13px;
            line-height: 1.7;
        }

        .hero-icon {
            width: 75px;
            height: 75px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            background: #ffffff20;
            border-radius: 18px;
            font-size: 38px;
        }

        .message {
            padding: 14px 17px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 13px;
            line-height: 1.7;
        }

        .message.success {
            color: #166534;
            background: var(--green-bg);
            border: 1px solid #bbf7d0;
        }

        .message.error {
            color: var(--red);
            background: var(--red-bg);
            border: 1px solid #fecaca;
        }

        .section-heading {
            margin-bottom: 15px;
        }

        .section-heading h2 {
            margin: 0 0 6px;
            color: var(--navy);
            font-size: 20px;
        }

        .section-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .order-list {
            display: grid;
            gap: 17px;
        }

        .order-card {
            overflow: hidden;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(23, 37, 84, .025);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            padding: 19px 21px;
            background: #fbfcff;
            border-bottom: 1px solid var(--border);
        }

        .order-label {
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .order-number {
            color: var(--navy);
            font-size: 16px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .order-date {
            margin-top: 7px;
            color: var(--muted);
            font-size: 11px;
        }

        .badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 7px;
        }

        .badge {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 10px;
            line-height: 1.5;
            font-weight: 800;
            text-align: center;
        }

        .pending {
            color: var(--orange);
            background: var(--orange-bg);
        }

        .confirmed,
        .paid {
            color: var(--green);
            background: var(--green-bg);
        }

        .rejected,
        .cancelled,
        .failed {
            color: var(--red);
            background: var(--red-bg);
        }

        .unpaid,
        .default {
            color: #475569;
            background: #eef2f7;
        }

        .order-body {
            padding: 20px 21px;
        }

        .order-details {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(230px, .7fr);
            gap: 24px;
        }

        .subheading {
            margin: 0 0 13px;
            color: var(--navy);
            font-size: 13px;
        }

        .item-list {
            display: grid;
            gap: 12px;
        }

        .item-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8faff;
            border: 1px solid #edf1f8;
            border-radius: 10px;
        }

        .item-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            color: var(--blue);
            background: var(--soft);
            border-radius: 9px;
            font-size: 22px;
        }

        .item-info {
            min-width: 0;
            flex: 1;
        }

        .item-name {
            color: var(--navy);
            font-size: 12px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .item-quantity {
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .item-subtotal {
            flex-shrink: 0;
            color: var(--blue-dark);
            font-size: 12px;
            font-weight: 800;
            text-align: right;
        }

        .info-list {
            display: grid;
            gap: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            padding-bottom: 11px;
            border-bottom: 1px solid #edf0f6;
            font-size: 12px;
        }

        .info-row:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .info-label {
            color: var(--muted);
            line-height: 1.6;
        }

        .info-value {
            color: var(--navy);
            text-align: right;
            font-weight: 700;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .grand-total {
            margin-top: 18px;
            padding: 17px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            background: var(--soft);
            border-radius: 10px;
        }

        .grand-total span {
            color: #334155;
            font-size: 12px;
            font-weight: 700;
        }

        .grand-total strong {
            color: var(--blue-dark);
            font-size: 21px;
            overflow-wrap: anywhere;
            text-align: right;
        }

        .order-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 21px;
            background: white;
            border-top: 1px solid var(--border);
        }

        .footer-note {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .footer-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 9px;
        }

        .detail-button,
        .cancel-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-shrink: 0;
            padding: 11px 15px;
            border: 0;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: background .2s;
        }

        .detail-button {
            color: white;
            background: var(--blue);
        }

        .detail-button:hover {
            background: var(--blue-dark);
        }

        .cancel-button {
            color: var(--red);
            background: var(--red-bg);
            border: 1px solid #fecaca;
        }

        .cancel-button:hover {
            color: white;
            background: var(--red);
        }

        .cancel-note {
            width: 100%;
            color: var(--orange);
            font-size: 11px;
            text-align: right;
        }

        .empty-state {
            padding: 48px 22px;
            text-align: center;
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: 0 4px 14px rgba(23, 37, 84, .025);
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            display: grid;
            place-items: center;
            margin: 0 auto 17px;
            border-radius: 22px;
            background: var(--soft);
            font-size: 40px;
        }

        .empty-state h2 {
            margin: 0 0 10px;
            color: var(--navy);
            font-size: 22px;
        }

        .empty-state p {
            max-width: 460px;
            margin: 0 auto 21px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .shop-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 19px;
            color: white;
            background: var(--blue);
            border-radius: 9px;
            font-size: 12px;
            font-weight: 800;
        }

        .shop-button:hover {
            background: var(--blue-dark);
        }

        .pagination {
            margin-top: 22px;
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

        @media (max-width: 900px) {
            .navbar {
                gap: 12px;
            }

            .account-info {
                display: none;
            }

            .order-details {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .navbar {
                padding: 12px 14px;
                flex-wrap: wrap;
            }

            .brand {
                flex: 1;
            }

            .brand small {
                display: none;
            }

            .nav-links {
                order: 3;
                width: 100%;
                overflow-x: auto;
                padding-top: 8px;
                border-top: 1px solid var(--border);
            }

            .nav-links a {
                padding: 10px;
                font-size: 12px;
            }

            .container {
                padding: 21px 14px 32px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .hero {
                padding: 22px;
            }

            .hero h2 {
                font-size: 20px;
            }

            .hero p {
                font-size: 12px;
            }

            .hero-icon {
                display: none;
            }

            .order-header {
                flex-direction: column;
                padding: 16px;
            }

            .badges {
                justify-content: flex-start;
            }

            .order-body {
                padding: 16px;
            }

            .order-footer {
                align-items: stretch;
                flex-direction: column;
                padding: 15px 16px;
            }

            .footer-actions {
                width: 100%;
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .detail-button,
            .cancel-button {
                width: 100%;
            }

            .cancel-note {
                text-align: left;
            }

            .item-row {
                align-items: flex-start;
            }

            .item-subtotal {
                font-size: 11px;
            }

            .grand-total strong {
                font-size: 17px;
            }
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
        Inventory Store / Pesanan Saya
    </div>

    <div class="page-heading">
        <div>
            <h1>Pesanan Saya</h1>
            <p>Lihat riwayat pesanan, rincian belanja, dan status pembayaranmu.</p>
        </div>

        <div class="order-count">
            📦 Total {{ $orders->total() }} pesanan
        </div>
    </div>

    @if (session('success'))
        <div class="message success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="message error">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <section class="hero">
        <div>
            <h2>Semua pesananmu dalam satu tempat</h2>
            <p>
                Periksa nomor pesanan, produk yang dipesan, total belanja,
                metode pembayaran, serta status konfirmasi toko.
            </p>
        </div>

        <div class="hero-icon">🛍️</div>
    </section>

    <div class="section-heading">
        <h2>Riwayat Pesanan</h2>
        <p>Pesanan ditampilkan dari yang terbaru.</p>
    </div>

    @if ($orders->count() > 0)
        <div class="order-list">
            @foreach ($orders as $order)
                <article class="order-card">
                    <div class="order-header">
                        <div>
                            <div class="order-label">Nomor Pesanan</div>
                            <div class="order-number">
                                {{ $order->order_number }}
                            </div>
                            <div class="order-date">
                                📅 {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                            </div>
                        </div>

                        <div class="badges">
                            @if ($order->status === 'pending')
                                <span class="badge pending">Menunggu Konfirmasi</span>
                            @elseif ($order->status === 'confirmed')
                                <span class="badge confirmed">Dikonfirmasi</span>
                            @elseif ($order->status === 'rejected')
                                <span class="badge rejected">Ditolak</span>
                            @elseif ($order->status === 'cancelled')
                                <span class="badge cancelled">Dibatalkan</span>
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

                    <div class="order-body">
                        <div class="order-details">
                            <div>
                                <h3 class="subheading">🛍️ Produk Pesanan</h3>

                                <div class="item-list">
                                    @forelse ($order->items as $item)
                                        <div class="item-row">
                                            <div class="item-icon">📦</div>

                                            <div class="item-info">
                                                <div class="item-name">
                                                    {{ $item->product?->name ?? 'Produk tidak tersedia' }}
                                                </div>

                                                <div class="item-quantity">
                                                    {{ $item->quantity }} ×
                                                    Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                                </div>
                                            </div>

                                            <div class="item-subtotal">
                                                Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @empty
                                        <div class="item-row">
                                            <div class="item-info">
                                                <div class="item-name">
                                                    Detail produk tidak tersedia.
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <h3 class="subheading">📋 Informasi Pesanan</h3>

                                <div class="info-list">
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
                                        <span class="info-label">Jumlah Barang</span>
                                        <span class="info-value">
                                            {{ $order->items->sum('quantity') }} unit
                                        </span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">Nomor Telepon</span>
                                        <span class="info-value">
                                            {{ $order->customer_phone ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grand-total">
                                    <span>Total Belanja</span>
                                    <strong>
                                        Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-footer">
                        <div class="footer-note">
                            Periksa detail untuk melihat alamat pengiriman dan informasi lengkap pesanan.
                        </div>

                        <div class="footer-actions">
                            @if ($order->status === 'pending')
                                <form
                                    method="POST"
                                    action="{{ route('buyer.orders.cancel', $order) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="cancel-button">
                                        ✖ Batalkan Pesanan
                                    </button>
                                </form>

                                <div class="cancel-note">
                                    Pesanan hanya dapat dibatalkan sebelum dikonfirmasi toko.
                                </div>
                            @endif

                            <a
                                href="{{ route('buyer.orders.show', $order) }}"
                                class="detail-button"
                            >
                                Lihat Detail Pesanan →
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if ($orders->hasPages())
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <section class="empty-state">
            <div class="empty-icon">🛍️</div>
            <h2>Belum Ada Pesanan</h2>
            <p>
                Kamu belum membuat pesanan. Silakan kunjungi katalog,
                pilih produk yang kamu butuhkan, lalu buat pesanan pertamamu.
            </p>

            <a href="{{ route('catalog.index') }}" class="shop-button">
                🛍️ Lihat Katalog Produk →
            </a>
        </section>
    @endif
</main>

<footer class="footer">
    <strong>Inventory Store</strong><br>
    Inventory Management System © {{ date('Y') }}
</footer>

</body>
</html>


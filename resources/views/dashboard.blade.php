
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventory</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --navy: #172554;
            --navy-light: #1e3a8a;
            --blue: #2563eb;
            --blue-light: #eff6ff;
            --background: #f4f7fb;
            --white: #ffffff;
            --text: #172033;
            --muted: #64748b;
            --border: #e2e8f0;
            --green: #15803d;
            --green-bg: #dcfce7;
            --orange: #c2410c;
            --orange-bg: #ffedd5;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        a {
            text-decoration: none;
        }

        .layout {
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            padding: 25px 17px;
            background: var(--navy);
            color: var(--white);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 10;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 2px 9px 26px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        .brand-icon {
            width: 45px;
            height: 45px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--blue);
            font-size: 23px;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .brand-caption {
            font-size: 11px;
            color: #bfdbfe;
            letter-spacing: 1px;
        }

        .nav-label {
            padding: 25px 12px 10px;
            color: #93a7cf;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            font-size: 10px;
            font-weight: 700;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 5px;
            padding: 12px 13px;
            border-radius: 10px;
            color: #dbeafe;
            font-size: 13px;
            transition: background .2s, color .2s;
        }

        .nav-link:hover {
            background: rgba(255,255,255,.09);
            color: white;
        }

        .nav-link.active {
            background: var(--blue);
            color: white;
            font-weight: 700;
            box-shadow: 0 5px 14px rgba(37,99,235,.23);
        }

        .nav-icon {
            width: 23px;
            text-align: center;
            font-size: 17px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
        }

        .account-card {
            padding: 13px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            background: #bfdbfe;
            color: var(--navy);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 15px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .account-name {
            font-size: 12px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .account-role {
            font-size: 10px;
            color: #bfdbfe;
            margin-top: 5px;
            letter-spacing: 1px;
        }

        .logout-button {
            margin-top: 12px;
            width: 100%;
            padding: 12px;
            display: block;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 9px;
            background: transparent;
            color: #dbeafe;
            cursor: pointer;
            font-size: 12px;
            text-align: left;
        }

        .logout-button:hover {
            background: rgba(255,255,255,.09);
        }

        /* Main content */
        .main {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 9px;
        }

        .page-title {
            font-size: 28px;
            line-height: 1.25;
            font-weight: 800;
            margin: 0;
            letter-spacing: -.6px;
        }

        .page-description {
            font-size: 13px;
            line-height: 1.7;
            color: var(--muted);
            margin: 8px 0 0;
        }

        .date-box {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 11px;
            color: #334155;
            font-size: 12px;
        }

        /* Welcome banner */
        .welcome {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 27px 28px;
            border-radius: 16px;
            background: linear-gradient(120deg, #1e3a8a, #2563eb);
            color: white;
            margin-bottom: 27px;
        }

        .welcome::after {
            content: "";
            position: absolute;
            right: -45px;
            top: -100px;
            height: 245px;
            width: 245px;
            border-radius: 50%;
            border: 35px solid rgba(255,255,255,.08);
            pointer-events: none;
        }

        .welcome-eyebrow {
            color: #bfdbfe;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1.4px;
            margin-bottom: 11px;
        }

        .welcome h2 {
            margin: 0;
            font-size: 22px;
            line-height: 1.4;
        }

        .welcome p {
            margin: 9px 0 0;
            color: #dbeafe;
            font-size: 13px;
            line-height: 1.7;
        }

        .welcome-symbol {
            position: relative;
            z-index: 1;
            font-size: 58px;
            padding: 0 15px;
        }

        .role-pill {
            display: inline-block;
            margin-top: 13px;
            padding: 6px 10px;
            border-radius: 6px;
            background: rgba(255,255,255,.14);
            color: white;
            font-size: 10px;
            letter-spacing: 1px;
            font-weight: 700;
        }

        /* Statistic cards */
        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin: 28px 0 16px;
        }

        .section-heading h3 {
            margin: 0;
            font-size: 17px;
        }

        .section-heading p {
            margin: 6px 0 0;
            font-size: 12px;
            color: var(--muted);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
        }

        .stats.staff-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .stat-card {
            background: white;
            padding: 21px;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(15,23,42,.025);
            min-width: 0;
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 19px;
        }

        .stat-label {
            font-size: 12px;
            line-height: 1.6;
            color: var(--muted);
        }

        .stat-icon {
            height: 43px;
            width: 43px;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
            background: var(--blue-light);
            font-size: 21px;
        }

        .stat-card.green .stat-icon {
            background: var(--green-bg);
        }

        .stat-card.orange .stat-icon {
            background: var(--orange-bg);
        }

        .stat-number {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -.7px;
            overflow-wrap: anywhere;
        }

        .stat-note {
            margin-top: 8px;
            font-size: 11px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* Quick actions */
        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(245px, 1fr);
            gap: 20px;
            margin-top: 27px;
        }

        .panel {
            background: white;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            padding: 23px;
            box-shadow: 0 3px 12px rgba(15,23,42,.025);
            min-width: 0;
        }

        .panel-title {
            margin: 0;
            font-size: 16px;
        }

        .panel-subtitle {
            margin: 7px 0 20px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .action-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .action-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            min-height: 80px;
            border: 1px solid var(--border);
            border-radius: 11px;
            color: var(--text);
            transition: .2s;
        }

        .action-card:hover {
            border-color: #93c5fd;
            background: #f8fbff;
            transform: translateY(-2px);
        }

        .action-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--blue-light);
            font-size: 20px;
        }

        .action-name {
            font-size: 12px;
            font-weight: 700;
            line-height: 1.5;
        }

        .action-description {
            margin-top: 5px;
            font-size: 10px;
            color: var(--muted);
            line-height: 1.5;
        }

        .info-row {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 19px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            height: 35px;
            width: 35px;
            flex-shrink: 0;
            border-radius: 9px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--blue-light);
            font-size: 16px;
        }

        .info-title {
            font-size: 12px;
            font-weight: 700;
            margin: 2px 0 6px;
        }

        .info-text {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.7;
        }

        .footer {
            border-top: 1px solid var(--border);
            padding-top: 18px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 11px;
            color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .main {
                padding: 24px;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                bottom: auto;
                padding: 16px;
            }

            .brand {
                padding-bottom: 15px;
            }

            .nav-label {
                padding-top: 17px;
            }

            .sidebar nav {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 5px;
            }

            .nav-label {
                grid-column: 1 / -1;
            }

            .nav-link {
                margin: 0;
                padding: 11px 9px;
                font-size: 11px;
            }

            .sidebar-bottom {
                margin-top: 18px;
                padding-top: 0;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            .page-title {
                font-size: 24px;
            }

            .welcome {
                padding: 22px;
            }

            .welcome h2 {
                font-size: 19px;
            }

            .welcome-symbol {
                font-size: 39px;
                padding: 0;
            }

            .stats,
            .stats.staff-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 11px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 25px;
            }

            .stat-icon {
                height: 36px;
                width: 36px;
                font-size: 18px;
            }

            .action-list {
                grid-template-columns: 1fr;
            }

            .panel {
                padding: 18px;
            }

            .account-card {
                max-width: 100%;
            }
        }

        @media (max-width: 390px) {
            .stats,
            .stats.staff-stats {
                grid-template-columns: 1fr;
            }

            .date-box {
                width: 100%;
            }
        }
    </style>
</head>

<body>
@php
    $currentUser = auth()->user();
    $isAdmin = $currentUser->role === 'admin';
    $initial = strtoupper(substr($currentUser->name ?? 'U', 0, 1));
@endphp

<div class="layout">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">📦</div>
            <div>
                <div class="brand-name">Inventory</div>
                <div class="brand-caption">MANAGEMENT SYSTEM</div>
            </div>
        </div>

        <nav>
            <div class="nav-label">Menu Utama</div>

            <a href="{{ route('dashboard') }}" class="nav-link active">
                <span class="nav-icon">🏠</span>
                Dashboard
            </a>

            @if($isAdmin)
                <a href="{{ route('categories.index') }}" class="nav-link">
                    <span class="nav-icon">🗂️</span>
                    Kategori
                </a>

                <a href="{{ route('products.index') }}" class="nav-link">
                    <span class="nav-icon">📦</span>
                    Produk
                </a>

                <a href="{{ route('suppliers.index') }}" class="nav-link">
                    <span class="nav-icon">🚚</span>
                    Supplier
                </a>
            @endif

            
           @if(!$isAdmin)
                <a href="{{ route('products.readonly') }}" class="nav-link">
                    <span class="nav-icon">📋</span>
                    Data Produk
               </a>
           @endif


            <div class="nav-label">Persediaan</div>
   
            <a href="{{ route('purchases.index') }}" class="nav-link">
                <span class="nav-icon">🛒</span>
                Pembelian
            </a>

            <a href="{{ route('orders.index') }}" class="nav-link">
                <span class="nav-icon">🛍️</span>
                Pesanan Pembeli
            </a>

            <a href="{{ route('sales.index') }}" class="nav-link">
                <span class="nav-icon">🧾</span>
                Penjualan
            </a>

            <a href="{{ route('stock-ins.index') }}" class="nav-link">
                <span class="nav-icon">📥</span>
                Stok Masuk
            </a>

            <a href="{{ route('stock-outs.index') }}" class="nav-link">
                <span class="nav-icon">📤</span>
                Stok Keluar
            </a>

            <div class="nav-label">Laporan</div>

            <a href="{{ route('reports.index') }}" class="nav-link">
                <span class="nav-icon">📊</span>
                Laporan Persediaan
            </a>

            <a href="{{ route('reports.transactions') }}" class="nav-link">
                <span class="nav-icon">🧾</span>
                Laporan Transaksi
            </a>

            <a href="{{ route('completed-transactions.index') }}" class="nav-link">
                <span class="nav-icon">✅</span>
                Total Transaksi Selesai
            </a>
            
        </nav>

        <div class="sidebar-bottom">
            <div class="account-card">
                <div class="avatar">{{ $initial }}</div>
                <div>
                    <div class="account-name">{{ $currentUser->name }}</div>
                    <div class="account-role">
                        {{ $isAdmin ? 'ADMINISTRATOR' : 'STAFF INVENTORY' }}
                    </div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    ↪ &nbsp; Keluar dari Aplikasi
                </button>
            </form>
        </div>
    </aside>

    <main class="main">

        <header class="topbar">
            <div>
                <div class="breadcrumb">Inventory / Dashboard</div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-description">
                    Ringkasan dan informasi persediaan barang.
                </p>
            </div>

            <div class="date-box">
                <span>📅</span>
                <span>{{ date('d-m-Y') }}</span>
            </div>
        </header>

        <section class="welcome">
            <div>
                <div class="welcome-eyebrow">Inventory Management System</div>
                <h2>Selamat datang, {{ $currentUser->name }}!</h2>

                <p>
                    @if($isAdmin)
                        Kelola persediaan, data produk, supplier, dan transaksi dari satu tempat.
                    @else
                        Catat pergerakan stok dan pantau informasi persediaan dengan mudah.
                    @endif
                </p>

                <span class="role-pill">
                    {{ $isAdmin ? 'ADMINISTRATOR' : 'STAFF INVENTORY' }}
                </span>
            </div>

            <div class="welcome-symbol">📦</div>
        </section>

        <div class="section-heading">
            <div>
                <h3>Ringkasan Persediaan</h3>
                <p>Informasi terkini berdasarkan data aplikasi.</p>
            </div>
        </div>

        <section class="stats {{ $isAdmin ? '' : 'staff-stats' }}">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-icon">📦</div>
                </div>
                <div class="stat-number">
                    {{ number_format($totalProducts, 0, ',', '.') }}
                </div>
                <div class="stat-note">Jenis produk yang tercatat dalam sistem</div>
            </div>

            @if($isAdmin)
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-label">Total Kategori</div>
                        <div class="stat-icon">🗂️</div>
                    </div>
                    <div class="stat-number">
                        {{ number_format($totalCategories, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">Kategori produk yang tersedia</div>
                </div>

                <div class="stat-card green">
                    <div class="stat-top">
                        <div class="stat-label">Total Supplier</div>
                        <div class="stat-icon">🚚</div>
                    </div>
                    <div class="stat-number">
                        {{ number_format($totalSuppliers, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">Pemasok yang terdaftar</div>
                </div>
            @endif

            <div class="stat-card {{ $lowStockProducts > 0 ? 'orange' : 'green' }}">
                <div class="stat-top">
                    <div class="stat-label">Stok Menipis</div>
                    <div class="stat-icon">⚠️</div>
                </div>
                <div class="stat-number">
                    {{ number_format($lowStockProducts, 0, ',', '.') }}
                </div>
                <div class="stat-note">
                    Produk dengan stok sama dengan atau di bawah batas minimum
                </div>
            </div>
        </section>

        @if($isAdmin)
            <div class="section-heading">
                <div>
                    <h3>Ringkasan Transaksi</h3>
                    <p>Statistik pembelian dan penjualan dari database.</p>
                </div>
            </div>

            <section class="stats">
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-label">Total Transaksi Selesai</div>
                        <div class="stat-icon">🧾</div>
                    </div>
                    <div class="stat-number">
                        {{ number_format($totalTransactions, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">
                        Pembelian dikonfirmasi dan penjualan selesai
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-label">Jumlah Penjualan</div>
                        <div class="stat-icon">🛒</div>
                    </div>
                    <div class="stat-number">
                        {{ number_format($totalSales, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">
                        Transaksi penjualan yang selesai
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-top">
                        <div class="stat-label">Penjualan Hari Ini</div>
                        <div class="stat-icon">💰</div>
                    </div>
                    <div class="stat-number" style="font-size:24px;">
                        Rp {{ number_format((float) $salesToday, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">
                        Total nilai penjualan pada hari ini
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-top">
                        <div class="stat-label">Penjualan Bulan Ini</div>
                        <div class="stat-icon">📈</div>
                    </div>
                    <div class="stat-number" style="font-size:24px;">
                        Rp {{ number_format((float) $salesThisMonth, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">
                        Total nilai penjualan bulan berjalan
                    </div>
                </div>
            </section>
        @endif

        <section class="content-grid">

            <div class="panel">
                <h3 class="panel-title">Akses Cepat</h3>
                <p class="panel-subtitle">
                    Pilih fitur yang ingin kamu gunakan.
                </p>

                <div class="action-list">
                    @if($isAdmin)
                        <a href="{{ route('products.index') }}" class="action-card">
                            <div class="action-icon">📦</div>
                            <div>
                                <div class="action-name">Kelola Produk</div>
                                <div class="action-description">Lihat dan kelola data produk</div>
                            </div>
                        </a>

                        <a href="{{ route('categories.index') }}" class="action-card">
                            <div class="action-icon">🗂️</div>
                            <div>
                                <div class="action-name">Kelola Kategori</div>
                                <div class="action-description">Atur kategori produk</div>
                            </div>
                        </a>

                        <a href="{{ route('suppliers.index') }}" class="action-card">
                            <div class="action-icon">🚚</div>
                            <div>
                                <div class="action-name">Data Supplier</div>
                                <div class="action-description">Lihat data pemasok</div>
                            </div>
                        </a>
                    @endif

                    <a href="{{ route('stock-ins.create') }}" class="action-card">
                        <div class="action-icon">📥</div>
                        <div>
                            <div class="action-name">Catat Stok Masuk</div>
                            <div class="action-description">Tambahkan barang ke persediaan</div>
                        </div>
                    </a>

                    <a href="{{ route('stock-outs.create') }}" class="action-card">
                        <div class="action-icon">📤</div>
                        <div>
                            <div class="action-name">Catat Stok Keluar</div>
                            <div class="action-description">Catat barang yang keluar</div>
                        </div>
                    </a>

                    <a href="{{ route('reports.index') }}" class="action-card">
                        <div class="action-icon">📊</div>
                        <div>
                            <div class="action-name">Laporan Persediaan</div>
                            <div class="action-description">Periksa kondisi stok produk</div>
                        </div>
                    </a>

                    <a href="{{ route('reports.transactions') }}" class="action-card">
                        <div class="action-icon">🧾</div>
                        <div>
                            <div class="action-name">Laporan Transaksi</div>
                            <div class="action-description">Lihat riwayat transaksi stok</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="panel">
                <h3 class="panel-title">Informasi Sistem</h3>
                <p class="panel-subtitle">
                    Panduan singkat penggunaan Inventory.
                </p>

                <div class="info-row">
                    <div class="info-icon">🔐</div>
                    <div>
                        <div class="info-title">Akses Pengguna</div>
                        <div class="info-text">
                            @if($isAdmin)
                                Kamu login sebagai Admin dan dapat mengelola data utama serta transaksi persediaan.
                            @else
                                Kamu login sebagai Staff. Gunakan menu transaksi dan laporan sesuai hak akses.
                            @endif
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📥</div>
                    <div>
                        <div class="info-title">Transaksi Stok Masuk</div>
                        <div class="info-text">
                            Catat penerimaan barang agar jumlah persediaan diperbarui secara otomatis.
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📤</div>
                    <div>
                        <div class="info-title">Transaksi Stok Keluar</div>
                        <div class="info-text">
                            Pastikan stok mencukupi sebelum menyimpan transaksi barang keluar.
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📊</div>
                    <div>
                        <div class="info-title">Laporan Persediaan</div>
                        <div class="info-text">
                            Gunakan laporan untuk memantau persediaan dan memeriksa riwayat transaksi.
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <footer class="footer">
            <span>© {{ date('Y') }} Inventory Management System</span>
            <span>Persediaan lebih teratur, pekerjaan lebih mudah.</span>
        </footer>

    </main>
</div>
</body>
</html>

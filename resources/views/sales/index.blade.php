<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan - Inventory System</title>

    <style>
        :root {
            --navy: #172554;
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --blue-soft: #e8efff;
            --bg: #f4f7fc;
            --text: #17233f;
            --muted: #64748b;
            --border: #e2e8f0;
            --green: #15803d;
            --green-bg: #dcfce7;
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

        .layout {
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 235px;
            overflow-y: auto;
            padding: 25px 15px;
            background: var(--navy);
            color: white;
        }

        .brand {
            margin: 0 0 30px;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.5;
        }

        .menu {
            display: block;
            margin-bottom: 7px;
            padding: 12px 13px;
            color: #dbeafe;
            text-decoration: none;
            border-radius: 8px;
            font-size: 13px;
            transition: .2s;
        }

        .menu:hover,
        .menu.active {
            color: white;
            background: var(--blue);
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

        .logout button:hover {
            background: #334155;
        }

        .main {
            margin-left: 235px;
            padding: 30px;
            min-width: 0;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            color: var(--navy);
            font-size: 28px;
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .btn {
            display: inline-block;
            padding: 11px 15px;
            border: 0;
            border-radius: 8px;
            background: var(--blue);
            color: white;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s;
            text-align: center;
        }

        .btn:hover {
            background: var(--blue-dark);
        }

        .btn-reset {
            background: #eef2f7;
            color: #475569;
        }

        .btn-reset:hover {
            background: #e2e8f0;
        }

        .btn-detail {
            padding: 8px 11px;
            background: var(--blue-soft);
            color: var(--blue-dark);
        }

        .btn-detail:hover {
            background: #dbeafe;
        }

        .message {
            padding: 13px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.7;
        }

        .success {
            background: var(--green-bg);
            color: #166534;
        }

        .error {
            background: var(--red-bg);
            color: #991b1b;
        }

        .card {
            padding: 22px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .04);
        }

        .card-heading {
            margin-bottom: 18px;
        }

        .card-heading h2 {
            margin: 0 0 6px;
            color: var(--navy);
            font-size: 18px;
        }

        .filter-form {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 17px;
            background: #f8faff;
            border: 1px solid var(--border);
            border-radius: 11px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
            flex: 1;
            min-width: 145px;
        }

        .filter-group.search-group {
            flex: 1.5;
            min-width: 190px;
        }

        .filter-group label {
            color: #475569;
            font-size: 12px;
            font-weight: 800;
        }

        .control {
            width: 100%;
            min-height: 41px;
            padding: 10px 11px;
            color: var(--text);
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            font-size: 12px;
        }

        .control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .result-info {
            margin: 0 0 13px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: middle;
            font-size: 12px;
        }

        th {
            color: #475569;
            background: #f8fafc;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: .3px;
            white-space: nowrap;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .badge {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .completed {
            background: var(--green-bg);
            color: #166534;
        }

        .cancelled {
            background: var(--red-bg);
            color: #991b1b;
        }

        .empty {
            padding: 35px;
            color: var(--muted);
            text-align: center;
            line-height: 1.7;
        }

        .pagination {
            margin-top: 20px;
            overflow-x: auto;
        }

        .pagination nav > div:first-child {
            margin-bottom: 10px;
        }

        .pagination a,
        .pagination span {
            padding: 5px 9px;
        }

        @media (max-width: 900px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .brand {
                margin-bottom: 15px;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }
        }

        @media (max-width: 600px) {
            .main {
                padding: 14px;
            }

            h1 {
                font-size: 23px;
            }

            .card {
                padding: 13px;
            }

            .filter-form {
                padding: 13px;
            }

            .filter-group,
            .filter-group.search-group {
                flex-basis: 100%;
                min-width: 100%;
            }

            .filter-actions {
                width: 100%;
            }

            .filter-actions .btn {
                flex: 1;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">📦 Inventory System</div>

        <a class="menu" href="{{ route('dashboard') }}">🏠 Dashboard</a>

        @if (auth()->user()->role === 'admin')
            <a class="menu" href="{{ route('categories.index') }}">🗂️ Kategori</a>
            <a class="menu" href="{{ route('products.index') }}">📦 Kelola Produk</a>
            <a class="menu" href="{{ route('suppliers.index') }}">🚚 Supplier</a>
        @else
            <a class="menu" href="{{ route('products.readonly') }}">📋 Data Produk</a>
        @endif

        <a class="menu" href="{{ route('purchases.index') }}">🛒 Pembelian</a>
        <a class="menu active" href="{{ route('sales.index') }}">🧾 Penjualan</a>
        <a class="menu" href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a class="menu" href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a class="menu" href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a class="menu" href="{{ route('reports.transactions') }}">📈 Laporan Transaksi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">↪ Keluar dari Aplikasi</button>
        </form>
    </aside>

    <main class="main">

        <div class="header">
            <div>
                <h1>Daftar Penjualan</h1>
                <div class="muted">
                    Cari dan pantau riwayat transaksi penjualan.
                </div>
            </div>

            <a href="{{ route('sales.create') }}" class="btn">
                + Buat Penjualan
            </a>
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

        @if ($errors->any())
            <div class="message error">
                <strong>Periksa kembali input filter atau transaksi:</strong>
                <ul style="margin-bottom:0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card">

            <div class="card-heading">
                <h2>Filter Transaksi Penjualan</h2>
                <div class="muted">
                    Gunakan pencarian, status, atau rentang tanggal.
                </div>
            </div>

            <form class="filter-form" action="{{ route('sales.index') }}" method="GET">

                <div class="filter-group search-group">
                    <label for="search">Cari Transaksi</label>
                    <input
                        class="control"
                        id="search"
                        type="search"
                        name="search"
                        maxlength="100"
                        value="{{ $search }}"
                        placeholder="Nomor penjualan atau nama staf..."
                    >
                </div>

                <div class="filter-group">
                    <label for="status">Status</label>
                    <select class="control" id="status" name="status">
                        <option value="">Semua status</option>
                        <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="date_from">Tanggal Mulai</label>
                    <input
                        class="control"
                        id="date_from"
                        type="date"
                        name="date_from"
                        value="{{ $dateFrom }}"
                    >
                </div>

                <div class="filter-group">
                    <label for="date_to">Tanggal Akhir</label>
                    <input
                        class="control"
                        id="date_to"
                        type="date"
                        name="date_to"
                        value="{{ $dateTo }}"
                    >
                </div>

                <div class="filter-actions">
                    <button class="btn" type="submit">Terapkan Filter</button>
                    <a class="btn btn-reset" href="{{ route('sales.index') }}">Reset</a>
                </div>

            </form>

            <div class="result-info">
                Menampilkan {{ $sales->firstItem() ?? 0 }}
                sampai {{ $sales->lastItem() ?? 0 }}
                dari {{ $sales->total() }} transaksi.
                @if ($search !== '')
                    Kata pencarian: <strong>{{ $search }}</strong>.
                @endif
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Penjualan</th>
                            <th>Tanggal Penjualan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>{{ $sales->firstItem() + $loop->index }}</td>

                            <td>
                                <strong>{{ $sale->sale_number }}</strong>
                            </td>

                            <td>
                                {{ $sale->sold_at?->format('d-m-Y H:i') ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format((float) $sale->total, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($sale->status === 'completed')
                                    <span class="badge completed">Selesai</span>
                                @else
                                    <span class="badge cancelled">Dibatalkan</span>
                                @endif
                            </td>

                            <td>{{ $sale->user?->name ?? '-' }}</td>

                            <td>
                                <a
                                    href="{{ route('sales.show', $sale) }}"
                                    class="btn btn-detail"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">
                                Tidak ada transaksi yang cocok dengan filter.
                                <br>
                                Coba ubah kata pencarian atau rentang tanggal.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $sales->links() }}
            </div>

        </section>
    </main>
</div>
</body>
</html>

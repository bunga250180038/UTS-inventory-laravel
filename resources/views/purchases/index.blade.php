<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembelian - Inventory System</title>

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
        }

        .menu {
            display: block;
            padding: 12px 13px;
            margin-bottom: 7px;
            border-radius: 8px;
            color: #dbeafe;
            text-decoration: none;
            font-size: 13px;
            transition: .2s;
        }

        .menu:hover,
        .menu.active {
            background: var(--blue);
            color: white;
        }

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

        .logout button:hover { background: #334155; }

        .main {
            margin-left: 235px;
            padding: 30px;
            min-width: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .card {
            padding: 22px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .04);
        }

        .card-heading { margin-bottom: 18px; }

        .card-heading h2 {
            margin: 0 0 6px;
            color: var(--navy);
            font-size: 18px;
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
            text-align: center;
            transition: .2s;
        }

        .btn:hover { background: var(--blue-dark); }

        .btn-detail {
            padding: 8px 11px;
            background: var(--blue-soft);
            color: var(--blue-dark);
        }

        .btn-detail:hover { background: #dbeafe; }

        .btn-reset {
            background: #eef2f7;
            color: #475569;
        }

        .btn-reset:hover { background: #e2e8f0; }

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

        .filter-form {
            display: flex;
            align-items: end;
            flex-wrap: wrap;
            gap: 12px;
            padding: 17px;
            margin-bottom: 20px;
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
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            color: var(--text);
            background: white;
            font-size: 12px;
        }

        .control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        .filter-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .result-info {
            margin-bottom: 13px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: middle;
            font-size: 12px;
        }

        th {
            background: #f8fafc;
            color: #475569;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: .3px;
            white-space: nowrap;
        }

        tbody tr:hover { background: #fafcff; }

        .badge {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .draft {
            background: var(--orange-bg);
            color: #92400e;
        }

        .confirmed {
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

        .pagination nav > div:first-child { margin-bottom: 10px; }
        .pagination a, .pagination span { padding: 5px 9px; }

        @media (max-width: 900px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .brand { margin-bottom: 16px; }

            .main {
                margin-left: 0;
                padding: 20px;
            }
        }

        @media (max-width: 600px) {
            .main { padding: 14px; }
            h1 { font-size: 23px; }
            .card { padding: 13px; }

            .filter-form { padding: 13px; }

            .filter-group,
            .filter-group.search-group {
                flex-basis: 100%;
                min-width: 100%;
            }

            .filter-actions { width: 100%; }
            .filter-actions .btn { flex: 1; }
        }
    </style>
</head>

<body>

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

    <a class="menu active" href="{{ route('purchases.index') }}">🛒 Pembelian</a>
    <a class="menu" href="{{ route('sales.index') }}">🧾 Penjualan</a>
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
            <h1>Daftar Pembelian</h1>
            <div class="muted">
                Cari dan pantau transaksi pembelian dari supplier.
            </div>
        </div>

        <a href="{{ route('purchases.create') }}" class="btn">
            + Buat Pembelian
        </a>
    </div>

    @if (session('success'))
        <div class="message success">✅ {{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="message error">⚠️ {{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="message error">
            <strong>Periksa kembali input:</strong>
            <ul style="margin-bottom:0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card">

        <div class="card-heading">
            <h2>Filter Transaksi Pembelian</h2>
            <div class="muted">
                Cari nomor pembelian, supplier, atau nama petugas.
            </div>
        </div>

        <form class="filter-form" action="{{ route('purchases.index') }}" method="GET">

            <div class="filter-group search-group">
                <label for="search">Cari Pembelian</label>
                <input
                    class="control"
                    id="search"
                    type="search"
                    name="search"
                    maxlength="100"
                    value="{{ $search }}"
                    placeholder="Nomor pembelian, supplier..."
                >
            </div>

            <div class="filter-group">
                <label for="status">Status</label>
                <select class="control" id="status" name="status">
                    <option value="">Semua status</option>
                    <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>
                        Draft
                    </option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>
                        Dikonfirmasi
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
                <a class="btn btn-reset" href="{{ route('purchases.index') }}">
                    Reset
                </a>
            </div>

        </form>

        <div class="result-info">
            Menampilkan {{ $purchases->firstItem() ?? 0 }}
            sampai {{ $purchases->lastItem() ?? 0 }}
            dari {{ $purchases->total() }} transaksi.
            @if ($search !== '')
                Kata pencarian: <strong>{{ $search }}</strong>.
            @endif
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Pembelian</th>
                        <th>Tanggal Pembelian</th>
                        <th>Supplier</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($purchases as $purchase)
                    <tr>
                        <td>{{ $purchases->firstItem() + $loop->index }}</td>

                        <td>
                            <strong>{{ $purchase->purchase_number }}</strong>
                        </td>

                        <td>
                            {{ $purchase->purchased_at?->format('d-m-Y H:i') ?? '-' }}
                        </td>

                        <td>{{ $purchase->supplier?->name ?? '-' }}</td>

                        <td>
                            Rp {{ number_format((float) $purchase->total, 0, ',', '.') }}
                        </td>

                        <td>
                            @if ($purchase->status === 'draft')
                                <span class="badge draft">Draft</span>
                            @elseif ($purchase->status === 'confirmed')
                                <span class="badge confirmed">Dikonfirmasi</span>
                            @else
                                <span class="badge cancelled">Dibatalkan</span>
                            @endif
                        </td>

                        <td>{{ $purchase->user?->name ?? '-' }}</td>

                        <td>
                            <a
                                href="{{ route('purchases.show', $purchase) }}"
                                class="btn btn-detail"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">
                            Tidak ada transaksi yang cocok dengan filter.
                            <br>
                            Coba ubah kata pencarian atau tanggal, atau klik Reset.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $purchases->links() }}
        </div>

    </section>
</main>

</body>
</html>

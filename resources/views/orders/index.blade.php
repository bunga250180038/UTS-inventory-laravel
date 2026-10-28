<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Pembeli | Inventory System</title>

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

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .panel {
            padding: 22px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .04);
        }

        .alerts {
            padding: 13px 15px;
            margin-bottom: 18px;
            border-radius: 8px;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 22px;
        }

        .search-form input,
        .search-form select {
            min-width: 0;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
            font-size: 14px;
        }

        .search-form input {
            flex: 1;
            max-width: 360px;
        }

        .btn {
            display: inline-block;
            padding: 11px 15px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }

        .btn-primary {
            background: #3730a3;
            color: white;
        }

        .btn-light {
            background: #e2e8f0;
            color: #334155;
        }

        .btn:hover {
            opacity: .85;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 12px;
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

        .order-number {
            font-weight: bold;
            color: #1e293b;
        }

        .buyer-name {
            margin-bottom: 4px;
            font-weight: bold;
        }

        .buyer-email {
            color: #64748b;
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .status-rejected, .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            padding: 38px 20px;
            text-align: center;
            color: #64748b;
        }

        .pagination {
            margin-top: 22px;
        }

        .pagination nav > div:first-child {
            margin-bottom: 10px;
        }

        .pagination a, .pagination span {
            padding: 5px 9px;
        }

        @media (max-width: 800px) {
            .layout { display: block; }

            .sidebar {
                width: 100%;
                padding: 18px;
            }

            .brand { margin-bottom: 15px; }

            .main { padding: 18px; }

            h1 { font-size: 23px; }

            .panel { padding: 14px; }

            .search-form {
                flex-direction: column;
            }

            .search-form input,
            .search-form select {
                width: 100%;
                max-width: none;
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
        <div class="topbar">
            <div>
                <h1>Pesanan Pembeli</h1>
                <div class="muted">
                    Periksa pesanan masuk dan kelola konfirmasi pesanan.
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alerts success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alerts error">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alerts error">
                <strong>Pesanan belum berhasil diproses:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="panel">
            <form
                class="search-form"
                action="{{ route('orders.index') }}"
                method="GET"
            >
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nomor pesanan, nama, email, atau HP..."
                >

                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected($status === 'pending')>
                        Menunggu Konfirmasi
                    </option>
                    <option value="confirmed" @selected($status === 'confirmed')>
                        Disetujui
                    </option>
                    <option value="rejected" @selected($status === 'rejected')>
                        Ditolak
                    </option>
                    <option value="cancelled" @selected($status === 'cancelled')>
                        Dibatalkan
                    </option>
                </select>

                <button class="btn btn-primary" type="submit">Cari</button>

                @if ($search !== '' || $status !== '')
                    <a class="btn btn-light" href="{{ route('orders.index') }}">
                        Reset
                    </a>
                @endif
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Pesanan</th>
                            <th>Pembeli</th>
                            <th>Tanggal</th>
                            <th>Total Barang</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($orders as $order)
                        @php
                            $statusLabels = [
                                'pending' => 'Menunggu Konfirmasi',
                                'confirmed' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'cancelled' => 'Dibatalkan',
                            ];

                            $statusClasses = [
                                'pending' => 'status-pending',
                                'confirmed' => 'status-confirmed',
                                'rejected' => 'status-rejected',
                                'cancelled' => 'status-cancelled',
                            ];
                        @endphp

                        <tr>
                            <td>{{ $orders->firstItem() + $loop->index }}</td>

                            <td>
                                <div class="order-number">
                                    {{ $order->order_number }}
                                </div>
                            </td>

                            <td>
                                <div class="buyer-name">
                                    {{ $order->buyer->name ?? '-' }}
                                </div>
                                <div class="buyer-email">
                                    {{ $order->buyer->email ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $order->created_at->format('d-m-Y H:i') }}
                            </td>

                            <td>
                                {{ $order->items->sum('quantity') }} barang
                            </td>

                            <td>
                                <strong>
                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                </strong>
                            </td>

                            <td>
                                <span class="status {{ $statusClasses[$order->status] ?? 'status-pending' }}">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <a
                                    class="btn btn-primary"
                                    href="{{ route('orders.show', $order) }}"
                                >
                                    Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">
                                Belum ada pesanan Pembeli.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $orders->links() }}
            </div>
        </section>
    </main>
</div>
</body>
</html>

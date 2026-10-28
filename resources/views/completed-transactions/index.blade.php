<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Transaksi Selesai - Inventory</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 245px;
            overflow-y: auto;
            padding: 25px 16px;
            background: #172554;
            color: white;
        }

        .sidebar h2 {
            font-size: 21px;
            margin: 0 0 30px;
        }

        .sidebar a {
            display: block;
            color: #dbeafe;
            text-decoration: none;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        .main {
            margin-left: 245px;
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

        h1 {
            font-size: 27px;
            margin: 0 0 8px;
        }

        .muted {
            color: #64748b;
            font-size: 13px;
            line-height: 1.7;
        }

        .card {
            background: white;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, .03);
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .summary-card {
            background: white;
            padding: 20px;
            border-radius: 13px;
            border: 1px solid #e8edf5;
        }

        .summary-number {
            font-weight: 800;
            font-size: 27px;
            margin-top: 9px;
            color: #1d4ed8;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto auto;
            align-items: end;
            gap: 12px;
            margin-top: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 12px;
            font-weight: 700;
        }

        input {
            width: 100%;
            min-width: 0;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
        }

        .btn {
            display: inline-block;
            padding: 11px 14px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 12px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-detail {
            padding: 7px 10px;
            background: #eff6ff;
            color: #1d4ed8;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th, td {
            text-align: left;
            padding: 13px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            color: #475569;
            white-space: nowrap;
        }

        td {
            overflow-wrap: anywhere;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .purchase {
            color: #1d4ed8;
            background: #dbeafe;
        }

        .sale {
            color: #166534;
            background: #dcfce7;
        }

        .empty {
            text-align: center;
            padding: 32px;
            color: #64748b;
        }

        .pagination {
            margin-top: 20px;
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

        @media(max-width: 1100px) {
            .filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media(max-width: 700px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            .summary {
                grid-template-columns: 1fr 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

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
        <a href="{{ route('sales.index') }}">🧾 Penjualan</a>
        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a href="{{ route('reports.transactions') }}">📈 Laporan Transaksi</a>
        <a href="{{ route('completed-transactions.index') }}" class="active">
            ✅ Total Transaksi Selesai
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">↪ Keluar dari Aplikasi</button>
        </form>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Total Transaksi Selesai</h1>
                <div class="muted">
                    Daftar pembelian yang dikonfirmasi dan penjualan yang selesai.
                </div>
            </div>
        </div>

        <section class="summary">
            <div class="summary-card">
                <div class="muted">Jumlah Transaksi Sesuai Filter</div>
                <div class="summary-number">
                    {{ number_format($transactions->total(), 0, ',', '.') }}
                </div>
            </div>

            <div class="summary-card">
                <div class="muted">Jenis Transaksi</div>
                <div style="font-weight:700;margin-top:12px;">
                    Pembelian dan Penjualan
                </div>
            </div>
        </section>

        <section class="card">
            <h3 style="margin:0;">Filter Transaksi</h3>
            <div class="muted">
                Cari nomor transaksi, supplier, pengguna, atau rentang tanggal.
            </div>

            <form method="GET"
                  action="{{ route('completed-transactions.index') }}"
                  class="filter-form">

                <div>
                    <label for="search">Cari Transaksi</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nomor, supplier, atau pengguna..."
                    >
                </div>

                <div>
                    <label for="from_date">Dari Tanggal</label>
                    <input
                        id="from_date"
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                    >
                </div>

                <div>
                    <label for="to_date">Sampai Tanggal</label>
                    <input
                        id="to_date"
                        type="date"
                        name="to_date"
                        value="{{ request('to_date') }}"
                    >
                </div>

                <button type="submit" class="btn">Terapkan Filter</button>

                <a href="{{ route('completed-transactions.index') }}"
                   class="btn btn-secondary">
                    Reset
                </a>
            </form>
        </section>

        <section class="card">
            <h3 style="margin:0;">Riwayat Transaksi Selesai</h3>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nomor Transaksi</th>
                            <th>Jenis</th>
                            <th>Supplier</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th>Detail</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transactions->firstItem() + $loop->index }}</td>

                                <td>
                                    {{ $transaction->transaction_date
                                        ? \Illuminate\Support\Carbon::parse($transaction->transaction_date)->format('d-m-Y H:i')
                                        : '-' }}
                                </td>

                                <td>{{ $transaction->transaction_number }}</td>

                                <td>
                                    @if($transaction->transaction_type === 'Pembelian')
                                        <span class="badge purchase">Pembelian</span>
                                    @else
                                        <span class="badge sale">Penjualan</span>
                                    @endif
                                </td>

                                <td>{{ $transaction->party ?? '-' }}</td>

                                <td>
                                    Rp {{ number_format((float)$transaction->total, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if($transaction->status === 'confirmed')
                                        Dikonfirmasi
                                    @else
                                        Selesai
                                    @endif
                                </td>

                                <td>{{ $transaction->user_name }}</td>

                                <td>
                                    @if($transaction->transaction_type === 'Pembelian')
                                        <a
                                            href="{{ route('purchases.show', $transaction->transaction_id) }}"
                                            class="btn btn-detail"
                                        >
                                            Detail
                                        </a>
                                    @else
                                        <a
                                            href="{{ route('sales.show', $transaction->transaction_id) }}"
                                            class="btn btn-detail"
                                        >
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="empty">
                                    Belum ada transaksi selesai yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $transactions->links() }}
            </div>
        </section>
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - Inventory</title>
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
            width: 235px;
            height: 100vh;
            background: #172554;
            padding: 25px 15px;
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
        }
        .sidebar a:hover, .sidebar .active { background: #2563eb; }
        .main { margin-left: 235px; padding: 30px; }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }
        h1 { margin: 0 0 8px; font-size: 27px; }
        h3 { margin-top: 0; }
        .muted { color: #64748b; font-size: 14px; }
        .card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 3px 12px #0f172a0a;
            margin-bottom: 22px;
        }
        .filters {
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            gap: 14px;
            margin-top: 18px;
        }
        .field { flex: 1; min-width: 150px; }
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 11px 16px;
            background: #2563eb;
            color: white;
            border: 0;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }
        .secondary { background: #e2e8f0; color: #334155; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            white-space: nowrap;
        }
        th { background: #f8fafc; color: #475569; }
        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .incoming { background: #dcfce7; color: #166534; }
        .outgoing { background: #dbeafe; color: #1d4ed8; }
        .empty { text-align: center; color: #64748b; padding: 30px; }
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
            .sidebar { position: static; width: 100%; height: auto; }
            .main { margin-left: 0; padding: 18px; }
            h1 { font-size: 23px; }
        }

        @media print {
            .sidebar,
            .no-print {
                display: none !important;
            }

            .main {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            body {
                background: white !important;
                color: #172033;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #ddd;
                padding: 14px !important;
                margin-bottom: 12px;
                width: 100% !important;
            }

            .table-wrap {
                overflow: visible !important;
                width: 100% !important;
            }

            table {
               width: 100% !important;
               table-layout: fixed !important;
               border-collapse: collapse !important;
               margin-top: 12px;
            }

            th,
            td {
               white-space: normal !important;
               overflow-wrap: anywhere;
               word-break: normal;
               padding: 8px 5px !important;
               font-size: 9px !important;
               vertical-align: top;
            }

            th:nth-child(1),
            td:nth-child(1) { width: 4%; }

            th:nth-child(2),
            td:nth-child(2) { width: 10%; }

            th:nth-child(3),
            td:nth-child(3) { width: 13%; }

            th:nth-child(4),
            td:nth-child(4) { width: 11%; }

            th:nth-child(5),
            td:nth-child(5) { width: 11%; }

            th:nth-child(6),
            td:nth-child(6) { width: 7%; }

            th:nth-child(7),
            td:nth-child(7) { width: 14%; }

            th:nth-child(8),
            td:nth-child(8) { width: 30%; }

            .badge {
                white-space: normal !important;
                font-size: 8px !important;
            }
        }

    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>📦 Inventory</h2>
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('categories.index') }}">🗂️ Kategori</a>
            <a href="{{ route('products.index') }}">📦 Produk</a>
            <a href="{{ route('suppliers.index') }}">🚚 Supplier</a>
        @endif
        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a href="{{ route('reports.transactions') }}" class="active">🧾 Laporan Transaksi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">Keluar ↗</button>
        </form>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Laporan Transaksi</h1>
                <div class="muted">Riwayat barang masuk dan barang keluar.</div>
            </div>
            <button class="btn no-print" onclick="window.print()">🖨️ Cetak Laporan</button>
        </div>

        <section class="card no-print">
            <h3>Filter Transaksi</h3>
            <form action="{{ route('reports.transactions') }}" method="GET" class="filters no-print">
                <div class="field">
                    <label for="type">Jenis Transaksi</label>
                    <select name="type" id="type">
                        <option value="all" {{ $type === 'all' ? 'selected' : '' }}>Semua Transaksi</option>
                        <option value="in" {{ $type === 'in' ? 'selected' : '' }}>Stok Masuk</option>
                        <option value="out" {{ $type === 'out' ? 'selected' : '' }}>Stok Keluar</option> 
                        <option value="purchase" {{ $type === 'purchase' ? 'selected' : '' }}>
                            Pembelian
                        </option>
                        
                        <option value="sale" {{ $type === 'sale' ? 'selected' : '' }}>
                            Penjualan
                        </option>
                    </select>
                </div>
                <div class="field">
                    <label for="start_date">Dari Tanggal</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="field">
                    <label for="end_date">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <button type="submit" class="btn">Terapkan Filter</button>
                <a href="{{ route('reports.transactions') }}" class="btn secondary">Reset</a>
            </form>
        </section>

        <section class="card">
            <h3>Daftar Riwayat Transaksi</h3>
            <p class="muted">Jumlah transaksi yang sesuai dengan filter: {{ $transactions->count() }}</p>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>No. Referensi</th>
                            <th>Jenis</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga per Unit</th>
                            <th>Supplier / Pelanggan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['date'] ? \Illuminate\Support\Carbon::parse($item['date'])->format('d-m-Y') : '-' }}</td>
                                <td>{{ $item['reference'] }}</td>
                               
                                <td>
                                    @php
                                       $badgeStyle = match ($item['type']) {
                                            'Stok Masuk' => 'background:#dcfce7;color:#166534;',
                                            'Stok Keluar' => 'background:#dbeafe;color:#1d4ed8;',
                                            'Pembelian' => 'background:#ede9fe;color:#6d28d9;',
                                            'Penjualan' => 'background:#ffedd5;color:#9a3412;',
                                            default => 'background:#e2e8f0;color:#334155;',
                                       };
                                    @endphp

                                    <span class="badge" style="{{ $badgeStyle }}">
                                        {{ $item['type'] }}
                                    </span>
                                </td>
                                <td>{{ $item['product'] }}</td>
                                <td>{{ number_format($item['quantity'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $item['price'], 0, ',', '.') }}</td>
                                <td>{{ $item['party'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty">Tidak ada transaksi untuk filter yang dipilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>

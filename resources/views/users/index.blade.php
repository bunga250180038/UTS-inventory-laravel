<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Inventory</title>

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
            padding: 12px;
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
            box-shadow: 0 3px 12px rgba(15, 23, 42, .03);
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-size: 12px;
            cursor: pointer;
        }

        .btn:hover { background: #1d4ed8; }

        .btn-edit {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-delete:hover { background: #fecaca; }

        .message {
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.6;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            text-align: left;
            padding: 13px 11px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            color: #475569;
            white-space: nowrap;
        }

        .role {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .role-admin {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .role-staff {
            background: #dcfce7;
            color: #166534;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .actions form { margin: 0; }

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        .pagination { margin-top: 20px; }

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

        @media(max-width: 750px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            h1 { font-size: 23px; }

            .actions { flex-wrap: wrap; }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <h2>📦 Inventory</h2>

        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('categories.index') }}">🗂️ Kategori</a>
        <a href="{{ route('products.index') }}">📦 Kelola Produk</a>
        <a href="{{ route('suppliers.index') }}">🚚 Supplier</a>
        <a href="{{ route('users.index') }}" class="active">👥 Manajemen Pengguna</a>
        <a href="{{ route('purchases.index') }}">🛒 Pembelian</a>
        <a href="{{ route('sales.index') }}">🧾 Penjualan</a>
        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a href="{{ route('reports.transactions') }}">📈 Laporan Transaksi</a>
        <a href="{{ route('completed-transactions.index') }}">✅ Total Transaksi Selesai</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">↪ Keluar dari Aplikasi</button>
        </form>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Manajemen Pengguna</h1>
                <div class="muted">
                    Kelola akun dan hak akses pengguna Inventory.
                </div>
            </div>

            <a href="{{ route('users.create') }}" class="btn">
                + Tambah Pengguna
            </a>
        </div>

        @if(session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="message error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <section class="card">
            <div class="muted">
                Jumlah pengguna pada halaman ini: {{ $users->count() }}
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>
                                    @if($user->role === 'admin')
                                        <span class="role role-admin">ADMIN</span>
                                    @else
                                        <span class="role role-staff">STAFF</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $user->created_at?->format('d-m-Y') ?? '-' }}
                                </td>

                                <td>
                                    <div class="actions">
                                        <a
                                            href="{{ route('users.edit', $user) }}"
                                            class="btn btn-edit"
                                        >
                                            Edit
                                        </a>

                                        @if(auth()->id() !== $user->id)
                                            <form
                                                action="{{ route('users.destroy', $user) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-delete"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty">
                                    Belum ada pengguna terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $users->links() }}
            </div>
        </section>
    </main>
</body>
</html>

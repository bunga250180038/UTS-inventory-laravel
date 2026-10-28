
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier - Inventory System</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1e293b; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: #172554; color: white; padding: 28px 18px; flex-shrink: 0; }
        .brand { font-size: 21px; font-weight: bold; margin-bottom: 35px; }
        .menu { display: block; padding: 13px 15px; color: #dbeafe; text-decoration: none; border-radius: 9px; margin-bottom: 8px; }
        .menu:hover, .active { background: #2563eb; color: white; }
        .main { flex: 1; min-width: 0; padding: 30px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; margin-bottom: 25px; }
        h1 { margin: 0 0 8px; font-size: 28px; }
        .muted { color: #64748b; font-size: 14px; }
        .btn { display: inline-block; padding: 11px 16px; border: 0; border-radius: 8px; text-decoration: none; cursor: pointer; font-size: 14px; font-weight: bold; }
        .primary { background: #2563eb; color: white; }
        .edit { background: #dbeafe; color: #1d4ed8; }
        .delete { background: #fee2e2; color: #b91c1c; }
        .panel { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 4px 18px rgba(15,23,42,.05); }
        .alert { padding: 13px 15px; border-radius: 8px; margin-bottom: 18px; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .search { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
        .search input { width: 100%; max-width: 360px; padding: 11px 13px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 750px; }
        th, td { text-align: left; padding: 15px 12px; border-bottom: 1px solid #e2e8f0; }
        th { background: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase; }
        td { font-size: 14px; }
        .actions { display: flex; gap: 7px; align-items: center; }
        .actions form { margin: 0; }
        .empty { text-align: center; padding: 35px; color: #64748b; }
        .pagination { margin-top: 20px; }
        .pagination nav > div:first-child { margin-bottom: 10px; }
        .pagination a, .pagination span { padding: 5px 9px; }
        .logout { width: 100%; margin-top: 30px; background: #334155; color: white; }
        @media(max-width:760px) {
            .layout { display: block; }
            .sidebar { width: 100%; padding: 18px; }
            .brand { margin-bottom: 15px; }
            .main { padding: 18px; }
            h1 { font-size: 23px; }
            .panel { padding: 14px; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">📦 Inventory System</div>
        <a class="menu" href="{{ route('dashboard') }}">🏠 Dashboard</a>
        <a class="menu" href="{{ route('categories.index') }}">🗂️ Kategori</a>
        <a class="menu" href="{{ route('products.index') }}">📦 Produk</a>
        <a class="menu active" href="{{ route('suppliers.index') }}">🏢 Supplier</a>
        <a class="menu" href="{{ route('dashboard') }}">📥 Stok Masuk</a>
        <a class="menu" href="{{ route('dashboard') }}">📤 Stok Keluar</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn logout" type="submit">Keluar</button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>Data Supplier</h1>
                <div class="muted">Kelola informasi pemasok barang inventaris.</div>
            </div>
            <a class="btn primary" href="{{ route('suppliers.create') }}">+ Tambah Supplier</a>
        </div>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <section class="panel">
            <form class="search" action="{{ route('suppliers.index') }}" method="GET">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, kontak, telepon, atau email...">
                <button class="btn primary" type="submit">Cari</button>
                @if($search)
                    <a class="btn edit" href="{{ route('suppliers.index') }}">Reset</a>
                @endif
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Supplier</th>
                        <th>Kontak</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $supplier->name }}</strong></td>
                            <td>{{ $supplier->contact_person ?: '-' }}</td>
                            <td>{{ $supplier->phone ?: '-' }}</td>
                            <td>{{ $supplier->email ?: '-' }}</td>
                            <td>{{ $supplier->address ?: '-' }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn edit" href="{{ route('suppliers.edit', $supplier) }}">Edit</a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn delete" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">Belum ada data supplier. Klik “Tambah Supplier” untuk memulai.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">{{ $suppliers->links() }}</div>
        </section>
    </main>
</div>
</body>
</html>

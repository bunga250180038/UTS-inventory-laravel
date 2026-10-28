<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori | Inventory System</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        header { background: #102a43; color: white; padding: 20px 30px; }
        header a { color: white; text-decoration: none; }
        main { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 25px; }
        .button { display: inline-block; padding: 11px 15px; border-radius: 8px; text-decoration: none; border: 0; cursor: pointer; font-weight: bold; font-size: 14px; }
        .primary { background: #176b87; color: white; }
        .edit { background: #dbeafe; color: #1d4ed8; }
        .delete { background: #fee2e2; color: #b91c1c; }
        .back { background: #e2e8f0; color: #334155; }
        .panel { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 600px; }
        th, td { padding: 14px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #f8fafc; color: #64748b; font-size: 12px; text-transform: uppercase; }
        .alert { padding: 13px 16px; margin-bottom: 16px; border-radius: 8px; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .actions { display: flex; gap: 8px; }
        .empty { text-align: center; color: #64748b; padding: 30px; }
        .pagination { margin-top: 20px; }
        @media (max-width: 600px) { .toolbar { align-items: flex-start; flex-direction: column; } header { padding: 18px; } }
    </style>
</head>
<body>
<header>
    <a href="{{ route('dashboard') }}">📦 Inventory System / Dashboard</a>
</header>
<main>
    <div class="toolbar">
        <h1>🗂️ Data Kategori</h1>
        <div>
            <a class="button back" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="button primary" href="{{ route('categories.create') }}">+ Tambah Kategori</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert error">{{ $errors->first() }}</div>
    @endif

    <div class="panel">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->description ?: '-' }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <div class="actions">
                                <a class="button edit" href="{{ route('categories.edit', $category) }}">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button delete" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty">Belum ada kategori. Klik Tambah Kategori untuk memulai.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $categories->links() }}</div>
    </div>
</main>
</body>
</html>

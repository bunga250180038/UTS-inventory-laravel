<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Inventory System</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fc;
            color: #17233f;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            background: #172554;
            color: white;
            padding: 28px 18px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 32px;
            line-height: 1.5;
        }

        .menu {
            display: block;
            padding: 13px 15px;
            color: #dbeafe;
            text-decoration: none;
            border-radius: 9px;
            margin-bottom: 8px;
            font-size: 13px;
            transition: .2s;
        }

        .menu:hover, .menu.active {
            background: #2563eb;
            color: white;
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
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            color: #172554;
            font-size: 28px;
        }

        .muted {
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 11px 15px;
            border: 0;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            transition: .2s;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-delete {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-reset {
            background: #eef2f7;
            color: #475569;
        }

        .btn:hover {
            opacity: .88;
        }

        .panel {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .04);
        }

        .alerts {
            padding: 13px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.7;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .filter-form {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 17px;
            background: #f8faff;
            border: 1px solid #e2e8f0;
            border-radius: 11px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
            flex: 1;
            min-width: 150px;
        }

        .filter-group.search-group {
            flex: 2;
            min-width: 220px;
        }

        .filter-group label {
            color: #475569;
            font-size: 12px;
            font-weight: bold;
        }

        .filter-control {
            width: 100%;
            min-height: 41px;
            padding: 10px 12px;
            background: white;
            color: #17233f;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            font-size: 13px;
        }

        .filter-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
        }

        .filter-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .result-info {
            margin-bottom: 15px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.7;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 970px;
        }

        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .3px;
            white-space: nowrap;
        }

        td {
            font-size: 13px;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .product-image {
            display: block;
            width: 70px;
            height: 70px;
            object-fit: contain;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            background: #f8fafc;
            padding: 3px;
        }

        .no-image {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 4px;
            border: 1px dashed #cbd5e1;
            border-radius: 9px;
            background: #f8fafc;
            color: #94a3b8;
            font-size: 23px;
        }

        .no-image small {
            font-size: 9px;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .actions form {
            margin: 0;
        }

        .badge {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 11px;
            white-space: nowrap;
        }

        .stock-ok {
            background: #dcfce7;
            color: #166534;
        }

        .stock-low {
            background: #fef3c7;
            color: #92400e;
        }

        .pagination {
            margin-top: 22px;
            overflow-x: auto;
        }

        .pagination nav > div:first-child {
            margin-bottom: 10px;
        }

        .pagination a,
        .pagination span {
            padding: 5px 9px;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #64748b;
            line-height: 1.7;
        }

        .logout {
            width: 100%;
            margin-top: 25px;
            background: #334155;
            color: white;
        }

        .logout:hover {
            background: #475569;
        }

        @media (max-width: 900px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
                padding: 18px;
            }

            .brand {
                margin-bottom: 17px;
            }

            .main {
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

            .panel {
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
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">📦 Inventory System</div>

        <a class="menu" href="{{ route('dashboard') }}">🏠 Dashboard</a>
        <a class="menu" href="{{ route('categories.index') }}">🗂️ Kategori</a>
        <a class="menu active" href="{{ route('products.index') }}">📦 Produk</a>
        <a class="menu" href="{{ route('suppliers.index') }}">🏢 Supplier</a>
        <a class="menu" href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a class="menu" href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn logout" type="submit">Keluar</button>
        </form>
    </aside>

    <main class="main">

        <div class="topbar">
            <div>
                <h1>Data Produk</h1>
                <div class="muted">
                    Kelola daftar barang, harga, dan persediaan inventaris.
                </div>
            </div>

            <a class="btn btn-primary" href="{{ route('products.create') }}">
                + Tambah Produk
            </a>
        </div>

        @if (session('success'))
            <div class="alerts success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alerts error">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alerts error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <section class="panel">

            <form class="filter-form" action="{{ route('products.index') }}" method="GET">

                <div class="filter-group search-group">
                    <label for="search">Cari Produk</label>
                    <input
                        id="search"
                        class="filter-control"
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        maxlength="100"
                        placeholder="Nama produk atau SKU..."
                    >
                </div>

                <div class="filter-group">
                    <label for="category_id">Filter Kategori</label>
                    <select
                        id="category_id"
                        class="filter-control"
                        name="category_id"
                    >
                        <option value="">Semua kategori</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ (string) $categoryId === (string) $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort">Urutkan Berdasarkan</label>
                    <select id="sort" class="filter-control" name="sort">
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>
                            Tanggal ditambahkan
                        </option>

                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>
                            Nama produk
                        </option>

                        <option value="sku" {{ $sort === 'sku' ? 'selected' : '' }}>
                            SKU
                        </option>

                        <option value="purchase_price" {{ $sort === 'purchase_price' ? 'selected' : '' }}>
                            Harga beli
                        </option>

                        <option value="selling_price" {{ $sort === 'selling_price' ? 'selected' : '' }}>
                            Harga jual
                        </option>

                        <option value="stock" {{ $sort === 'stock' ? 'selected' : '' }}>
                            Stok
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="direction">Urutan</label>
                    <select id="direction" class="filter-control" name="direction">
                        <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>
                            Naik (A–Z / terkecil)
                        </option>

                        <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>
                            Turun (Z–A / terbesar)
                        </option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit">
                        Terapkan
                    </button>

                    <a class="btn btn-reset" href="{{ route('products.index') }}">
                        Reset
                    </a>
                </div>

            </form>

            <div class="result-info">
                Menampilkan {{ $products->firstItem() ?? 0 }}
                sampai {{ $products->lastItem() ?? 0 }}
                dari {{ $products->total() }} produk.
                @if ($search !== '')
                    Pencarian: <strong>{{ $search }}</strong>.
                @endif
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Foto</th>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $products->firstItem() + $loop->index }}</td>

                            <td>
                                @if ($product->image)
                                    <img
                                        class="product-image"
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="Foto {{ $product->name }}"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="no-image">
                                        📦
                                        <small>Belum ada foto</small>
                                    </div>
                                @endif
                            </td>

                            <td>{{ $product->sku }}</td>

                            <td>
                                <strong>{{ $product->name }}</strong>
                            </td>

                            <td>{{ $product->category->name ?? '-' }}</td>

                            <td>
                                Rp {{ number_format((float) $product->purchase_price, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($product->stock <= $product->minimum_stock)
                                    <span class="badge stock-low">
                                        {{ $product->stock }} {{ $product->unit }} · Menipis
                                    </span>
                                @else
                                    <span class="badge stock-ok">
                                        {{ $product->stock }} {{ $product->unit }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        class="btn btn-edit"
                                        href="{{ route('products.edit', $product) }}"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-delete" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty">
                                Tidak ada produk yang cocok dengan pencarian atau filter.
                                <br>
                                Coba ganti kata kunci atau tekan Reset.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>

        </section>
    </main>
</div>
</body>
</html>

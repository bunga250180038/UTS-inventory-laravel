<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Stok Keluar - Inventory</title>
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
        h1 { margin: 0 0 8px; font-size: 27px; }
        .muted { color: #64748b; font-size: 14px; margin-bottom: 25px; }
        .card {
            background: white;
            border-radius: 14px;
            padding: 25px;
            max-width: 850px;
            box-shadow: 0 3px 12px #0f172a0a;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .field { margin-bottom: 18px; }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            background: white;
        }
        input:focus, select:focus, textarea:focus {
            outline: 2px solid #bfdbfe;
            border-color: #2563eb;
        }
        textarea { resize: vertical; min-height: 90px; }
        .full { grid-column: 1 / -1; }
        .required { color: #dc2626; }
        .error { color: #b91c1c; font-size: 13px; margin-top: 6px; }
        .alert {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 20px;
        }
        .actions { display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
        .btn {
            display: inline-block;
            padding: 12px 18px;
            border: 0;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }
        .primary { background: #2563eb; color: white; }
        .secondary { background: #e2e8f0; color: #334155; }
        .primary:hover { background: #1d4ed8; }
        .notice {
            background: #eff6ff;
            color: #1e40af;
            border-radius: 8px;
            padding: 13px;
            font-size: 14px;
            margin-bottom: 22px;
            line-height: 1.6;
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
        @media(max-width: 700px) {
            .sidebar { position: static; width: 100%; height: auto; }
            .main { margin-left: 0; padding: 18px; }
            .form-grid { grid-template-columns: 1fr; }
            .full { grid-column: auto; }
            h1 { font-size: 23px; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>📦 Inventory</h2>
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('categories.index') }}">🗂️ Kategori</a>
        <a href="{{ route('products.index') }}">📦 Produk</a>
        <a href="{{ route('suppliers.index') }}">🚚 Supplier</a>
        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}" class="active">📤 Stok Keluar</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">Keluar ↗</button>
        </form>
    </aside>

    <main class="main">
        <h1>Tambah Stok Keluar</h1>
        <p class="muted">Catat barang yang keluar dari persediaan.</p>

        @if($errors->any())
            <div class="alert">
                <strong>Data belum berhasil disimpan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card">
            <div class="notice">
                ℹ️ Pastikan jumlah barang keluar tidak melebihi stok yang tersedia. Stok akan berkurang setelah transaksi berhasil disimpan.
            </div>

            <form action="{{ route('stock-outs.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="field">
                        <label for="reference_number">Nomor Referensi <span class="required">*</span></label>
                        <input
                            type="text"
                            id="reference_number"
                            name="reference_number"
                            value="{{ old('reference_number') }}"
                            placeholder="Contoh: SK-2026-001"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="transaction_date">Tanggal Transaksi <span class="required">*</span></label>
                        <input
                            type="date"
                            id="transaction_date"
                            name="transaction_date"
                            value="{{ old('transaction_date', date('Y-m-d')) }}"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="product_id">Produk <span class="required">*</span></label>
                        <select id="product_id" name="product_id" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option
                                    value="{{ $product->id }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}
                                >
                                    {{ $product->sku }} - {{ $product->name }}
                                    (Stok tersedia: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>

                        @if($products->isEmpty())
                            <div class="error">Belum ada produk. Tambahkan produk terlebih dahulu.</div>
                        @endif
                    </div>

                    <div class="field">
                        <label for="quantity">Jumlah Barang Keluar <span class="required">*</span></label>
                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            value="{{ old('quantity') }}"
                            min="1"
                            step="1"
                            placeholder="Contoh: 2"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="unit_price">Harga Jual per Unit (Rp) <span class="required">*</span></label>
                        <input
                            type="number"
                            id="unit_price"
                            name="unit_price"
                            value="{{ old('unit_price') }}"
                            min="0"
                            step="0.01"
                            placeholder="Contoh: 20000"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="customer_name">Nama Pelanggan</label>
                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            maxlength="255"
                            placeholder="Nama pelanggan (opsional)"
                        >
                    </div>

                    <div class="field full">
                        <label for="notes">Catatan</label>
                        <textarea
                            id="notes"
                            name="notes"
                            maxlength="2000"
                            placeholder="Misalnya: penjualan barang"
                        >{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="actions">
                    <button
                        type="submit"
                        class="btn primary"
                        {{ $products->isEmpty() ? 'disabled' : '' }}
                    >
                        💾 Simpan Transaksi
                    </button>

                    <a href="{{ route('stock-outs.index') }}" class="btn secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

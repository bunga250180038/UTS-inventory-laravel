<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pembelian - Inventory</title>

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
            width: 235px;
            overflow-y: auto;
            padding: 25px 15px;
            background: #172554;
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
            font-size: 13px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        .main {
            margin-left: 235px;
            padding: 30px;
        }

        h1 { margin: 0 0 8px; font-size: 27px; }

        h3 { margin: 0 0 18px; font-size: 17px; }

        .muted {
            color: #64748b;
            font-size: 13px;
            line-height: 1.7;
        }

        .card {
            background: white;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px rgba(15,23,42,.03);
        }

        .notice {
            padding: 14px;
            background: #eff6ff;
            color: #1e40af;
            border-radius: 9px;
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .alert {
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.7;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field { min-width: 0; }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
            font-size: 13px;
        }

        input:focus, select:focus {
            outline: 2px solid #bfdbfe;
            border-color: #2563eb;
        }

        .required { color: #dc2626; }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 12px 9px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
            vertical-align: middle;
        }

        th {
            color: #475569;
            background: #f8fafc;
        }

        td input, td select { min-width: 110px; }

        .btn {
            display: inline-block;
            padding: 11px 15px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
        }

        .btn:hover { background: #1d4ed8; }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-secondary:hover { background: #cbd5e1; }

        .btn-danger {
            padding: 8px 10px;
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-danger:hover { background: #fecaca; }

        .btn:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .action-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            .form-grid { grid-template-columns: 1fr; }

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

        <a href="{{ route('purchases.index') }}" class="active">🛒 Pembelian</a>
        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a href="{{ route('reports.transactions') }}">🧾 Laporan Transaksi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">↪ Keluar dari Aplikasi</button>
        </form>
    </aside>

    <main class="main">
        <div style="margin-bottom:25px;">
            <h1>Buat Pembelian</h1>
            <div class="muted">
                Catat penerimaan barang dari supplier dalam satu transaksi.
            </div>
        </div>

        @if($errors->any())
            <div class="alert error">
                <strong>Data belum berhasil disimpan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="notice">
            ℹ️ Pembelian baru disimpan sebagai draft. Stok produk akan bertambah
            setelah Admin mengonfirmasi pembelian.
        </div>

        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf

            <section class="card">
                <h3>Informasi Pembelian</h3>

                <div class="form-grid">
                    <div class="field">
                        <label for="purchase_number">
                            Nomor Pembelian <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="purchase_number"
                            name="purchase_number"
                            value="{{ old('purchase_number') }}"
                            placeholder="Contoh: PB-2026-001"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="supplier_id">
                            Supplier <span class="required">*</span>
                        </label>

                        <select id="supplier_id" name="supplier_id" required>
                            <option value="">-- Pilih Supplier --</option>

                            @foreach($suppliers as $supplier)
                                <option
                                    value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                                >
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>

                        @if($suppliers->isEmpty())
                            <div class="muted">
                                Belum ada supplier. Tambahkan supplier terlebih dahulu.
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section class="card">
                <h3>Item Pembelian</h3>

                <p class="muted" style="margin-bottom:18px;">
                    Tambahkan satu atau beberapa produk pada transaksi ini.
                </p>

                @if($products->isEmpty())
                    <div class="alert error">
                        Belum ada produk yang tersedia. Tambahkan produk terlebih dahulu
                        sebelum membuat pembelian.
                    </div>
                @endif

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:35%;">Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Beli per Unit (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="items-body">
                            <tr class="item-row">
                                <td>
                                    <select name="items[0][product_id]" class="product-select" required>
                                        <option value="">-- Pilih Produk --</option>

                                        @foreach($products as $product)
                                            <option
                                                value="{{ $product->id }}"
                                                data-cost="{{ $product->purchase_price }}"
                                            >
                                                {{ $product->sku }} - {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input
                                        type="number"
                                        name="items[0][quantity]"
                                        min="1"
                                        step="1"
                                        value="1"
                                        required
                                    >
                                </td>

                                <td>
                                    <input
                                        type="number"
                                        name="items[0][unit_cost]"
                                        class="unit-cost"
                                        min="0"
                                        step="0.01"
                                        placeholder="Harga beli"
                                        required
                                    >
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger remove-row">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:17px;">
                    <button type="button" class="btn btn-secondary" id="add-item">
                        + Tambah Produk
                    </button>
                </div>
            </section>

            <div class="actions">
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <div class="action-group">
                    <button
                        type="submit"
                        class="btn"
                        {{ $products->isEmpty() || $suppliers->isEmpty() ? 'disabled' : '' }}
                    >
                        💾 Simpan Draft Pembelian
                    </button>
                </div>
            </div>
        </form>
    </main>

    <template id="item-template">
        <tr class="item-row">
            <td>
                <select name="items[__INDEX__][product_id]" class="product-select" required>
                    <option value="">-- Pilih Produk --</option>

                    @foreach($products as $product)
                        <option
                            value="{{ $product->id }}"
                            data-cost="{{ $product->purchase_price }}"
                        >
                            {{ $product->sku }} - {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <input
                    type="number"
                    name="items[__INDEX__][quantity]"
                    min="1"
                    step="1"
                    value="1"
                    required
                >
            </td>

            <td>
                <input
                    type="number"
                    name="items[__INDEX__][unit_cost]"
                    class="unit-cost"
                    min="0"
                    step="0.01"
                    placeholder="Harga beli"
                    required
                >
            </td>

            <td>
                <button type="button" class="btn btn-danger remove-row">
                    Hapus
                </button>
            </td>
        </tr>
    </template>

    <script>
        (() => {
            const itemsBody = document.getElementById('items-body');
            const template = document.getElementById('item-template');
            const addButton = document.getElementById('add-item');

            let nextIndex = 1;

            function updateProductPrice(select) {
                const row = select.closest('.item-row');
                const priceInput = row.querySelector('.unit-cost');
                const option = select.options[select.selectedIndex];

                if (option && option.dataset.cost !== undefined && select.value) {
                    priceInput.value = option.dataset.cost;
                } else {
                    priceInput.value = '';
                }
            }

            addButton.addEventListener('click', () => {
                const html = template.innerHTML.replace(/__INDEX__/g, nextIndex);
                itemsBody.insertAdjacentHTML('beforeend', html);
                nextIndex++;
            });

            itemsBody.addEventListener('change', (event) => {
                if (event.target.matches('.product-select')) {
                    updateProductPrice(event.target);
                }
            });

            itemsBody.addEventListener('click', (event) => {
                const button = event.target.closest('.remove-row');

                if (!button) return;

                const rows = itemsBody.querySelectorAll('.item-row');

                if (rows.length <= 1) {
                    alert('Minimal harus ada satu produk dalam pembelian.');
                    return;
                }

                button.closest('.item-row').remove();
            });
        })();
    </script>
</body>
</html>

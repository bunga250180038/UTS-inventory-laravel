<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Penjualan - Inventory</title>

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

        input[readonly] {
            background: #f8fafc;
            color: #475569;
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
            min-width: 750px;
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

        td input, td select { min-width: 90px; }

        .price, .subtotal {
            font-weight: 600;
            white-space: nowrap;
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

        .total-box {
            margin-top: 22px;
            padding: 20px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .total-label { color: #64748b; font-size: 13px; }

        .total-value {
            color: #1d4ed8;
            font-size: 23px;
            font-weight: 800;
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

            .total-value { font-size: 19px; }
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
        <a href="{{ route('sales.index') }}" class="active">🧾 Penjualan</a>
        <a href="{{ route('stock-ins.index') }}">📥 Stok Masuk</a>
        <a href="{{ route('stock-outs.index') }}">📤 Stok Keluar</a>
        <a href="{{ route('reports.index') }}">📊 Laporan Persediaan</a>
        <a href="{{ route('reports.transactions') }}">📈 Laporan Transaksi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button type="submit">↪ Keluar dari Aplikasi</button>
        </form>
    </aside>

    <main class="main">
        <div style="margin-bottom:25px;">
            <h1>Buat Penjualan</h1>
            <div class="muted">
                Catat penjualan satu atau beberapa produk dalam satu transaksi.
            </div>
        </div>

        @if($errors->any())
            <div class="alert error">
                <strong>Penjualan belum berhasil disimpan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="notice">
            ℹ️ Harga jual dan total resmi dihitung oleh server berdasarkan data produk.
            Stok hanya dikurangi jika seluruh penjualan berhasil diproses.
        </div>

        @if($products->isEmpty())
            <div class="alert error">
                Belum ada produk yang tersedia untuk dijual. Tambahkan produk terlebih dahulu.
            </div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST" id="sale-form">
            @csrf

            <section class="card">
                <h3>Informasi Penjualan</h3>

                <div class="form-grid">
                    <div class="field">
                        <label for="sale_number">
                            Nomor Penjualan <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="sale_number"
                            name="sale_number"
                            value="{{ old('sale_number', 'PJ-' . date('Ymd-His')) }}"
                            maxlength="100"
                            placeholder="Contoh: PJ-20261026-001"
                            required
                        >
                        <div class="muted">Nomor harus unik untuk setiap transaksi.</div>
                    </div>
                </div>
            </section>

            <section class="card">
                <h3>Item Penjualan</h3>

                <p class="muted" style="margin-bottom:18px;">
                    Pilih produk dan kuantitas. Harga yang ditampilkan adalah harga jual
                    produk di database dan digunakan kembali oleh server saat menyimpan.
                </p>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:34%;">Produk</th>
                                <th>Stok Tersedia</th>
                                <th>Jumlah</th>
                                <th>Harga per Unit</th>
                                <th>Subtotal Perkiraan</th>
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
                                                data-price="{{ $product->selling_price }}"
                                                data-stock="{{ $product->stock }}"
                                            >
                                                {{ $product->sku }} - {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="stock-cell">-</td>

                                <td>
                                    <input
                                        type="number"
                                        name="items[0][quantity]"
                                        class="quantity-input"
                                        min="1"
                                        step="1"
                                        value="1"
                                        required
                                    >
                                </td>

                                <td class="price">-</td>
                                <td class="subtotal">-</td>

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

                <div class="total-box">
                    <div>
                        <div class="total-label">Estimasi Total Penjualan</div>
                        <div class="muted">Nilai resmi dihitung ulang oleh server.</div>
                    </div>
                    <div class="total-value" id="grand-total">Rp 0</div>
                </div>
            </section>

            <div class="actions">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn"
                    {{ $products->isEmpty() ? 'disabled' : '' }}
                >
                    💾 Simpan Penjualan
                </button>
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
                            data-price="{{ $product->selling_price }}"
                            data-stock="{{ $product->stock }}"
                        >
                            {{ $product->sku }} - {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td class="stock-cell">-</td>

            <td>
                <input
                    type="number"
                    name="items[__INDEX__][quantity]"
                    class="quantity-input"
                    min="1"
                    step="1"
                    value="1"
                    required
                >
            </td>

            <td class="price">-</td>
            <td class="subtotal">-</td>

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
            const grandTotal = document.getElementById('grand-total');

            let nextIndex = 1;

            function rupiah(value) {
                return 'Rp ' + Number(value).toLocaleString('id-ID', {
                    maximumFractionDigits: 2
                });
            }

            function updateRow(row) {
                const select = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');
                const priceCell = row.querySelector('.price');
                const stockCell = row.querySelector('.stock-cell');
                const subtotalCell = row.querySelector('.subtotal');

                const option = select.options[select.selectedIndex];
                const selected = select.value !== '';
                const price = selected ? Number(option.dataset.price || 0) : 0;
                const stock = selected ? Number(option.dataset.stock || 0) : 0;
                const quantity = Math.max(0, Number(quantityInput.value || 0));

                stockCell.textContent = selected ? stock.toLocaleString('id-ID') : '-';
                priceCell.textContent = selected ? rupiah(price) : '-';
                subtotalCell.textContent = selected && quantity > 0
                    ? rupiah(price * quantity)
                    : '-';

                quantityInput.max = selected ? String(stock) : '';

                return selected && quantity > 0 ? price * quantity : 0;
            }

            function updateTotals() {
                let total = 0;

                itemsBody.querySelectorAll('.item-row').forEach((row) => {
                    total += updateRow(row);
                });

                grandTotal.textContent = rupiah(total);
            }

            addButton.addEventListener('click', () => {
                const html = template.innerHTML.replace(/__INDEX__/g, nextIndex);
                itemsBody.insertAdjacentHTML('beforeend', html);
                nextIndex++;
                updateTotals();
            });

            itemsBody.addEventListener('change', (event) => {
                if (
                    event.target.matches('.product-select') ||
                    event.target.matches('.quantity-input')
                ) {
                    updateTotals();
                }
            });

            itemsBody.addEventListener('input', (event) => {
                if (event.target.matches('.quantity-input')) {
                    updateTotals();
                }
            });

            itemsBody.addEventListener('click', (event) => {
                const button = event.target.closest('.remove-row');

                if (!button) return;

                const rows = itemsBody.querySelectorAll('.item-row');

                if (rows.length <= 1) {
                    alert('Minimal harus ada satu item penjualan.');
                    return;
                }

                button.closest('.item-row').remove();
                updateTotals();
            });

            updateTotals();
        })();
    </script>
</body>
</html>

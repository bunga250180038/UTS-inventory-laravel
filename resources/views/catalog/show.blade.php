<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | Inventory System</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .navbar {
            padding: 18px 5%;
            background: #172554;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .brand { font-size: 20px; font-weight: bold; }

        .brand small {
            display: block;
            margin-top: 5px;
            color: #c7d2fe;
            font-size: 12px;
            font-weight: normal;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .welcome {
            font-size: 14px;
            color: #e0e7ff;
        }

        .logout-button, .orders-link {
            display: inline-block;
            padding: 10px 13px;
            background: white;
            color: #172554;
            border: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .container {
            max-width: 1000px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #4338ca;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .product-panel {
            display: grid;
            grid-template-columns: minmax(0, .85fr) minmax(0, 1.15fr);
            gap: 30px;
            padding: 28px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .05);
        }

        .product-visual {
            min-height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #eef2ff;
            border-radius: 12px;
        }

        .product-image {
            display: block;
            width: 100%;
            height: 320px;
            object-fit: contain;
            padding: 10px;
        }

        .product-placeholder { font-size: 90px; }

        .category {
            color: #4338ca;
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        h1 {
            margin: 0 0 18px;
            font-size: 28px;
            overflow-wrap: anywhere;
        }

        .sku {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .price {
            color: #3730a3;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .info-row {
            padding: 14px 0;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            gap: 15px;
            font-size: 14px;
        }

        .info-label { color: #64748b; }

        .info-value {
            text-align: right;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .available { color: #15803d; }
        .unavailable { color: #dc2626; }

        .notice {
            margin-top: 22px;
            padding: 14px;
            background: #f8fafc;
            border-radius: 9px;
            color: #475569;
            font-size: 13px;
            line-height: 1.7;
        }

        .order-panel {
            margin-top: 25px;
            padding: 28px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .04);
        }

        .order-panel h2 {
            margin: 0 0 8px;
            font-size: 22px;
        }

        .order-description {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .form-group { margin-bottom: 18px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            font: inherit;
            font-size: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        input:focus, select:focus, textarea:focus {
            outline: 2px solid #c7d2fe;
            border-color: #4f46e5;
        }

        .help {
            display: block;
            margin-top: 6px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.6;
        }

        .error-box {
            margin-bottom: 20px;
            padding: 14px;
            border-radius: 9px;
            background: #fee2e2;
            color: #991b1b;
            font-size: 13px;
        }

        .total-box {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 16px;
            background: #eef2ff;
            border-radius: 9px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .total-price {
            color: #3730a3;
            text-align: right;
        }

        .order-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 9px;
            background: #3730a3;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .order-button:hover { background: #312e81; }

        .order-button:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        footer {
            padding: 25px;
            text-align: center;
            color: #64748b;
            font-size: 13px;
        }

        @media (max-width: 700px) {
            .container {
                margin: 24px auto;
                padding: 0 15px;
            }

            .product-panel {
                grid-template-columns: 1fr;
                padding: 20px;
                gap: 22px;
            }

            .product-visual { min-height: 230px; }
            .product-image { height: 280px; }
            .product-placeholder { font-size: 70px; }
            h1 { font-size: 24px; }
            .price { font-size: 24px; }
            .order-panel { padding: 20px; }
        }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="brand">
            🛍️ Inventory System
            <small>Katalog Produk Pembeli</small>
        </div>

        <div class="nav-right">
            <span class="welcome">
                Halo, {{ auth()->user()->name }}
            </span>

            <a href="{{ route('buyer.orders.index') }}" class="orders-link">
                Pesanan Saya
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Keluar</button>
            </form>
        </div>
    </header>

    <main class="container">
        <a href="{{ route('catalog.index') }}" class="back-link">
            ← Kembali ke Katalog
        </a>

        <section class="product-panel">
            <div class="product-visual">
                @if ($product->image)
                    <img
                        class="product-image"
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="Foto {{ $product->name }}"
                    >
                @else
                    <div class="product-placeholder">📦</div>
                @endif
            </div>

            <div>
                <div class="category">
                    {{ $product->category?->name ?? 'Tanpa Kategori' }}
                </div>

                <h1>{{ $product->name }}</h1>

                <div class="sku">
                    SKU: {{ $product->sku ?: '-' }}
                </div>

                <div class="price">
                    Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                </div>

                <div class="info-row">
                    <span class="info-label">Kategori</span>
                    <span class="info-value">
                        {{ $product->category?->name ?? 'Tanpa Kategori' }}
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Satuan</span>
                    <span class="info-value">{{ $product->unit }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Stok</span>
                    <span class="info-value {{ $product->stock > 0 ? 'available' : 'unavailable' }}">
                        @if ($product->stock > 0)
                            Tersedia ({{ $product->stock }} {{ $product->unit }})
                        @else
                            Stok Habis
                        @endif
                    </span>
                </div>

                <div class="notice">
                    {{ $product->description ?: 'Belum ada deskripsi untuk produk ini.' }}
                </div>
            </div>
        </section>

        <section class="order-panel">
            <h2>Pesan Produk</h2>

            <p class="order-description">
                Isi jumlah barang dan informasi pengiriman. Pesanan menunggu
                konfirmasi Admin atau Staff dan stok belum dikurangi saat pesanan diajukan.
            </p>

            @if ($errors->any())
                <div class="error-box">
                    <strong>Pesanan belum berhasil dibuat:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($product->stock > 0)
                <form method="POST" action="{{ route('buyer.orders.store') }}">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="form-group">
                        <label for="quantity">Jumlah Barang</label>
                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            value="{{ old('quantity', 1) }}"
                            min="1"
                            max="{{ $product->stock }}"
                            step="1"
                            required
                        >
                        <small class="help">
                            Stok saat ini: {{ $product->stock }} {{ $product->unit }}.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="customer_phone">Nomor HP Pembeli</label>
                        <input
                            type="tel"
                            id="customer_phone"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            maxlength="30"
                            placeholder="Contoh: 081234567890"
                            autocomplete="tel"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="shipping_address">Alamat Pengiriman</label>
                        <textarea
                            id="shipping_address"
                            name="shipping_address"
                            maxlength="2000"
                            placeholder="Masukkan alamat lengkap pengiriman"
                            autocomplete="street-address"
                            required
                        >{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Metode Pembayaran</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="cod" @selected(old('payment_method', 'cod') === 'cod')>
                                Bayar di Tempat (COD)
                            </option>
                            <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>
                                Transfer Bank
                            </option>
                            <option value="e_wallet" @selected(old('payment_method') === 'e_wallet')>
                                E-Wallet
                            </option>
                        </select>

                        <small class="help">
                            Pembayaran dicatat secara manual. Untuk Transfer Bank dan
                            E-Wallet, informasi pembayaran akan diberikan pengelola toko.
                            Jangan mengirim pembayaran ke nomor rekening yang belum
                            diverifikasi.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan (Opsional)</label>
                        <textarea
                            id="notes"
                            name="notes"
                            maxlength="2000"
                            placeholder="Catatan tambahan untuk pesanan"
                        >{{ old('notes') }}</textarea>
                    </div>

                    <div class="total-box">
                        <span>Perkiraan Total</span>
                        <span class="total-price" id="order-total">
                            Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" class="order-button">
                        Buat Pesanan
                    </button>
                </form>
            @else
                <div class="error-box">
                    Produk sedang habis dan belum bisa dipesan.
                </div>

                <button class="order-button" type="button" disabled>
                    Stok Habis
                </button>
            @endif
        </section>
    </main>

    <footer>
        Inventory Management System © {{ date('Y') }}
    </footer>

    <script>
        const quantityInput = document.getElementById('quantity');
        const totalElement = document.getElementById('order-total');

        const unitPrice = {{ (float) $product->selling_price }};
        const maxStock = {{ (int) $product->stock }};

        function updateOrderTotal() {
            if (!quantityInput || !totalElement) {
                return;
            }

            let quantity = parseInt(quantityInput.value, 10);

            if (!Number.isFinite(quantity) || quantity < 1) {
                quantity = 1;
            }

            if (maxStock > 0 && quantity > maxStock) {
                quantity = maxStock;
                quantityInput.value = maxStock;
            }

            const total = unitPrice * quantity;

            totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 0
            }).format(total);
        }

        if (quantityInput) {
            quantityInput.addEventListener('input', updateOrderTotal);
            quantityInput.addEventListener('change', updateOrderTotal);
            updateOrderTotal();
        }
    </script>
</body>
</html>

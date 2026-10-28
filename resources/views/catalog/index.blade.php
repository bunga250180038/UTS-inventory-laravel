<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk | Inventory Store</title>

    <style>
        :root {
            --navy: #172554;
            --navy-dark: #12204a;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #e8efff;
            --background: #f4f7fc;
            --white: #ffffff;
            --text: #17233f;
            --muted: #64748b;
            --border: #e2e8f0;
            --green: #15803d;
            --green-soft: #dcfce7;
            --red: #b91c1c;
            --red-soft: #fee2e2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        /* NAVIGASI */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(23, 37, 84, .04);
        }

        .navbar {
            max-width: 1300px;
            min-height: 78px;
            margin: auto;
            padding: 13px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            color: white;
            background: linear-gradient(135deg, var(--navy), var(--primary));
            font-size: 23px;
        }

        .brand-name {
            color: var(--navy);
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-caption {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #475569;
            font-size: 14px;
            font-weight: 700;
            transition: background .2s, color .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .account-area {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .account-avatar {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #dbeafe;
            color: var(--navy);
            font-weight: 800;
            font-size: 15px;
        }

        .account-info {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .account-info strong {
            display: block;
            color: var(--text);
            font-size: 13px;
        }

        .logout-button {
            padding: 11px 14px;
            color: var(--red);
            background: var(--red-soft);
            border: none;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .logout-button:hover {
            background: #fecaca;
        }

        /* KONTEN */
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 28px 25px 48px;
        }

        /* BANNER UTAMA */
        .hero {
            position: relative;
            min-height: 265px;
            padding: 40px 43px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            overflow: hidden;
            border-radius: 21px;
            color: white;
            background: linear-gradient(115deg, #1e3a8a 0%, #2458d6 58%, #3777f5 100%);
            box-shadow: 0 12px 28px rgba(37, 99, 235, .13);
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            right: -85px;
            top: -130px;
            border: 35px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            right: 145px;
            bottom: -125px;
            background: rgba(255, 255, 255, .07);
            border-radius: 50%;
        }

        .hero-content {
            max-width: 720px;
            position: relative;
            z-index: 1;
        }

        .hero-label {
            display: inline-block;
            padding: 8px 13px;
            margin-bottom: 16px;
            color: white;
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .hero h1 {
            margin: 0 0 14px;
            font-size: clamp(28px, 3.5vw, 40px);
            line-height: 1.2;
            letter-spacing: -.8px;
        }

        .hero p {
            max-width: 610px;
            margin: 0;
            color: #e7edff;
            font-size: 15px;
            line-height: 1.8;
        }

        .hero-art {
            position: relative;
            z-index: 1;
            width: 150px;
            height: 150px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, .10);
            font-size: 77px;
        }

        /* PESAN BERHASIL / GAGAL */
        .alert {
            margin-top: 20px;
            padding: 15px 18px;
            border-radius: 11px;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert-success {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        /* PENCARIAN */
        .search-panel {
            margin-top: 23px;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: 0 4px 14px rgba(23, 37, 84, .025);
        }

        .search-heading h2 {
            margin: 0 0 6px;
            color: var(--navy);
            font-size: 17px;
        }

        .search-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .search-box {
            position: relative;
            width: min(100%, 450px);
        }

        .search-symbol {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 17px;
        }

        .search-box input {
            width: 100%;
            padding: 14px 15px 14px 43px;
            color: var(--text);
            background: #f8faff;
            border: 1px solid #d8e1f0;
            border-radius: 10px;
            outline: none;
            transition: .2s;
        }

        .search-box input:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        /* JUDUL KATALOG */
        .section-heading {
            margin: 34px 0 19px;
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 15px;
        }

        .section-heading h2 {
            margin: 0 0 7px;
            color: var(--navy);
            font-size: 25px;
            letter-spacing: -.5px;
        }

        .section-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .product-count {
            display: inline-block;
            padding: 10px 14px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* KARTU PRODUK */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .product-card {
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 15px;
            transition: transform .2s, box-shadow .2s, border-color .2s;
        }

        .product-card:hover {
            transform: translateY(-4px);
            border-color: #c8d7f8;
            box-shadow: 0 14px 28px rgba(23, 37, 84, .09);
        }

        .product-image-link {
            display: block;
            background: #f3f6fc;
        }

        .product-image {
            display: block;
            width: 100%;
            height: 210px;
            padding: 13px;
            object-fit: contain;
            background: #f3f6fc;
        }

        .image-placeholder {
            width: 100%;
            height: 210px;
            display: grid;
            place-items: center;
            background: #f3f6fc;
            font-size: 65px;
        }

        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 17px;
        }

        .category-label {
            display: inline-block;
            align-self: flex-start;
            padding: 6px 9px;
            margin-bottom: 11px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }

        .product-name {
            margin: 0;
            color: var(--navy);
            font-size: 16px;
            line-height: 1.45;
            overflow-wrap: anywhere;
        }

        .product-sku {
            margin-top: 6px;
            color: var(--muted);
            font-size: 11px;
        }

        .product-description {
            min-height: 40px;
            margin: 12px 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .price-label {
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .product-price {
            color: var(--primary);
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -.4px;
            overflow-wrap: anywhere;
        }

        .stock-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin: 14px 0 16px;
            font-size: 12px;
        }

        .stock-available {
            color: var(--green);
            font-weight: 700;
        }

        .stock-empty {
            color: var(--red);
            font-weight: 700;
        }

        .detail-button {
            display: block;
            width: 100%;
            margin-top: auto;
            padding: 12px 10px;
            text-align: center;
            color: white;
            background: var(--primary);
            border: none;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            transition: background .2s;
        }

        .detail-button:hover {
            background: var(--primary-dark);
        }

        .detail-button.disabled {
            color: #64748b;
            background: #e2e8f0;
            cursor: not-allowed;
        }

        /* KEADAAN KOSONG */
        .empty-state {
            padding: 45px 20px;
            text-align: center;
            color: var(--muted);
            background: white;
            border: 1px dashed #cbd5e1;
            border-radius: 15px;
        }

        .empty-icon {
            margin-bottom: 12px;
            font-size: 47px;
        }

        .empty-state h3 {
            margin: 0 0 9px;
            color: var(--navy);
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
            line-height: 1.7;
        }

        /* KEUNGGULAN */
        .benefits {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .benefit {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 18px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
        }

        .benefit-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            background: var(--primary-soft);
            border-radius: 11px;
            font-size: 21px;
        }

        .benefit strong {
            display: block;
            margin-bottom: 5px;
            color: var(--navy);
            font-size: 13px;
        }

        .benefit span {
            display: block;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        /* FOOTER */
        .footer {
            padding: 24px 20px;
            color: var(--muted);
            background: white;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 12px;
            line-height: 1.8;
        }

        .footer strong {
            color: var(--navy);
        }

        /* RESPONSIVE */
        @media (max-width: 1050px) {
            .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .navbar {
                gap: 15px;
            }

            .account-info {
                display: none;
            }
        }

        @media (max-width: 760px) {
            .navbar {
                padding: 13px 16px;
                flex-wrap: wrap;
                gap: 12px;
            }

            .brand {
                flex: 1;
            }

            .brand-caption {
                display: none;
            }

            .nav-links {
                order: 3;
                width: 100%;
                padding-top: 10px;
                border-top: 1px solid var(--border);
            }

            .nav-link {
                padding: 10px 12px;
                font-size: 13px;
            }

            .account-area {
                gap: 8px;
            }

            .logout-button {
                padding: 9px 10px;
            }

            .container {
                padding: 19px 15px 35px;
            }

            .hero {
                min-height: auto;
                padding: 29px 23px;
                border-radius: 16px;
            }

            .hero h1 {
                font-size: 29px;
            }

            .hero p {
                font-size: 13px;
            }

            .hero-art {
                width: 90px;
                height: 90px;
                font-size: 46px;
            }

            .search-panel {
                padding: 18px;
            }

            .search-box {
                width: 100%;
            }

            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 13px;
            }

            .product-image,
            .image-placeholder {
                height: 160px;
            }

            .product-info {
                padding: 13px;
            }

            .product-name {
                font-size: 14px;
            }

            .product-price {
                font-size: 18px;
            }

            .section-heading h2 {
                font-size: 21px;
            }

            .benefits {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 420px) {
            .brand-name {
                font-size: 16px;
            }

            .brand-icon {
                width: 39px;
                height: 39px;
            }

            .hero-art {
                display: none;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .product-image,
            .image-placeholder {
                height: 135px;
            }

            .product-info {
                padding: 10px;
            }

            .product-description {
                min-height: 55px;
                font-size: 11px;
            }

            .stock-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .detail-button {
                padding: 11px 5px;
                font-size: 11px;
            }
        }
    </style>
</head>

<body>

<header class="topbar">
    <div class="navbar">

        <a href="{{ route('catalog.index') }}" class="brand">
            <div class="brand-icon">📦</div>
            <div>
                <div class="brand-name">Inventory Store</div>
                <span class="brand-caption">Belanja mudah, nyaman, dan praktis</span>
            </div>
        </a>

        <nav class="nav-links" aria-label="Menu Pembeli">
            <a href="{{ route('catalog.index') }}" class="nav-link active">
                🏠 Katalog
            </a>

            <a href="{{ route('buyer.orders.index') }}" class="nav-link">
                📦 Pesanan Saya
            </a>
        </nav>

        <div class="account-area">
            <div class="account-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
            </div>

            <div class="account-info">
                Halo,
                <strong>{{ auth()->user()->name ?? 'Pembeli' }}</strong>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Keluar</button>
            </form>
        </div>

    </div>
</header>

<main class="container">

    <section class="hero">
        <div class="hero-content">
            <span class="hero-label">✨ Selamat datang di toko kami</span>

            <h1>Temukan Produk yang Kamu Butuhkan</h1>

            <p>
                Jelajahi koleksi produk yang tersedia, lihat informasi dan harga,
                lalu pesan produk dengan mudah melalui katalog kami.
            </p>
        </div>

        <div class="hero-art" aria-hidden="true">🛒</div>
    </section>

    @if (session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Mohon periksa kembali:</strong>
            <ul style="margin-bottom:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="search-panel">
        <div class="search-heading">
            <h2>Cari Produk</h2>
            <p>Gunakan nama produk, kode barang, atau kategori.</p>
        </div>

        <div class="search-box">
            <span class="search-symbol" aria-hidden="true">🔎</span>
            <input
                type="search"
                id="productSearch"
                placeholder="Contoh: panci, BRG-001..."
                aria-label="Cari produk"
                autocomplete="off"
            >
        </div>
    </section>

    <section>
        <div class="section-heading">
            <div>
                <h2>Katalog Produk</h2>
                <p>Pilih produk untuk melihat detail dan melakukan pemesanan.</p>
            </div>

            <span class="product-count">
                {{ $products->count() }} produk ditampilkan
            </span>
        </div>

        @if ($products->count() > 0)

            <div class="product-grid" id="productGrid">

                @foreach ($products as $product)
                    @php
                        $categoryName = optional($product->category)->name ?? 'Umum';

                        $productSearchText = strtolower(
                            ($product->name ?? '') . ' ' .
                            ($product->sku ?? '') . ' ' .
                            $categoryName . ' ' .
                            ($product->description ?? '')
                        );
                    @endphp

                    <article
                        class="product-card"
                        data-search="{{ $productSearchText }}"
                    >

                        <a
                            href="{{ route('catalog.show', $product) }}"
                            class="product-image-link"
                            aria-label="Lihat detail {{ $product->name }}"
                        >
                            @if ($product->image)
                                <img
                                    class="product-image"
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                                >

                                <div class="image-placeholder" style="display:none;">
                                    📦
                                </div>
                            @else
                                <div class="image-placeholder">📦</div>
                            @endif
                        </a>

                        <div class="product-info">

                            <span class="category-label">
                                {{ $categoryName }}
                            </span>

                            <h3 class="product-name">
                                {{ $product->name }}
                            </h3>

                            <div class="product-sku">
                                Kode: {{ $product->sku ?? '-' }}
                            </div>

                            <p class="product-description">
                                {{ \Illuminate\Support\Str::limit($product->description ?? 'Informasi produk tersedia pada halaman detail.', 75) }}
                            </p>

                            <span class="price-label">Harga jual</span>

                            <div class="product-price">
                                Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                            </div>

                            <div class="stock-row">
                                <span>
                                    Satuan: {{ $product->unit ?? 'pcs' }}
                                </span>

                                @if ((int) $product->stock > 0)
                                    <span class="stock-available">
                                        Stok {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="stock-empty">
                                        Stok habis
                                    </span>
                                @endif
                            </div>

                            @if ((int) $product->stock > 0)
                                <a
                                    href="{{ route('catalog.show', $product) }}"
                                    class="detail-button"
                                >
                                    Lihat Detail &amp; Pesan →
                                </a>
                            @else
                                <span class="detail-button disabled">
                                    Produk Habis
                                </span>
                            @endif

                        </div>
                    </article>
                @endforeach

            </div>

            <div
                id="noSearchResult"
                class="empty-state"
                style="display:none; margin-top:20px;"
            >
                <div class="empty-icon">🔍</div>
                <h3>Produk tidak ditemukan</h3>
                <p>Coba gunakan kata pencarian yang berbeda.</p>
            </div>

        @else

            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3>Belum Ada Produk</h3>
                <p>
                    Produk belum tersedia di katalog.
                    Silakan periksa kembali nanti.
                </p>
            </div>

        @endif
    </section>

    <section class="benefits">

        <div class="benefit">
            <div class="benefit-icon">🛒</div>
            <div>
                <strong>Pemesanan Praktis</strong>
                <span>
                    Pilih produk dan isi informasi pesanan pada halaman detail.
                </span>
            </div>
        </div>

        <div class="benefit">
            <div class="benefit-icon">💳</div>
            <div>
                <strong>Pilihan Pembayaran</strong>
                <span>
                    Pilih COD, transfer bank, atau E-Wallet saat memesan.
                </span>
            </div>
        </div>

        <div class="benefit">
            <div class="benefit-icon">📦</div>
            <div>
                <strong>Pantau Pesanan</strong>
                <span>
                    Periksa status pesanan melalui menu Pesanan Saya.
                </span>
            </div>
        </div>

    </section>

</main>

<footer class="footer">
    <strong>Inventory Store</strong>
    <br>
    Belanja lebih mudah dengan informasi produk dan pesanan yang jelas.
</footer>

<script>
    const productSearch = document.getElementById('productSearch');
    const productCards = document.querySelectorAll('.product-card');
    const noSearchResult = document.getElementById('noSearchResult');

    if (productSearch) {
        productSearch.addEventListener('input', function () {
            const keyword = this.value.trim().toLowerCase();
            let visibleCount = 0;

            productCards.forEach(function (card) {
                const searchableText = card.dataset.search || '';
                const matches = searchableText.includes(keyword);

                card.style.display = matches ? '' : 'none';

                if (matches) {
                    visibleCount++;
                }
            });

            if (noSearchResult) {
                noSearchResult.style.display =
                    visibleCount === 0 && productCards.length > 0
                        ? 'block'
                        : 'none';
            }
        });
    }
</script>

</body>
</html>

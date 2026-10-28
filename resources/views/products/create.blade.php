<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Inventory System</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1e293b;
        }

        .container {
            max-width: 900px;
            margin: 35px auto;
            padding: 20px;
        }

        .heading { margin-bottom: 25px; }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
        }

        .panel {
            background: white;
            padding: 28px;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .05);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .field { margin-bottom: 20px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font: inherit;
            background: white;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        input:focus, select:focus, textarea:focus {
            outline: 2px solid #bfdbfe;
            border-color: #2563eb;
        }

        .full { grid-column: 1 / -1; }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .errors {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .required { color: #dc2626; }

        .image-preview {
            display: none;
            width: 100%;
            max-width: 300px;
            max-height: 260px;
            object-fit: contain;
            margin-top: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 6px;
            background: #f8fafc;
        }

        .help {
            display: block;
            margin-top: 7px;
            font-size: 12px;
            line-height: 1.6;
            color: #64748b;
        }

        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .full { grid-column: auto; }

            .container {
                margin: 10px auto;
                padding: 14px;
            }

            .panel { padding: 20px; }

            h1 { font-size: 23px; }
        }
    </style>
</head>

<body>
<div class="container">
    <div class="heading">
        <h1>Tambah Produk</h1>
        <p class="muted">
            Isi informasi produk yang akan disimpan ke inventaris.
        </p>
    </div>

    <div class="panel">
        @if($errors->any())
            <div class="errors">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('products.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-grid">
                <div class="field">
                    <label for="sku">
                        SKU / Kode Produk <span class="required">*</span>
                    </label>

                    <input
                        id="sku"
                        type="text"
                        name="sku"
                        value="{{ old('sku') }}"
                        placeholder="Contoh: BRG-001"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="field">
                    <label for="name">
                        Nama Produk <span class="required">*</span>
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama produk"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="field">
                    <label for="category_id">
                        Kategori <span class="required">*</span>
                    </label>

                    <select id="category_id" name="category_id" required>
                        <option value="">-- Pilih Kategori --</option>

                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @if($categories->isEmpty())
                        <small class="required">
                            Belum ada kategori. Buat kategori terlebih dahulu.
                        </small>
                    @endif
                </div>

                <div class="field">
                    <label for="unit">
                        Satuan <span class="required">*</span>
                    </label>

                    <input
                        id="unit"
                        type="text"
                        name="unit"
                        value="{{ old('unit', 'pcs') }}"
                        placeholder="Contoh: pcs, box, kg"
                        maxlength="50"
                        required
                    >
                </div>

                <div class="field">
                    <label for="purchase_price">
                        Harga Beli (Rp) <span class="required">*</span>
                    </label>

                    <input
                        id="purchase_price"
                        type="number"
                        name="purchase_price"
                        value="{{ old('purchase_price') }}"
                        min="0"
                        step="0.01"
                        placeholder="Contoh: 50000"
                        required
                    >
                </div>

                <div class="field">
                    <label for="selling_price">
                        Harga Jual (Rp) <span class="required">*</span>
                    </label>

                    <input
                        id="selling_price"
                        type="number"
                        name="selling_price"
                        value="{{ old('selling_price') }}"
                        min="0"
                        step="0.01"
                        placeholder="Contoh: 65000"
                        required
                    >
                </div>

                <div class="field">
                    <label for="stock">
                        Stok Awal <span class="required">*</span>
                    </label>

                    <input
                        id="stock"
                        type="number"
                        name="stock"
                        value="{{ old('stock', 0) }}"
                        min="0"
                        step="1"
                        required
                    >
                </div>

                <div class="field">
                    <label for="minimum_stock">
                        Batas Minimum Stok <span class="required">*</span>
                    </label>

                    <input
                        id="minimum_stock"
                        type="number"
                        name="minimum_stock"
                        value="{{ old('minimum_stock', 5) }}"
                        min="0"
                        step="1"
                        required
                    >
                </div>

                <!-- Upload foto produk -->
                <div class="field full">
                    <label for="image">Foto Produk</label>

                    <input
                        id="image"
                        type="file"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    >

                    <small class="help">
                        Format yang diizinkan: JPG, JPEG, PNG, WEBP.
                        Ukuran maksimal 2 MB. Foto bersifat opsional.
                    </small>

                    <img
                        id="image-preview"
                        class="image-preview"
                        alt="Pratinjau foto produk"
                    >
                </div>

                <div class="field full">
                    <label for="description">Deskripsi Produk</label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Keterangan produk (opsional)"
                    >{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="actions">
                <button class="btn primary" type="submit">
                    Simpan Produk
                </button>

                <a
                    class="btn secondary"
                    href="{{ route('products.index') }}"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');

    let previewUrl = null;

    imageInput.addEventListener('change', function () {
        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }

        imagePreview.removeAttribute('src');
        imagePreview.style.display = 'none';

        const file = this.files && this.files[0];

        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Pilih gambar dengan format JPG, JPEG, PNG, atau WEBP.');
            this.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 2 MB.');
            this.value = '';
            return;
        }

        previewUrl = URL.createObjectURL(file);
        imagePreview.src = previewUrl;
        imagePreview.style.display = 'block';
    });

    window.addEventListener('beforeunload', function () {
        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
        }
    });
</script>
</body>
</html>

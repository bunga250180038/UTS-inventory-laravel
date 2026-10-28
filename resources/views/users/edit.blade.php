<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Inventory</title>

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

        h1 {
            font-size: 27px;
            margin: 0 0 8px;
        }

        h3 {
            margin: 0 0 20px;
            font-size: 17px;
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
            padding: 25px;
            max-width: 800px;
            margin-top: 25px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, .03);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .field { min-width: 0; }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            background: white;
        }

        input:focus, select:focus {
            outline: 2px solid #bfdbfe;
            border-color: #2563eb;
        }

        .required { color: #dc2626; }

        .notice {
            padding: 14px;
            background: #eff6ff;
            color: #1e40af;
            border-radius: 9px;
            margin-bottom: 22px;
            font-size: 13px;
            line-height: 1.7;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.7;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 12px 17px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .btn:hover { background: #1d4ed8; }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-secondary:hover { background: #cbd5e1; }

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

            .form-grid { grid-template-columns: 1fr; }
            h1 { font-size: 23px; }
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

        <form action="{{ route('logout') }}" method="POST" style="margin-top:25px;">
            @csrf
            <button type="submit"
                style="width:100%;padding:12px;border:1px solid #64748b;border-radius:8px;background:transparent;color:white;cursor:pointer;">
                ↪ Keluar dari Aplikasi
            </button>
        </form>
    </aside>

    <main class="main">
        <div>
            <h1>Edit Pengguna</h1>
            <div class="muted">
                Perbarui informasi akun dan hak akses pengguna.
            </div>
        </div>

        @if($errors->any())
            <div class="error" style="margin-top:20px;">
                <strong>Perubahan belum berhasil disimpan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card">
            <h3>Informasi Akun</h3>

            <div class="notice">
                Password tidak wajib diisi jika kamu tidak ingin menggantinya.
                Kosongkan kedua kolom password untuk mempertahankan password lama.
                <br>
                Akun Admin yang sedang digunakan tidak dapat diubah menjadi Staff atau Pembeli.
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field">
                        <label for="name">
                            Nama Lengkap <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            maxlength="255"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="email">
                            Email <span class="required">*</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            maxlength="255"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="password">Password Baru</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Kosongkan jika tidak diganti"
                        >
                    </div>

                    <div class="field">
                        <label for="password_confirmation">
                            Konfirmasi Password Baru
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Ulangi password baru"
                        >
                    </div>

                    <div class="field">
                        <label for="role">
                            Role Pengguna <span class="required">*</span>
                        </label>

                        <select id="role" name="role" required>
                            <option value="admin"
                                {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>

                            <option value="staff"
                                {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>
                                Staff
                            </option>

                            <option value="buyer"
                                {{ old('role', $user->role) === 'buyer' ? 'selected' : '' }}>
                                Pembeli
                            </option>
                        </select>
                    </div>
                </div>

                <div class="actions">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

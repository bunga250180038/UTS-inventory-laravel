<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna | Inventory System</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px 16px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .header {
            background: #172554;
            color: white;
            padding: 24px;
            border-radius: 12px 12px 0 0;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 24px;
        }

        .header p {
            margin: 0;
            color: #cbd5e1;
            font-size: 14px;
        }

        .content {
            background: white;
            padding: 28px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 5px 18px #0f172a12;
        }

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
            font-size: 15px;
        }

        input:focus, select:focus {
            outline: 2px solid #c7d2fe;
            border-color: #4f46e5;
        }

        .help {
            margin-top: 6px;
            color: #64748b;
            font-size: 12px;
        }

        .error-box {
            padding: 14px;
            margin-bottom: 20px;
            border-radius: 8px;
            background: #fee2e2;
            color: #991b1b;
            font-size: 14px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }

        .button {
            display: inline-block;
            border: none;
            border-radius: 8px;
            padding: 12px 18px;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .primary {
            color: white;
            background: #3730a3;
        }

        .secondary {
            color: #334155;
            background: #e2e8f0;
        }

        @media (max-width: 480px) {
            .content { padding: 20px; }
            .actions { flex-direction: column; }
            .button { width: 100%; }
        }
    </style>
</head>

<body>
    <main class="container">
        <header class="header">
            <h1>Tambah Pengguna</h1>
            <p>Daftarkan akun Admin, Staff, atau Pembeli.</p>
        </header>

        <section class="content">
            @if ($errors->any())
                <div class="error-box">
                    <strong>Periksa kembali data berikut:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        maxlength="255"
                        required
                        autocomplete="name"
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        maxlength="255"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="8"
                        required
                        autocomplete="new-password"
                    >
                    <div class="help">Minimal 8 karakter.</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        minlength="8"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="form-group">
                    <label for="role">Role Pengguna</label>
                    <select id="role" name="role" required>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="staff" {{ old('role', 'staff') === 'staff' ? 'selected' : '' }}>
                            Staff
                        </option>

                        <option value="buyer" {{ old('role') === 'buyer' ? 'selected' : '' }}>
                            Pembeli
                        </option>
                    </select>
                    <div class="help">
                        Pembeli dapat login untuk melihat katalog produk.
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="button primary">
                        Simpan Pengguna
                    </button>

                    <a href="{{ route('users.index') }}" class="button secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

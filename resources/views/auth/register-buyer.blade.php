<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembeli | Inventory System</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            color: #1e293b;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
            padding: 34px;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.10);
        }

        .logo {
            width: 58px;
            height: 58px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 18px;
            border-radius: 15px;
            background: #e0e7ff;
            font-size: 28px;
        }

        h1 {
            margin: 0 0 10px;
            text-align: center;
            font-size: 25px;
            color: #172554;
        }

        .description {
            margin: 0 0 26px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .alert {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 8px;
            color: #991b1b;
            background: #fee2e2;
            font-size: 13px;
        }

        .btn-register {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 9px;
            background: #3730a3;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-register:hover {
            background: #312e81;
        }

        .login-link {
            margin-top: 22px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        .login-link a {
            color: #4338ca;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="logo">🛍️</div>

        <h1>Daftar Akun Pembeli</h1>

        <p class="description">
            Buat akun untuk melihat katalog dan informasi produk yang tersedia.
        </p>

        @if ($errors->any())
            <div class="alert">
                <strong>Pendaftaran belum berhasil.</strong>
                <ul style="margin-bottom: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('buyer.register.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                    maxlength="255"
                    autocomplete="name"
                >
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    required
                    maxlength="255"
                    autocomplete="email"
                >
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                    minlength="8"
                    autocomplete="new-password"
                >
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Masukkan ulang kata sandi"
                    required
                    minlength="8"
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="btn-register">
                Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
</body>
</html>

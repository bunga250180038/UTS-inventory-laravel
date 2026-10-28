<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Inventory System</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #102a43, #176b87, #64ccc5);
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 15px 45px #0003;
        }

        .logo {
            width: 65px;
            height: 65px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #176b87;
            color: white;
            border-radius: 16px;
            font-size: 30px;
        }

        h1 {
            text-align: center;
            margin-bottom: 8px;
            color: #102a43;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin: 15px 0 8px;
            font-weight: bold;
            color: #334155;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 15px;
        }

        input:focus {
            outline: 2px solid #64ccc5;
            border-color: #176b87;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 14px;
            border: 0;
            border-radius: 9px;
            background: #176b87;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #102a43;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
            line-height: 1.5;
        }

        .register-link {
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .register-link a {
            display: inline-block;
            margin-top: 5px;
            color: #176b87;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="logo">📦</div>

        <h1>Inventory System</h1>
        <p class="subtitle">Silakan masuk ke akun Anda</p>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                autocomplete="username"
                required
                autofocus
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Masuk</button>
        </form>

        <div class="register-link">
            Belum memiliki akun pembeli?
            <br>
            <a href="{{ route('buyer.register') }}">
                Daftar sebagai Pembeli
            </a>
        </div>

        <div class="footer">
            Inventory Management System &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>

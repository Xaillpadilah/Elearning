<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #6A82FB, #e6e0e1ff);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .login-container {
            background: #fff;
            padding: 2rem;
            width: 100%;
            max-width: 420px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-title {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #555;
            font-size: 1.05rem;
        }

        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-group input:focus {
            outline: none;
            border-color: #6A82FB;
            box-shadow: 0 0 5px rgba(106, 130, 251, 0.5);
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1rem;
            color: #888;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            border: none;
            background-color: #6A82FB;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #5a73db;
        }

        .error-message {
            background: #ffdddd;
            padding: 0.5rem;
            border: 1px solid #ff5e5e;
            color: #cc0000;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }

        .forgot-password a {
            color: #6A82FB;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Form Login Gabungan --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-title">Selamat Datang Kembali,Silakan login ke akun Anda untuk melanjutkan</div>

        <div class="form-group">
            <input type="text" name="email" placeholder="Email / NISN" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword()">🔒</span>
        </div>

        <button type="submit">Login</button>

        <div class="forgot-password">
            <a href="{{ route('password.request') }}">Lupa Password?</a>
        </div>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const toggleBtn = document.querySelector(".toggle-password");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleBtn.textContent = "🔓";
        } else {
            passwordInput.type = "password";
            toggleBtn.textContent = "🔒";
        }
    }
</script>
</body>
</html>

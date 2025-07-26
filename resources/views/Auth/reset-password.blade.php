<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6A82FB, #FC5C7D);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .reset-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .form-group input:focus {
            border-color: #6A82FB;
            outline: none;
            box-shadow: 0 0 5px rgba(106,130,251,0.5);
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #6A82FB;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #5a73db;
        }
        .message {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
        }
        .error { background: #ffdddd; color: #d32f2f; }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>

        @if ($errors->any())
            <div class="message error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <input type="password" name="password" placeholder="Password baru" required autofocus>
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi password" required>
            </div>

            <button type="submit">Ubah Password</button>
        </form>
    </div>
</body>
</html>

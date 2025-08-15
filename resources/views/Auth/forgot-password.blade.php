<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6A82FB, #e6e0e1ff);
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 0.75rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #5a73db;
            outline: none;
            box-shadow: 0 0 5px rgba(106, 130, 251, 0.5);
        }

        .email-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            fill: #333;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #5a73db;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
        }

        .success {
            background-color: #ddffdd;
            color: #2e7d32;
        }

        .error {
            background-color: #ffdddd;
            color: #d32f2f;
        }
    </style>
</head>
<body>
<div class="reset-container">
    <h2>Lupa Password</h2>

    @if (session('status'))
        <div class="message success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="message error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <input type="email" name="email" placeholder="Masukkan email anda" required>
            <svg class="email-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M2 4a2 2 0 012-2h16a2 2 0 012 2v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4zm2 0v.01L12 13 20 4.01V4H4zm16 2.243l-8 8-8-8V20h16V6.243z"/>
            </svg>
        </div>
        <button type="submit">Kirim Link Reset</button>
    </form>
</div>
</body>
</html>

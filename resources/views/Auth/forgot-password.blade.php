<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #657df6ff, #eed7dbff);
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
            box-shadow: 0 0 5px rgba(106, 130, 251, 0.5);
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
        .success { background-color: #ddffdd; color: #2e7d32; }
        .error { background-color: #ffdddd; color: #d32f2f; }
           .form-group {
        margin-bottom: 15px;
        width: 100%;
    }

    .form-group input[type="email"] {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    .form-group input[type="email"]:focus {
        border-color: #007BFF;
        outline: none;
    }

    button[type="submit"] {
        background-color: #007BFF;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
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
            </div>
            <button type="submit">Kirim Link Reset</button>
        </form>
    </div>
</body>
</html>

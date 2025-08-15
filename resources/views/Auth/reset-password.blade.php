<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
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
            box-sizing: border-box;
            font-size: 1rem;
        }

        .form-group input:focus {
            border-color: #6A82FB;
            outline: none;
            box-shadow: 0 0 5px rgba(106,130,251,0.5);
        }

        .lock-icon,
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .lock-icon {
            display: none; /* disembunyikan karena diganti dengan toggle mata */
        }

        .toggle-password {
            fill: #333;
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
            font-size: 1rem;
        }

        button:hover {
            background-color: #5a73db;
        }

        .message {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
        }

        .error {
            background: #ffdddd;
            color: #d32f2f;
        }
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
            <input type="password" id="password" name="password" placeholder="Password baru" required>
            <svg class="toggle-password" onclick="togglePassword('password', this)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 5c-7.633 0-12 7-12 7s4.367 7 12 7 12-7 12-7-4.367-7-12-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z"/>
            </svg>
        </div>

        <div class="form-group">
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
            <svg class="toggle-password" onclick="togglePassword('password_confirmation', this)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 5c-7.633 0-12 7-12 7s4.367 7 12 7 12-7 12-7-4.367-7-12-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z"/>
            </svg>
        </div>

        <button type="submit">Ubah Password</button>
    </form>
</div>

<script>
    function togglePassword(fieldId, icon) {
        const field = document.getElementById(fieldId);
        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
        field.setAttribute('type', type);

        // Optional: ganti ikon jika ingin mata terbuka / tertutup
        if (type === 'text') {
            icon.innerHTML = '<path d="M1 12s4.367 7 11 7 11-7 11-7-4.367-7-11-7-11 7-11 7zm11 5a5 5 0 100-10 5 5 0 000 10z"/>';
        } else {
            icon.innerHTML = '<path d="M12 5c-7.633 0-12 7-12 7s4.367 7 12 7 12-7 12-7-4.367-7-12-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z"/>';
        }
    }
</script>
</body>
</html>

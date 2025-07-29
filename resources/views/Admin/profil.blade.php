<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .button {
            padding: 8px 16px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .button-red {
            background-color: #dc3545;
        }
        .button-red:hover {
            background-color: #b52a37;
        }
        form {
            width: 100%;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-section {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
        }
        .left-form {
            flex: 2;
        }
        .right-profile {
            flex: 1;
            text-align: center;
            border-left: 1px solid #eee;
            padding-left: 30px;
        }
        .right-profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
        }
        .alert {
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
<!-- Header -->
<div class="header">
    <div style="display: flex; align-items: center; gap: 16px;">
        <a href="{{ route('admin.dashboard') }}" class="button" style="background-color: #ccc; color: #000;">← Kembali</a>
        <h2></h2>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="button button-red">Keluar</button>
    </form>
</div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-section">
        <!-- Form Profil -->
        <div class="left-form">
            <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}">
                    @error('name') <p style="color:red;">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}">
                    @error('email') <p style="color:red;">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="foto">Ganti Foto Profil</label>
                    <input type="file" name="foto" accept="image/*">
                    @error('foto') <p style="color:red;">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="button">Simpan Perubahan</button>
            </form>
        </div>

        <!-- Foto Profil -->
        <div class="right-profile">
            <h3>Foto Profil</h3>
            <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/default-profile.png') }}" alt="Foto Profil">
        </div>
    </div>

</div>

</body>
</html>

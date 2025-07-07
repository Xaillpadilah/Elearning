{{-- resources/views/admin/guru/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f5f5;
      padding: 40px;
    }

    .container {
      max-width: 500px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #4a148c;
      margin-bottom: 20px;
    }

    form input {
      width: 100%;
      padding: 12px;
      margin-bottom: 14px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    form button {
      width: 100%;
      background: linear-gradient(to right, #4fc3f7, #0288d1);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
    }

    .back-link {
      display: block;
      margin-top: 15px;
      text-align: center;
      color: #0288d1;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>✏️ Edit Data Guru</h2>

    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
      @csrf
      @method('PUT')

      <input type="text" name="nama" value="{{ $guru->nama }}" placeholder="Nama" required>
      <input type="text" name="nik" value="{{ $guru->nik }}" placeholder="NIK" required>
      <input type="text" name="mengajar" value="{{ $guru->mengajar }}" placeholder="Mengajar" required>
      <input type="email" name="email" value="{{ $guru->email }}" placeholder="Email" required>

      <button type="submit">💾 Simpan Perubahan</button>
    </form>

    <a href="{{ route('admin.guru') }}" class="back-link">← Kembali ke Data Guru</a>
  </div>
</body>
</html>

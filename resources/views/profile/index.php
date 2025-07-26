<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Guru - E-Learning</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #e1f5fe, #ede7f6);
      min-height: 100vh;
      display: flex;
    }

    .sidebar {
      width: 240px;
      background: #fff;
      padding: 20px;
      border-right: 1px solid #ccc;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      overflow-y: auto;
    }

    .sidebar h2 {
      font-size: 20px;
      margin-bottom: 20px;
      color: #4a148c;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      margin-bottom: 12px;
    }

    .sidebar ul li a {
      text-decoration: none;
      color: #333;
      padding: 10px;
      display: block;
      border-radius: 8px;
    }

    .sidebar ul li a:hover,
    .sidebar ul li a.active {
      background: linear-gradient(to right, #d1c4e9, #bbdefb);
      color: #4a148c;
    }

    .main {
      margin-left: 240px;
      padding: 40px;
      flex: 1;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .profile-box {
      background: #fff;
      border-left: 6px solid #4a148c;
      padding: 30px;
      border-radius: 12px;
      max-width: 600px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .profile-box h3 {
      color: #4a148c;
      margin-bottom: 10px;
    }

    .profile-box p {
      font-size: 15px;
      margin: 8px 0;
      color: #333;
    }

    .label {
      color: #666;
      font-size: 14px;
      margin-right: 6px;
    }

    .footer {
      margin-top: 40px;
      text-align: center;
      color: #666;
      font-size: 13px;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Guru Panel</h2>
    <ul>
      <li><a href="{{ route('guru.dashboard') }}">🏠 Dashboard</a></li>
      <li><a href="{{ route('guru.mapel.index') }}">📘 Materi</a></li>
      <li><a href="{{ route('guru.tugas') }}">📝 Tugas</a></li>
      <li><a href="{{ route('guru.nilai') }}">📊 Nilai</a></li>
      <li><a href="{{ route('guru.profil') }}" class="active">👤 Profil</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <h2>👤 Profil Saya</h2>
      <div>🧑 {{ auth()->user()->name }}</div>
    </div>

    <div class="profile-box">
      <h3>Informasi Akun</h3>
      <p><span class="label">Nama:</span> {{ auth()->user()->name }}</p>
      <p><span class="label">Email:</span> {{ auth()->user()->email }}</p>
      <p><span class="label">Role:</span> {{ auth()->user()->role }}</p>
      <p><span class="label">Terdaftar sejak:</span> {{ auth()->user()->created_at->format('d M Y') }}</p>
    </div>

    <div class="footer">
      &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Halaman Profil Guru.
    </div>
  </div>

</body>
</html>

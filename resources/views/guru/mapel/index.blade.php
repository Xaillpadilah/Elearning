<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Materi Guru - E-Learning</title>
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
    .sidebar ul { list-style: none; }
    .sidebar ul li { margin-bottom: 12px; }
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
      padding: 30px;
      flex: 1;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .info-box {
      background: #fff;
      border-left: 5px solid #4a148c;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .info-box h3 {
      color: #4a148c;
      margin-bottom: 6px;
    }
    .search-form {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
    }
    .search-form input {
      flex: 1;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    .search-form button {
      padding: 10px 20px;
      background: linear-gradient(to right, #64b5f6, #2196f3);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    table th, table td {
      padding: 12px 16px;
      text-align: left;
      font-size: 14px;
    }
    table thead {
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
    }
    table th {
      color: #0d47a1;
    }
    table tbody tr:nth-child(even) {
      background: #f5f5f5;
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
      <li><a href="{{ route('guru.mapel.index') }}" class="active">📘 Materi</a></li>
      <li><a href="{{ route('guru.tugas') }}">📝 Tugas</a></li>
      <li><a href="{{ route('guru.nilai') }}">📊 Nilai</a></li>
      <li><a href="{{ route('guru.profil') }}">👤 Profil</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <h2>📘 Materi Saya</h2>
      <div>👨‍🏫 {{ auth()->user()->name }}</div>
    </div>

    <div class="info-box">
      <h3>Daftar Materi</h3>
      <p>Berikut adalah materi-materi yang telah Anda unggah untuk siswa.</p>
    </div>

    <form class="search-form" method="GET" action="{{ route('guru.mapel.index') }}">
      <input type="text" name="search" placeholder="Cari materi..." value="{{ old('search', $search ?? '') }}">
      <button type="submit">🔍 Cari</button>
    </form>

    @if (session('success'))
      <div style="padding:10px; background:#dff0d8; border:1px solid #4cae4c; border-radius:8px; margin-bottom:20px;">
        {{ session('success') }}
      </div>
    @endif

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Judul Materi</th>
          <th>Mata Pelajaran</th>
          <th>Kelas</th>
          <th>Tanggal Upload</th>
        </tr>
      </thead>
      <tbody>
        @forelse($materi as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $item->judul }}</td>
          <td>{{ $item->mapel }}</td>
          <td>{{ $item->kelas }}</td>
          <td>{{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d M Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="text-align:center; padding:20px;">Belum ada materi ditemukan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <div class="footer">
      &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Halaman Guru.
    </div>
  </div>

</body>
</html>

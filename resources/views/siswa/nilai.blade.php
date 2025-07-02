<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nilai Akhir - Dashboard Siswa</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e3f2fd, #f3e5f5, #e1f5fe);
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #ffffff, #e3f2fd);
      height: 100vh;
      padding: 20px;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
      position: fixed;
      overflow-y: auto;
      transition: transform 0.3s ease;
    }

    .sidebar.hidden { transform: translateX(-100%); }

    .sidebar h2 {
      color: #4a148c;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 35px;
    }

    .sidebar ul { list-style: none; padding: 0; }
    .sidebar ul li { margin: 14px 0; }

    .sidebar ul li a {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      color: #222;
      text-decoration: none;
      font-weight: 500;
      border-radius: 12px;
      transition: background 0.3s, color 0.3s;
    }

    .sidebar ul li a:hover,
    .sidebar ul li a.active {
      background: linear-gradient(to right, #d1c4e9, #bbdefb);
      color: #6a1b9a;
    }

    .sub-mapel {
      display: none;
      margin-top: 10px;
      margin-left: 12px;
      border-left: 2px solid #e0e0e0;
      padding-left: 10px;
    }

    .sub-mapel li a {
      font-size: 14px;
      padding: 6px 10px;
      display: block;
      border-radius: 8px;
      color: #444;
    }

    .sub-mapel li a:hover,
    .sub-mapel li a.active {
      background: linear-gradient(to right, #d1c4e9, #bbdefb);
      color: #6a1b9a;
    }

    .main {
      margin-left: 270px;
      flex: 1;
      padding: 30px 40px 80px;
      background: linear-gradient(to bottom right, #f3f4f6, #e0f7fa);
      transition: margin-left 0.3s ease;
    }

    .main.fullscreen { margin-left: 0; }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .fullscreen-btn {
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
      border: none;
      color: #0d47a1;
      padding: 8px 16px;
      border-radius: 10px;
      font-weight: 500;
      font-size: 14px;
      cursor: pointer;
    }

    .user {
      font-size: 14px;
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
      color: #0d47a1;
      padding: 6px 12px;
      border-radius: 8px;
      font-weight: 500;
    }

    .info-frame {
      background: #ffffff;
      border: 2px solid #c5cae9;
      border-radius: 12px;
      padding: 20px 25px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .info-frame h4 {
      margin-top: 0;
      font-size: 18px;
      color: #4a148c;
      margin-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    table thead {
      background: #e1f5fe;
      color: #006064;
    }

    table th, table td {
      padding: 14px 16px;
      text-align: left;
      font-size: 14px;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    footer {
      position: fixed;
      bottom: 0;
      left: 270px;
      width: calc(100% - 270px);
      background: #eceff1;
      color: #333;
      padding: 12px 30px;
      text-align: center;
      font-size: 14px;
      transition: left 0.3s ease, width 0.3s ease;
    }

    .fullscreen footer {
      left: 0;
      width: 100%;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>E-LEARNING</h2>
  <ul>
    <li><a href="{{ route('siswa.dashboard') }}">🏠 Beranda</a></li>
    <li>
      <a href="javascript:void(0)" onclick="toggleMapel()">📚 Mata Pelajaran</a>
      <ul id="sub-mapel" class="sub-mapel">
        @forelse($mataPelajaran ?? [] as $mapel)
          <li><a href="{{ route('siswa.matapelajaran.show', $mapel['id']) }}">📘 {{ $mapel['nama'] }}</a></li>
        @empty
          <li><em>Tidak ada pelajaran</em></li>
        @endforelse
      </ul>
    </li>
    <li><a href="{{ route('siswa.absensi') }}">📸 Absensi</a></li>
    <li><a href="{{ route('siswa.nilai') }}" class="active">📊 Nilai Akhir</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">👤 {{ $user->name ?? 'Nama Siswa' }}</div>
  </div>

  <div class="info-frame">
    <h4>📊 Daftar Nilai Akhir</h4>
    <p>Berikut adalah nilai akhir dari semua mata pelajaran yang telah Anda ikuti.</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Mata Pelajaran</th>
        <th>Nilai</th>
        <th>Predikat</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($nilaiAkhir as $index => $nilai)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $nilai['mapel'] }}</td>
          <td>{{ $nilai['nilai'] }}</td>
          <td>{{ $nilai['predikat'] }}</td>
          <td>{{ $nilai['keterangan'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<footer id="footer">
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.
</footer>

<script>
  function toggleMapel() {
    const subMapel = document.getElementById('sub-mapel');
    subMapel.style.display = subMapel.style.display === 'block' ? 'none' : 'block';
  }

  function toggleFullscreenDashboard() {
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('main-content').classList.toggle('fullscreen');
    document.getElementById('footer').classList.toggle('fullscreen');
  }
</script>
</body>
</html>

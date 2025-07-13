<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Guru</title>
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

    .sidebar ul li a, .dropdown-toggle {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      color: #222;
      text-decoration: none;
      font-weight: 500;
      border-radius: 12px;
      transition: background 0.3s, color 0.3s;
      background: transparent;
      cursor: pointer;
    }

    .sidebar ul li a:hover,
    .sidebar ul li a.active,
    .dropdown-toggle:hover {
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
      color: #444;
      display: block;
      border-radius: 8px;
      transition: background 0.3s;
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

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 25px;
    }

    .card {
      background: linear-gradient(to bottom, #ffffff, #f8f9fa);
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      padding: 25px;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease;
    }

    .card:hover { transform: translateY(-5px); }

    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .card-title {
      font-weight: 600;
      font-size: 18px;
      color: #222;
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
    }

    .kelas {
      background: linear-gradient(to right, #b2ebf2, #c5cae9);
      color: #004d40;
      font-size: 12px;
      padding: 4px 10px;
      border-radius: 50px;
    }

    .card a button {
      margin-top: 16px;
      background: linear-gradient(to right, #66bb6a, #43a047);
      color: white;
      border: none;
      padding: 10px 18px;
      font-size: 14px;
      font-weight: 500;
      border-radius: 10px;
      cursor: pointer;
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
    <li><a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">🏠 Beranda</a></li>
    <li><a href="{{ route('guru.jadwal') }}" class="{{ request()->routeIs('guru.jadwal') ? 'active' : '' }}">🗓️ Jadwal Mengajar</a></li>
    <li><a href="{{ route('guru.siswa') }}" class="{{ request()->routeIs('guru.siswa') ? 'active' : '' }}">👥 Daftar Siswa</a></li>
    <li><a href="{{ route('guru.nilai') }}" class="{{ request()->routeIs('guru.nilai') ? 'active' : '' }}">📊 Penilaian</a></li>
    
    <!-- Dropdown Menu Materi -->
    <li>
      <div class="dropdown-toggle" onclick="toggleDropdown()">📚 Materi <span style="margin-left:auto;">▾</span></div>
      <ul class="sub-mapel" id="dropdownMenu">
        <li><a href="{{ route('guru.mapel.index') }}" class="{{ request()->routeIs('guru.mapel.index') ? 'active' : '' }}">📘 Daftar Mapel</a></li>
        <li><a href="{{ route('guru.mapel.index') }}" class="{{ request()->routeIs('guru.materi') ? 'active' : '' }}">📄 Materi Pembelajaran</a></li>
      </ul>
    </li>

    <li><a href="{{ route('guru.tugas') }}" class="{{ request()->routeIs('guru.tugas') ? 'active' : '' }}">📝 Tugas</a></li>
    <li><a href="{{ route('guru.pengumuman') }}" class="{{ request()->routeIs('guru.pengumuman') ? 'active' : '' }}">📢 Pengumuman</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">👨‍🏫 {{ $user->name ?? 'Nama Guru' }}</div>
  </div>

  <div class="info-frame">
    <h4>📢 Informasi Umum</h4>
    <p>Selamat datang di dashboard guru. Silakan kelola jadwal, nilai, dan materi Anda.</p>
  </div>

  <div class="cards">
    <!-- Contoh card -->
    <div class="card">
      <img src="{{ asset('assets/image/jadwal.png') }}" alt="Jadwal">
      <div class="card-title">Jadwal Hari Ini <span class="kelas">{{ $jadwalHariIni ?? 0 }} Kelas</span></div>
      <p>Lihat kelas yang Anda ajar hari ini.</p>
      <a href="{{ route('guru.jadwal') }}"><button>Lihat Jadwal</button></a>
    </div>
    <!-- Tambahkan card lain sesuai kebutuhan -->
  </div>
</div>

<!-- Footer -->
<footer id="footer">
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Dashboard Guru.
</footer>

<script>
  function toggleFullscreenDashboard() {
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('main-content').classList.toggle('fullscreen');
    document.getElementById('footer').classList.toggle('fullscreen');
  }

  function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
  }

  // Buka dropdown jika route aktif
  window.onload = function () {
    const currentRoute = "{{ Route::currentRouteName() }}";
    if (['guru.mapel.index', 'guru.materi'].includes(currentRoute)) {
      document.getElementById('dropdownMenu').style.display = 'block';
    }
  };
</script>

</body>
</html>

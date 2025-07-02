<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Orang Tua</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    /* Semua style tetap dari versi admin/guru */
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f3e5f5, #e1f5fe, #e8f5e9);
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
      color: #388e3c;
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
      background: linear-gradient(to right, #c8e6c9, #b3e5fc);
      color: #2e7d32;
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

    .header .fullscreen-btn {
      background: linear-gradient(to right, #c8e6c9, #b2ebf2);
      border: none;
      color: #1b5e20;
      padding: 8px 16px;
      border-radius: 10px;
      font-weight: 500;
      cursor: pointer;
      font-size: 14px;
    }

    .user {
      font-size: 14px;
      background: linear-gradient(to right, #c5e1a5, #b2ebf2);
      color: #1b5e20;
      padding: 6px 12px;
      border-radius: 8px;
      font-weight: 500;
    }

    .info-frame {
      background: #ffffff;
      border: 2px solid #a5d6a7;
      border-radius: 12px;
      padding: 20px 25px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .info-frame h4 {
      margin-top: 0;
      font-size: 18px;
      color: #2e7d32;
      margin-bottom: 10px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
    }

    .card {
      background: linear-gradient(to bottom, #ffffff, #f1f8e9);
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      padding: 25px;
      transition: transform 0.3s ease;
    }

    .card:hover { transform: translateY(-5px); }

    .card-title {
      font-weight: 600;
      font-size: 18px;
      color: #2e7d32;
      margin-bottom: 12px;
    }

    .card p {
      font-size: 14px;
      color: #555;
      margin: 0 0 12px;
    }

    .card a button {
      background: linear-gradient(to right, #81c784, #4caf50);
      color: white;
      border: none;
      padding: 10px 16px;
      font-size: 14px;
      font-weight: 500;
      border-radius: 8px;
      cursor: pointer;
    }

    footer {
      position: fixed;
      bottom: 0;
      left: 270px;
      width: calc(100% - 270px);
      background: #f1f8e9;
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
  <h2>Dashboard Orang Tua</h2>
  <ul>
    <li><a href="{{ route('orangtua.dashboard') }}" class="{{ request()->routeIs('orangtua.dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('orangtua.nilai') }}" class="{{ request()->routeIs('orangtua.nilai') ? 'active' : '' }}">📊 Nilai Anak</a></li>
    <li><a href="{{ route('orangtua.absensi') }}" class="{{ request()->routeIs('orangtua.absensi') ? 'active' : '' }}">🗓️ Kehadiran</a></li>
    <li><a href="{{ route('orangtua.tugas') }}" class="{{ request()->routeIs('orangtua.tugas') ? 'active' : '' }}">📚 Tugas Anak</a></li>
    <li><a href="{{ route('orangtua.jadwal') }}" class="{{ request()->routeIs('orangtua.jadwal') ? 'active' : '' }}">🕒 Jadwal Pelajaran</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">👨‍👩‍👧 {{ $user->name ?? 'Orang Tua' }}</div>
  </div>

  <div class="info-frame">
    <h4>👋 Selamat Datang</h4>
    <p>Anda dapat melihat perkembangan akademik dan aktivitas anak Anda di sini.</p>
  </div>

  <div class="cards">
    <div class="card">
      <div class="card-title">📊 Nilai Anak</div>
      <p>Periksa nilai hasil ujian dan tugas anak secara berkala.</p>
      <a href="{{ route('orangtua.nilai') }}"><button>Lihat Nilai</button></a>
    </div>

    <div class="card">
      <div class="card-title">🗓️ Kehadiran</div>
      <p>Monitor kehadiran anak Anda setiap hari.</p>
      <a href="{{ route('orangtua.absensi') }}"><button>Lihat Absensi</button></a>
    </div>

    <div class="card">
      <div class="card-title">📚 Tugas Anak</div>
      <p>Lihat tugas yang sudah dan belum dikerjakan oleh anak.</p>
      <a href="{{ route('orangtua.tugas') }}"><button>Lihat Tugas</button></a>
    </div>

    <div class="card">
      <div class="card-title">🕒 Jadwal Pelajaran</div>
      <p>Lihat jadwal pelajaran mingguan anak Anda.</p>
      <a href="{{ route('orangtua.jadwal') }}"><button>Lihat Jadwal</button></a>
    </div>
  </div>
</div>

<!-- Footer -->
<footer id="footer">
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Dashboard Orang Tua.
</footer>

<script>
  function toggleFullscreenDashboard() {
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('main-content').classList.toggle('fullscreen');
    document.getElementById('footer').classList.toggle('fullscreen');
  }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/adminguru.css'])

  <style>
    /* ========== RESET & DASAR ========== */
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e3f2fd, #f3e5f5, #e1f5fe);
      min-height: 100vh;
    }

    /* ========== SIDEBAR ========== */
    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #ffffff, #e3f2fd);
      height: 100vh;
      padding: 20px;
      position: fixed;
      overflow-y: auto;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
      z-index: 999;
      transition: transform 0.3s ease;
    }

    .sidebar.hidden { transform: translateX(-100%); }

    .sidebar h2 {
      font-size: 24px;
      font-weight: 700;
      color: #4a148c;
      margin-bottom: 35px;
    }

    .sidebar ul { list-style: none; padding: 0; }

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

    .submenu {
      list-style: none;
      padding-left: 20px;
      margin-top: 5px;
      display: none;
    }

    .submenu.show { display: block; }

    .submenu li a {
      font-size: 14px;
      display: block;
      padding: 8px 12px;
      border-radius: 8px;
      color: #333;
      text-decoration: none;
    }

    .submenu li a:hover {
      background: #f0f0f0;
      color: #4a148c;
    }

    /* ========== MAIN ========== */
    .main {
      margin-left: 270px;
      padding: 30px 40px 80px;
      transition: margin-left 0.3s ease;
    }

    .main.fullwidth { margin-left: 0 !important; }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .fullscreen-btn {
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
      border: none;
      padding: 8px 16px;
      border-radius: 10px;
      font-weight: 500;
      font-size: 16px;
      cursor: pointer;
      color: #0d47a1;
    }

    .user {
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
      padding: 6px 12px;
      border-radius: 8px;
      color: #0d47a1;
      font-size: 14px;
      font-weight: 500;
    }

    .info-frame {
      background: #fff;
      border: 2px solid #c5cae9;
      border-radius: 12px;
      padding: 20px 25px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* ========== CARDS ========== */
    .cards .row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
      margin-bottom: 25px;
    }

    .cards .row-two {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 25px;
    }

    .card {
      color: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      position: relative;
      transition: transform 0.3s ease;
    }

    .card:hover { transform: translateY(-6px); }

    .card-title {
      font-weight: 600;
      font-size: 18px;
      margin-bottom: 10px;
    }

    .card::after {
      content: attr(data-icon);
      position: absolute;
      bottom: 10px;
      right: 15px;
      font-size: 60px;
      opacity: 0.1;
    }

    .card-purple { background: linear-gradient(135deg, #8e24aa, #d1c4e9); }
    .card-blue   { background: linear-gradient(135deg, #1e88e5, #90caf9); }
    .card-green  { background: linear-gradient(135deg, #43a047, #a5d6a7); }
    .card-orange { background: linear-gradient(135deg, #fb8c00, #ffe0b2); }
    .card-red    { background: linear-gradient(135deg, #e53935, #ef9a9a); }

    /* ========== FOOTER ========== */
    footer {
      position: fixed;
      bottom: 0;
      left: 270px;
      width: calc(100% - 270px);
      background: #eceff1;
      padding: 12px 30px;
      font-size: 14px;
      text-align: center;
      color: #333;
      transition: left 0.3s ease, width 0.3s ease;
    }

    footer.fullwidth {
      left: 0 !important;
      width: 100% !important;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 1024px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .main { margin-left: 0; }
      footer { left: 0; width: 100%; }
    }

    @media (max-width: 768px) {
      .cards .row, .cards .row-two {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

<!-- SIDEBAR -->
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>Dashboard Admin</h2>
  <ul>
    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('admin.guru') }}" class="{{ request()->routeIs('admin.guru') ? 'active' : '' }}">Data Guru</a></li>
    <li><a href="{{ route('admin.siswa') }}" class="{{ request()->routeIs('admin.siswa') ? 'active' : '' }}">Data Siswa</a></li>
    <li><a href="{{ route('admin.kelas') }}" class="{{ request()->routeIs('admin.kelas') ? 'active' : '' }}">Data Kelas Jadwal</a></li>
    <li><a href="{{ route('materi.index') }}" class="{{ request()->routeIs('materi.index') ? 'active' : '' }}">Materi Dan Konten</a></li>
    <li><a href="{{ route('admin.pengumuman.index') }}" class="{{ request()->routeIs('admin.pengumuman.index') ? 'active' : '' }}">Pengumuman</a></li>
  </ul>
</div>


<!-- MAIN -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleSidebar()" id="menuToggle">☰</button>
    <div class="user">🛡️ {{ $user->name ?? 'Admin Sistem' }}</div>
  </div>

  <div class="info-frame">
    <h4>🔧 Informasi Sistem</h4>
    <p>Selamat datang di dashboard admin. Anda dapat mengelola data guru, siswa, kelas, dan pengaturan sistem lainnya.</p>
  </div>

  <!-- Kartu Statistik -->
  <div class="cards">
    <div class="row">
      <div class="card card-purple" data-icon="👨‍🏫"><div class="card-title">Jumlah Guru</div><p>{{ $jumlahGuru }} Guru terdaftar.</p></div>
      <div class="card card-blue" data-icon="👥"><div class="card-title">Jumlah Siswa</div><p>{{ $jumlahSiswa }} Siswa aktif.</p></div>
      <div class="card card-green" data-icon="🏫"><div class="card-title">Jumlah Kelas</div><p>{{ $jumlahKelas }} Kelas tersedia.</p></div>
    </div>
    <div class="row row-two">
     
    </div>
  </div>

  <!-- Grafik -->
  <div class="info-frame">
    <h4>📊 Statistik Visual</h4>
    <canvas id="dashboardChart" height="120"></canvas>
  </div>
</div>

<!-- FOOTER -->
<footer id="footer">&copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Dashboard Admin.</footer>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('main-content').classList.toggle('fullwidth');
    document.getElementById('footer').classList.toggle('fullwidth');
  }

  function toggleDropdown(id) {
    document.getElementById(id).classList.toggle('show');
  }

  document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('menuToggle');
    if (!sidebar.contains(event.target) && !toggle.contains(event.target) && sidebar.classList.contains('show')) {
      sidebar.classList.remove('show');
    }
  });

  const ctx = document.getElementById('dashboardChart').getContext('2d');
  const dashboardChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: @json($dataChart['labels']),
      datasets: [{
        label: 'Jumlah Data',
        data: @json($dataChart['jumlah']),
        backgroundColor: ['#7986cb', '#4dd0e1', '#aed581', '#ffcc80', '#e57373'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } }
      }
    }
  });
</script>
</body>
</html>

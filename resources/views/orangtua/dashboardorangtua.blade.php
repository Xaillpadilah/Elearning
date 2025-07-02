<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Orang Tua</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    /* Styles sama seperti dashboard siswa */
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
      background: transparent;
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
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
      border: none;
      color: #0d47a1;
      padding: 8px 16px;
      border-radius: 10px;
      font-weight: 500;
      cursor: pointer;
      font-size: 14px;
      transition: background 0.3s ease;
    }

    .header .fullscreen-btn:hover {
      background: linear-gradient(to right, #9fa8da, #80deea);
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

    .info-frame p {
      margin: 0;
      font-size: 14px;
      color: #555;
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
      align-items: center;
      justify-content: space-between;
    }

    .kelas {
      background: linear-gradient(to right, #b2ebf2, #c5cae9);
      color: #004d40;
      font-size: 12px;
      padding: 4px 10px;
      border-radius: 50px;
      font-weight: 500;
    }

    .card p {
      font-size: 14px;
      color: #555;
      line-height: 1.5;
      flex: 1;
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
      align-self: flex-start;
      transition: background 0.3s ease;
    }

    .card a button:hover {
      background: linear-gradient(to right, #388e3c, #2e7d32);
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
  <h2>ORANG TUA</h2>
  <ul>
    <li><a href="{{ route('orangtua.dashboard') }}" class="{{ request()->routeIs('orangtua.dashboard') ? 'active' : '' }}">🏠 Beranda</a></li>
    <li><a href="{{ route('orangtua.anak') }}" class="{{ request()->routeIs('orangtua.anak') ? 'active' : '' }}">👨‍👩‍👧 Anak Saya</a></li>
    <li><a href="{{ route('orangtua.nilai') }}" class="{{ request()->routeIs('orangtua.nilai') ? 'active' : '' }}">📊 Nilai Anak</a></li>
    <li><a href="{{ route('orangtua.absensi') }}" class="{{ request()->routeIs('orangtua.absensi') ? 'active' : '' }}">📸 Absensi</a></li>
    <li><a href="{{ route('orangtua.catatan') }}" class="{{ request()->routeIs('orangtua.catatan') ? 'active' : '' }}">📝 Catatan Guru</a></li>
  </ul>
</div>

<!-- Konten Utama -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">🧑‍💼 {{ $user->name ?? 'Nama Orang Tua' }}</div>
  </div>

  <div class="info-frame">
    <h4>📢 Informasi Umum</h4>
    <p>Selamat datang di dashboard orang tua. Pantau aktivitas dan perkembangan anak Anda setiap hari.</p>
  </div>

  <div class="cards">
    <div class="card">
      <img src="{{ asset('assets/image/hariini.png') }}" alt="Jadwal Hari Ini">
      <div class="card-title">Jadwal Hari Ini <span class="kelas">{{ $jadwalHariIni }} KELAS</span></div>
      <p>Lihat mata pelajaran yang sedang diikuti anak Anda hari ini.</p>
      <a href="{{ route('orangtua.jadwal.hariini') }}"><button>LIHAT JADWAL</button></a>
    </div>

    <div class="card">
      <img src="{{ asset('assets/image/jadwalini.png') }}" alt="Tugas Hari Ini">
      <div class="card-title">Tugas Hari Ini <span class="kelas">{{ $tugasHariIni }} TUGAS</span></div>
      <p>Periksa tugas yang perlu dikerjakan anak Anda hari ini.</p>
      <a href="{{ route('orangtua.tugas.hariini') }}"><button>LIHAT TUGAS</button></a>
    </div>

    <div class="card">
      <img src="{{ asset('assets/image/selanjutnya.png') }}" alt="Pelajaran Selanjutnya">
      <div class="card-title">Pelajaran Selanjutnya <span class="kelas">{{ $pelajaranSelanjutnya['jam'] }}</span></div>
      <p>Pelajaran berikutnya adalah {{ $pelajaranSelanjutnya['mapel'] }}.</p>
      <a href="{{ route('orangtua.pelajaran.selanjutnya') }}"><button>LIHAT DETAIL</button></a>
    </div>

    <div class="card">
      <img src="{{ asset('assets/image/jadwal mingguan.png') }}" alt="Nilai Terbaru">
      <div class="card-title">Nilai Terbaru <span class="kelas">{{ $nilaiTerbaru['mapel'] }}</span></div>
      <p>Nilai terbaru anak Anda adalah <strong>{{ $nilaiTerbaru['nilai'] }}</strong>.</p>
      <a href="{{ route('orangtua.nilai.terbaru') }}"><button>LIHAT NILAI</button></a>
    </div>

    <div class="card">
      <img src="{{ asset('assets/image/nilai.png') }}" alt="Jadwal Mingguan">
      <div class="card-title">Jadwal Minggu Ini <span class="kelas">{{ $jadwalMingguan }} KELAS</span></div>
      <p>Ringkasan kelas anak Anda untuk minggu ini.</p>
      <a href="{{ route('orangtua.jadwal.mingguan') }}"><button>LIHAT RINCIAN</button></a>
    </div>

    <div class="card">
      <img src="{{ asset('assets/image/tugas terbaru.png') }}" alt="Tugas Terbaru">
      <div class="card-title">Tugas Terbaru <span class="kelas">{{ $tugasTerbaru['mapel'] }}</span></div>
      <p>{{ $tugasTerbaru['judul'] }}</p>
      <a href="{{ route('orangtua.tugas.terbaru') }}"><button>LIHAT DETAIL</button></a>
    </div>
  </div>
</div>

<!-- Footer -->
<footer id="footer">
  &copy; {{ date('Y') }} Pantauan Orang Tua SMP 5 CIDAUN.
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

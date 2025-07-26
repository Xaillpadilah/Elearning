<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Mata Pelajaran</title>
  @vite(['resources/css/app.css'])
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  @vite(['resources/css/siswa.css'])

  <style>
    .card-link {
      text-decoration: none;
      color: inherit;
    }
    .card-item {
      background: #ffffff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      text-align: center;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }
    .card-item .icon {
      font-size: 40px;
      margin-bottom: 15px;
      color: #4a148c;
    }
    .card-item h3 {
      margin-bottom: 10px;
      color: #4a148c;
    }

    /* Sembunyikan sidebar */
    .hidden {
      display: none !important;
    }

    /* Perluas main content saat sidebar disembunyikan */
    .fullscreen {
      width: 100% !important;
      margin-left: 0 !important;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>E-LEARNING</h2>
  <ul>
    <li><a href="{{ route('siswa.siswadashboard') }}">🏠 Beranda</a></li>
    <li>
      <a href="javascript:void(0)" onclick="toggleMapel()">📚 Mata Pelajaran</a>
      <ul id="sub-mapel" class="sub-mapel" style="{{ request()->routeIs('siswa.mapel.*') ? 'display:block' : 'display:none' }}">
        @foreach($mapels as $mapel)
          <li>
            <a href="{{ route('siswa.mapel.index', $mapel->id) }}"
               class="{{ (request()->route('id') == $mapel->id) ? 'active' : '' }}">
              {{ $mapel->kode_mapel }} - {{ $mapel->nama_mapel }}
            </a>
          </li>
        @endforeach
      </ul>
    </li>
    <li><a href="{{ route('siswa.absensi.index') }}"> Absensi</a></li>
    <li><a href="{{ route('siswa.nilai.index') }}"> Nilai</a></li>
  </ul>
</div>

<!-- Konten Utama -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
     <div class="user">👤 {{ Auth::user()->name ?? 'Nama Siswa' }}</div>
  </div>

  <div class="info-frame">
    <h4>📢 Informasi Umum</h4>
    <p>Selamat datang di platform E-Learning! Silakan cek jadwal dan tugas Anda secara berkala.</p>
  </div>

  <div class="card">
    <h2>📂 Akses Pembelajaran</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 20px;">

      <!-- Card Materi -->
      <a href="{{ route('siswa.mapel.index', ['id' => $mapel->id]) }}" class="card-link">
        <div class="card-item">
          <div class="icon">📘</div>
          <h3>Materi</h3>
          <p>Lihat semua materi pembelajaran Anda.</p>
        </div>
      </a>

      <!-- Card Tugas -->
      <a href="{{ route('siswa.mapel.index', ['id' => $mapel->id]) }}" class="card-link">
        <div class="card-item">
          <div class="icon">📝</div>
          <h3>Tugas</h3>
          <p>Kerjakan tugas yang diberikan guru.</p>
        </div>
      </a>

      <!-- Card Ujian -->
      <a href="{{ route('siswa.mapel.index', ['id' => $mapel->id]) }}" class="card-link">
        <div class="card-item">
          <div class="icon">🧪</div>
          <h3>Ujian</h3>
          <p>Ikuti ujian sesuai jadwal.</p>
        </div>
      </a>

      <!-- Card Video -->
      <a href="{{ route('siswa.mapel.index', ['id' => $mapel->id]) }}" class="card-link">
        <div class="card-item">
          <div class="icon">🎥</div>
          <h3>Video</h3>
          <p>Tonton pembelajaran melalui video.</p>
        </div>
      </a>

    </div>
  </div>
</div>

<!-- Footer -->
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

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
    .guru-info {
  background: #f0f4ff;
  border: 1px solid #d0dfff;
  padding: 15px;
  border-radius: 12px;
  margin: 20px 0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.guru-info p {
  margin: 4px 0;
  color: #444;
}
.guru-info p:first-child,
.guru-info p:nth-child(3) {
  font-weight: bold;
  color: #222;
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
               {{ $mapel->nama_mapel }}
            </a>
          </li>
        @endforeach
      </ul>
    </li>
    <li><a href="{{ route('siswa.absensi.index') }}"> 📋Absensi</a></li>
    <li><a href="{{ route('siswa.nilai.index') }}"> 📊Nilai</a></li>
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
 <div class="guru-info">
  <p>👨‍🏫 Guru: {{ $mapel->guru->nama ?? '-' }}</p>
  <p>📧 Email: {{ $mapel->guru->email ?? '-' }}</p>
</div>
  <div class="card">
    <h2>📂 Akses Pembelajaran</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 20px;">

      <!-- Card Materi -->
      
<a href="javascript:void(0)" onclick="openPopup('{{ route('siswa.materi.index', ['id' => $mapel->id]) }}')" class="card-link">
    <div class="card-item">
        <div class="icon">📘</div>
        <h3>Materi</h3>
       <p>Lihat semua materi pembelajaran Anda.</p>
    </div>
</a>
<!-- Card Tugas -->
<a href="javascript:void(0)" onclick="openPopup('{{ route('siswa.tugas.index', ['id' => $mapel->id]) }}')" class="card-link">
    <div class="card-item">
        <div class="icon">📝</div>
        <h3>Tugas/kuis</h3>
        <p>Kerjakan tugas yang diberikan guru.</p>
    </div>
</a>

<a href="javascript:void(0)" onclick="openPopup('{{ route('siswa.ujian.index', ['id' => $mapel->id]) }}')" class="card-link">
    <div class="card-item">
        <div class="icon">🧪</div>
        <h3>Ujian</h3>
       <p>Ikuti ujian sesuai jadwal.</p>
    </div>
</a>
      <!-- Card Ujian -->
   
  </div>
</div>
<div id="popupModal" onclick="closePopup()" style="
    visibility: hidden;
    opacity: 0;
    transition: all 0.3s ease;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
">
    <div onclick="event.stopPropagation()" style="
        position: relative;
        width: 100%;
        max-width: 1000px;
        background: white;
        padding: 30px 20px;
        border-radius: 12px;
        overflow-y: auto;
        max-height: 90vh;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    ">
        <div id="popupContent"></div>
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
<script>
    function openPopup(contentUrl) {
        fetch(contentUrl)
            .then(response => response.text())
            .then(html => {
                if (html.trim()) {
                    document.getElementById('popupContent').innerHTML = html;
                    document.getElementById('popupModal').style.display = 'flex';
                }
            })
            .catch(error => {
                console.error('Gagal memuat konten popup:', error);
            });
    }

    function closePopup() {
        document.getElementById('popupModal').style.display = 'none';
        document.getElementById('popupContent').innerHTML = ''; // Kosongkan konten saat ditutup
    }
    function openPopup(contentUrl) {
    fetch(contentUrl)
        .then(response => response.text())
        .then(html => {
            if (html.trim()) {
                const modal = document.getElementById('popupModal');
                document.getElementById('popupContent').innerHTML = html;
                modal.style.visibility = 'visible';
                modal.style.opacity = '1';
            }
        });
}

function closePopup() {
    const modal = document.getElementById('popupModal');
    modal.style.opacity = '0';
    modal.style.visibility = 'hidden';
    document.getElementById('popupContent').innerHTML = '';
}
</script>
</body>
</html>

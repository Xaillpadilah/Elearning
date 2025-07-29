<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  @vite(['resources/css/AdminGuru.css'])
  <style>
   
   
    .card-container {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 30px;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 300px;
      padding: 30px;
      text-align: center;
      transition: transform 0.2s;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card h3 {
      margin-bottom: 15px;
      color: #2c3e50;
    }
    .card p {
      color: #555;
      margin-bottom: 20px;
    }
    .card a {
      display: inline-block;
      padding: 10px 20px;
      background: #3498db;
      color: #fff;
      border-radius: 6px;
      text-decoration: none;
    }
    .card a:hover {
      background: #2980b9;
    }
    .info-frame {
  background: #f9f9f9;
  padding: 15px 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.08);
  font-family: 'Poppins', sans-serif;
  max-width: 1000px;
  margin: 0 auto;
}

.info-frame h4 {
  margin: 0 0 8px;
}

.info-frame p {
  margin: 0 0 10px;
}

.info-frame ul {
  margin: 0;
  padding-left: 18px;
  line-height: 1.4;
}

.info-frame ul li {
  margin-bottom: 6px;
}
.section {
  margin-top: 30px;
  margin-bottom: 30px;
}
.popup-modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.5);
}

.popup-content {
  background: #fff;
  border-radius: 12px;
  max-width: 90%;
  height: 90%;
  margin: 50px auto;
  padding: 20px;
  position: relative;
}

.popup-content iframe {
  width: 100%;
  height: 100%;
  border: none;
  border-radius: 10px;
}

.close-btn {
  position: absolute;
  right: 15px;
  top: 10px;
  font-size: 24px;
  cursor: pointer;
}


  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>Dashboard Guru</h2>
  <ul>
    <li><a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('materi.index') }}" class="{{ request()->routeIs('materi.index') ? 'active' : '' }}">📚 Materi Dan Konten</a></li>
    <li><a href="{{ route('guru.menu') }}" class="{{ request()->routeIs('guru.menu') ? 'active' : '' }}">📝  Kuis dan Tugas</a></li>
    <li><a href="{{ route('guru.absensi.index') }}" class="{{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}">🗓️ Absensi</a></li>
    <li><a href="{{ route('guru.penilaian.index') }}" class="{{ request()->routeIs('guru.penilaian.index') ? 'active' : '' }}">📊 Penilaian</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
     <div class="user">👨‍🏫 {{ $user->name ?? 'Nama Guru' }}</div>
  </div>
<!-- Informasi Umum -->
<div class="info-frame section">
  <h4>📢 Kuis, Tugas, dan Ujian</h4>
  <p> Silakan kelola komponen pembelajaran berikut untuk mendukung keberhasilan siswa:</p>
</div>

<!-- Kartu Menu -->
<div class="card-container section">
  <div class="card">
    <h3>📄 Tugas</h3>
    <p>Kelola tugas untuk siswa berdasarkan kelas dan mata pelajaran.</p>
 <a href="javascript:void(0)" onclick="openPopup('{{ route('guru.tugas.index') }}')">Kelola Tugas</a>

  </div>

  <div class="card">
  <h3>📥 Jawaban Siswa</h3>
  <p>Lihat dan nilai jawaban dari siswa pada tugas, kuis, dan ujian yang telah diberikan.</p>
  <a href="javascript:void(0)" onclick="openPopup('{{ route('guru.jawaban.index') }}')">Lihat Jawaban</a>
</div>
  <div class="card">
    <h3>📝 Ujian</h3>
    <p>Buat dan atur ujian serta waktu pelaksanaannya.</p>
  <a href="javascript:void(0)" onclick="openPopup('{{ route('guru.ujian.index') }}')">Kelola Ujian</a>

  </div>

</div>
<!-- Modal -->
<div id="popupModal" class="popup-modal">
  <div class="popup-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <iframe id="popupFrame" src="" frameborder="0"></iframe>
  </div>
</div>
<!-- Footer -->
<footer id="footer">
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.
</footer>
   <script>
  function openPopup(url) {
    document.getElementById('popupModal').style.display = 'block';
    document.getElementById('popupFrame').src = url;
  }

  function closeModal() {
    document.getElementById('popupModal').style.display = 'none';
    document.getElementById('popupFrame').src = '';
  }
</script> 
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Siswa</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/dashboarsiswa.css'])
  <style>
    
.pengumuman-container {
  margin-bottom: 10px;
  background: #e3f2fd;
  border: 1px solid #90caf9;
  border-radius: 12px;
  padding: 10px;
}

.pengumuman-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  color: #1565c0;
  font-weight: 600;
}

#toggle-icon-semua {
  font-size: 18px;
  transition: transform 0.3s ease;
}

.pengumuman-container.open #toggle-icon-semua {
  transform: rotate(180deg);
}

.pengumuman-box {
  background: #fff;
  border: 1px solid #bbdefb;
  border-radius: 10px;
  padding: 15px;
  margin-top: 12px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.pengumuman-box h4 {
  margin: 0;
  color: #0d47a1;
}

.pengumuman-isi {
  margin-top: 8px;
}

.tanggal {
  font-size: 13px;
  color: #777;
  margin-top: 4px;
}
/* Pengaturan kontainer utama pengumuman */
.pengumuman-container {
  max-width: 1140px;
  margin-bottom: 30px; /* jarak dari card di bawahnya */
  font-size: 14px;
}

/* Judul dalam pengumuman */
.pengumuman-header h4 {
  font-size: 15px;
  margin-bottom: 1px;
}

/* Tanggal pengumuman */
.pengumuman-box .tanggal {
  font-size: 12px;
  color: #777;
  margin-bottom: 6px;
}

/* Isi pengumuman */
.pengumuman-isi p {
  font-size: 13px;
  margin: 0;
  line-height: 1.4;
}
    
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h2>E-LEARNING</h2>
    <ul>
            @php
    // Ambil mapel pertama dari daftar
    $firstMapel = \App\Models\Mapel::first();
@endphp
       <li><a href="{{ route('siswa.siswadashboard') }}">🏠 Beranda</a></li>

@if ($firstMapel)
    <li>
        <a href="{{ route('siswa.mapel.detail', ['id' => $firstMapel->id]) }}">
            📚 Mata Pelajaran
        </a>
    </li>
@endif

<li><a href="{{ route('siswa.absensi.index') }}">📋 Absensi</a></li>
<li><a href="{{ route('siswa.nilai.index') }}">📊 Nilai</a></li>
    </ul>
</div>


<!-- Konten Utama -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
<a href="{{ route('siswa.profil') }}" class="user flex items-center space-x-2 text-blue-600 hover:underline">
    👤 <span>{{ Auth::user()->name ?? 'Nama Siswa' }}</span>
</a>
  </div>

  <div class="info-frame">
    <h4>📢 Informasi Umum</h4>
    <p>Selamat datang di platform E-Learning! Silakan cek jadwal dan tugas Anda secara berkala.</p>
  </div>

 
  <!-- Pengumuman -->
  <div class="pengumuman-container">
    <div class="pengumuman-title" onclick="toggleSemuaPengumuman()">
      <h3> 📰  Pengumuman </h3>
      <span id="toggle-icon-semua"></span>
    </div>

    <div id="pengumuman-list" style="display: none;">
      @if($pengumumen->isEmpty())
          <p>Tidak ada pengumuman saat ini.</p>
      @else
          @foreach($pengumumen as $p)
              <div class="pengumuman-box">
                  <div class="pengumuman-header">
                      <h4>{{ $p->judul }}</h4>
                  </div>
                  <p class="tanggal">🗓️ {{ \Carbon\Carbon::parse($p->tanggal_pengumuman)->translatedFormat('d F Y') }}</p>
                  <div class="pengumuman-isi">
                      <p>{{ $p->isi }}</p>
                  </div>
              </div>
          @endforeach
      @endif
    </div>
<!-- Jadwal Hari Ini -->
<div class="jadwal-hari-ini" style="margin-top: 30px;">
    <h3>📅 Jadwal Hari Ini</h3>
    @if($jadwalHariIni->isEmpty())
        <p>Tidak ada jadwal pelajaran hari ini.</p>
    @else
        <ul style="list-style:none; padding:0;">
            @foreach($jadwalHariIni as $jadwal)
                <li style="margin-bottom: 10px; background: #f1f8e9; padding: 12px; border-radius: 8px;">
                    <strong>{{ $jadwal->mapel->nama_mapel ?? '-' }}</strong> -
                    {{ $jadwal->jam }} |
                    {{ ucfirst($jadwal->tipe_ruangan) }} {{ $jadwal->ruangan ? "- $jadwal->ruangan" : '' }}<br>
                    👨‍🏫 {{ $jadwal->guru->nama ?? '-' }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
  </div>
    </div>
    

   

    <!-- Ujian -->
    


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
   function toggleSemuaPengumuman() {
    const list = document.getElementById('pengumuman-list');
    const container = document.querySelector('.pengumuman-container');
    const icon = document.getElementById('toggle-icon-semua');

    const isVisible = list.style.display === 'block';
    list.style.display = isVisible ? 'none' : 'block';
    container.classList.toggle('open', !isVisible);
  }
</script>
</body>
</html>

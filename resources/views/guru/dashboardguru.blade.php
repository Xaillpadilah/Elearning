<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/Adminguru.css'])
  <style>
    * { box-sizing: border-box; }
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
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    padding: 0 10px;
  }

  @media (max-width: 768px) {
    .cards {
      grid-template-columns: 1fr;
    }
  }

  .card {
    background: linear-gradient(135deg, #4f46e5, #6b73ff);
    color: white;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
  }

  .card-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 12px;
  }

  .kelas {
    background: rgba(255,255,255,0.2);
    border-radius: 8px;
    padding: 2px 8px;
    font-size: 12px;
    margin-left: 5px;
  }

  .card ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 10px;
  }

  .card li {
    font-size: 14px;
    margin-bottom: 6px;
  }

  .card a button {
    margin-top: auto;
    padding: 8px 16px;
    border: none;
    background: white;
    color: #6b64ebff;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .card a button:hover {
    background: #f0f0ff;
  }

  footer {
    margin-top: 40px;
    text-align: center;
    font-size: 13px;
    color: #777;
  }

  .sidebar.hidden {
    display: none;
  }

  .main.fullscreen {
    margin-left: 0;
  }

  #footer.fullscreen {
    margin-left: 0;
  }
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
  <h2>Dashboard Guru</h2>
  <ul>
    <li><a href="{{ route('guru.dashboard') }}" class="active">🏠 Dashboard</a></li>
    <li><a href="{{ route('materi.index') }}"> Materi Dan Konten</a></li>
    <li><a href="{{ route('guru.menu') }}"> Kuis dan Tugas</a></li>
    <li><a href="{{ route('guru.absensi.index') }}"> Absensi</a></li>
    <li><a href="{{ route('guru.penilaian.index') }}"> Penilaian</a></li>
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
  </div>

  <!-- Kartu Informasi -->
  <div class="cards">
    <!-- Card Ujian -->
    <div class="card">
      <h4 class="card-title">📝 Ujian Terbaru <span class="kelas">Ujian</span></h4>
      <ul>
        @forelse($ujians as $ujian)
          <li>{{ $ujian->judul }} - {{ $ujian->relasi->kelas->nama_kelas ?? '' }}</li>
        @empty
          <li>Belum ada ujian.</li>
        @endforelse
      </ul>
      <a href="{{ route('guru.ujian.index') }}"><button>Lihat Semua</button></a>
    </div>

    <!-- Card Tugas -->
    <div class="card">
      <h4 class="card-title">📚 Tugas Terbaru <span class="kelas">Tugas</span></h4>
      <ul>
        @forelse($tugas as $t)
          <li>{{ $t->judul }} - {{ $t->relasi->mapel->nama_mapel ?? '' }}</li>
        @empty
          <li>Belum ada tugas.</li>
        @endforelse
      </ul>
      <a href="{{ route('guru.menu') }}"><button>Lihat Semua</button></a>
    </div>

    <!-- Card Materi -->
    <div class="card">
      <h4 class="card-title">📘 Materi Terbaru <span class="kelas">Materi</span></h4>
      <ul>
        @forelse($materis as $m)
          <li>{{ $m->judul }} - {{ $m->kelas->nama_kelas ?? '' }}</li>
        @empty
          <li>Belum ada materi.</li>
        @endforelse
      </ul>
      <a href="{{ route('materi.index') }}"><button>Lihat Semua</button></a>
    </div>

    <!-- Card Absensi -->
    <div class="card">
      <h4 class="card-title">📊 Absensi Terbaru <span class="kelas">Absensi</span></h4>
      <ul>
        @forelse($absensis as $a)
          <li>{{ $a->siswa->nama ?? '-' }} - {{ $a->tanggal }}</li>
        @empty
          <li>Belum ada data absensi.</li>
        @endforelse
      </ul>
      <a href="{{ route('guru.absensi.index') }}"><button>Lihat Semua</button></a>
    </div>
  </div>
</div>

<!-- Footer -->
<footer id="footer">
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.
</footer>

<script>
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

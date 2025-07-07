<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Orang Tua</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
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
      position: fixed;
      overflow-y: auto;
    }
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
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .fullscreen-btn {
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
    .card-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 25px;
  margin-top: 20px;
}

.card {
  background: linear-gradient(to bottom, #ffffff, #f1f8e9);
  border-radius: 15px;
  padding: 25px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
  animation: slideInLeft 0.6s ease-out;
}

.card:hover {
  transform: translateY(-5px);
}

.card-title {
  font-weight: 600;
  font-size: 18px;
  color: #2e7d32;
  margin-bottom: 12px;
}

.card p {
  font-size: 14px;
  color: #555;
  margin-bottom: 12px;
}

.card a button {
  background: linear-gradient(to right, #81c784, #4caf50);
  color: white;
  border: none;
  padding: 10px 16px;
  font-size: 14px;
  border-radius: 8px;
  cursor: pointer;
}

/* Animasi slide in kiri */
@keyframes slideInLeft {
  from {
    transform: translateX(-100px);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
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
    .hidden {
  display: none !important;
}

.fullscreen {
  width: 100% !important;
  margin-left: 0 !important;
}
.info-frame-kecil {
  padding: 12px 18px;
  font-size: 14px;
  margin-bottom: 20px;
}
.info-frame-kecil h4 {
  font-size: 16px;
  margin-bottom: 6px;
}
.info-frame-kecil p {
  font-size: 20px;
}
.info-frame P {
  padding: 12px 18px;
  margin-bottom: 20px;
  font-size: 14px;
}

.info-frame p h4 {
  font-size: 20px;
  margin-bottom: 6px;
}

.info-frame p ul {
  padding-left: 16px;
  margin-top: 6px;
}

.info-frame p li {
  margin-bottom: 6px;
  font-size: 13px;
}
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>Dashboard Orang Tua</h2>
  <ul>
    <li><a href="{{ route('orangtua.dashboard') }}" class="{{ request()->routeIs('orangtua.dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('orangtua.hasil') }}" class="{{ request()->routeIs('orangtua.hasil') ? 'active' : '' }}">📊 Hasil</a></li>
    <li><a href="{{ route('orangtua.perkembangan') }}" class="{{ request()->routeIs('orangtua.perkembangan') ? 'active' : '' }}">📈 Perkembangan</a></li>
    <li><a href="{{ route('orangtua.komunikasi') }}" class="{{ request()->routeIs('orangtua.komunikasi') ? 'active' : '' }}">💬 Komunikasi</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">👨‍👩‍👧 {{ $user->name ?? 'Orang Tua' }}</div>
  </div>
  <div class="info-frame info-frame-kecil">
    <h4>👋 Selamat Datang</h4>
    <p>Anda dapat melihat perkembangan akademik dan aktivitas anak Anda di sini.</p>
  </div>

<div class="info-container" style="margin-bottom: 20px;">
  <button onclick="toggleInfo()" class="toggle-btn" style="padding: 8px 12px; background-color:rgb(77, 255, 166); border: none; border-radius: 4px; cursor: pointer;">
    📢 Pengumuman Sekolah
  </button>

  <div id="infoFrame" class="info-frame p" style="background: #fff3e0; border: 1px solidrgb(20, 183, 204); margin-top: 10px; padding: 10px; transition: max-height 0.5s ease-out, opacity 0.5s;">
    <h4></h4>
    <ul style="margin: 0; padding-left: 20px;">
      @foreach($pengumuman as $item)
        <li>
          <strong>{{ $item['tanggal'] }}:</strong> {{ $item['isi'] }}
        </li>
      @endforeach
    </ul>
  </div>
</div>
  <!-- Grafik dalam 1 baris -->
  <div class="info-frame">
    <h4>📊 Grafik Perkembangan Anak</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; justify-items: center;">
      <div style="width: 100%; max-width: 300px;">
        <h5 style="text-align: center; font-size: 14px;">Nilai Anak</h5>
        <canvas id="nilaiChart" height="120"></canvas>
      </div>
      <div style="width: 100%; max-width: 300px;">
        <h5 style="text-align: center; font-size: 14px;">Kehadiran</h5>
        <canvas id="kehadiranChart" height="120"></canvas>
      </div>
      <div style="width: 100%; max-width: 300px;">
        <h5 style="text-align: center; font-size: 14px;">Tugas Diselesaikan</h5>
        <canvas id="tugasChart" height="120"></canvas>
      </div>
    </div>
  </div>

  <!-- Cards -->
 
    <div class="card-container">
  <div class="card">
    <div class="card-title">🗓️ Hasil</div>
    <p>Monitor Hasil anak Anda setiap hari.</p>
    <a href="{{ route('orangtua.hasil') }}"><button>Lihat Absensi</button></a>
  </div>

  <div class="card">
    <div class="card-title">📚 Tugas Anak</div>
    <p>Lihat Perkembangan anak Anda.</p>
    <a href="{{ route('orangtua.perkembangan') }}"><button>Lihat Tugas</button></a>
  </div>

  <div class="card">
    <div class="card-title">🕒 Komunikasi</div>
    <p>Lihat Komunikasi dengan guru.</p>
    <a href="{{ route('orangtua.komunikasi') }}"><button>Lihat Jadwal</button></a>
  </div>
</div>

<!-- Footer -->
<footer id="footer">
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Dashboard Orang Tua.
</footer>

<!-- Chart.js Script -->
<script>
  function toggleFullscreenDashboard() {
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('main-content').classList.toggle('fullscreen');
    document.getElementById('footer').classList.toggle('fullscreen');
    
  }

  const nilaiLabels = {!! json_encode(array_keys($nilaiAnak)) !!};
  const nilaiData = {!! json_encode(array_values($nilaiAnak)) !!};

  const kehadiranLabels = {!! json_encode(array_keys($kehadiran)) !!};
  const kehadiranData = {!! json_encode(array_values($kehadiran)) !!};

  const tugasLabels = {!! json_encode(array_keys($perkembanganTugas)) !!};
  const tugasData = {!! json_encode(array_values($perkembanganTugas)) !!};

  new Chart(document.getElementById('nilaiChart'), {
    type: 'bar',
    data: {
      labels: nilaiLabels,
      datasets: [{
        label: 'Nilai Anak',
        data: nilaiData,
        backgroundColor: '#66bb6a'
      }]
    },
    options: {
      scales: { y: { beginAtZero: true, max: 100 } }
    }
  });

  new Chart(document.getElementById('kehadiranChart'), {
    type: 'line',
    data: {
      labels: kehadiranLabels,
      datasets: [{
        label: 'Kehadiran Harian',
        data: kehadiranData,
        borderColor: '#42a5f5',
        backgroundColor: 'rgba(66,165,245,0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      scales: { y: { beginAtZero: true } }
    }
  });

  new Chart(document.getElementById('tugasChart'), {
    type: 'radar',
    data: {
      labels: tugasLabels,
      datasets: [{
        label: 'Tugas Diselesaikan',
        data: tugasData,
        backgroundColor: 'rgba(255, 193, 7, 0.2)',
        borderColor: '#ffb300',
        pointBackgroundColor: '#ffb300'
      }]
    },
    options: {
      scales: {
        r: {
          suggestedMin: 0,
          suggestedMax: 10
        }
      }
    }
  });
</script>
<script>
  function toggleInfo() {
    const el = document.getElementById('infoFrame');
    if (el.style.display === 'none' || el.style.maxHeight === '0px') {
      el.style.display = 'block';
      setTimeout(() => {
        el.style.maxHeight = '1000px';
        el.style.opacity = '1';
      }, 10);
    } else {
      el.style.maxHeight = '0px';
      el.style.opacity = '0';
      setTimeout(() => {
        el.style.display = 'none';
      }, 500);
    }
  }

  // Optional: inisialisasi dalam keadaan terbuka
  window.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('infoFrame');
    el.style.maxHeight = '1000px';
    el.style.opacity = '1';
  });
</script>
</body>
</html>

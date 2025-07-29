<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perkembangan Anak - Dashboard Orang Tua</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    * { box-sizing: border-box; }
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
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }
    th {
      background: #e8f5e9;
      color: #1b5e20;
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
    .hidden { display: none !important; }
    .fullscreen {
      width: 100% !important;
      margin-left: 0 !important;
    }
    .grafik-header {
  display: flex;
  align-items: center;
  gap: 30px;
  margin-bottom: 16px;
}

.grafik-header h4 {
  margin: 0;
  font-size: 18px;
  color: #2e7d32;
}

.grafik-content {
  display: flex;
  gap: 40px;
  flex-wrap: wrap;
}

.grafik-content > div {
  flex: 1;
  min-width: 300px;
}
  </style>
</head>
<body>

<div class="sidebar">
  <h2>Dashboard Orang Tua</h2>
  <ul>
   <li><a href="{{ route('orangtua.dashboard') }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('orangtua.hasil') }}">🗓️ Nilai</a></li>
    <li><a href="{{ route('orangtua.perkembangan') }}class="active>📚 Perkembangan</a></li>
    <li><a href="{{ route('orangtua.komunikasi') }}">🕒 Komunikasi</a></li>
  </ul>
</div>

<div class="main">
  <div class="header">
   <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">👨‍👩‍👧 Orang Tua</div>
  </div>
<div class="info-frame grafik-wrapper">
  <div class="grafik-header">
    <h4>📈 Perkembangan Anak Selama 1 Bulan</h4>
    <h4>📚 Perkembangan Belajar Semester</h4>
  </div>
  <div class="grafik-content">
    <div>
      <p>Aktivitas anak secara keseluruhan dalam 1 bulan.</p>
      <canvas id="perkembanganBulananChart" height="120"></canvas>
    </div>
    <div>
      <p>Nilai rata-rata berbagai mata pelajaran.</p>
      <canvas id="belajarSemesterChart" height="120"></canvas>
    </div>
  </div>
</div>

  <div class="info-frame">
    <h4>🤸‍♂️ Kegiatan Ekstrakurikuler</h4>
    <ul>
      <li><strong>Pramuka</strong> - Kehadiran: 90%</li>
      <li><strong>Futsal</strong> - Kehadiran: 85%</li>
      <li><strong>Paduan Suara</strong> - Kehadiran: 80%</li>
    </ul>
  </div>
</div>

<footer>
  &copy; 2025 E-Learning SMP 5 CIDAUN - Dashboard Orang Tua.
</footer>

<script>
  function toggleFullscreenDashboard() {
    document.querySelector('.sidebar').classList.toggle('hidden');
    document.querySelector('.main').classList.toggle('fullscreen');
    document.querySelector('footer').classList.toggle('fullscreen');
  }

  const perkembanganBulanan = {
    '1 Jul': 2,
    '5 Jul': 4,
    '10 Jul': 3,
    '15 Jul': 5,
    '20 Jul': 4,
    '25 Jul': 3,
    '30 Jul': 4
  };

  const belajarSemester = {
    'Matematika': 85,
    'IPA': 88,
    'Bahasa Indonesia': 90,
    'IPS': 83,
    'Bahasa Inggris': 87
  };

  new Chart(document.getElementById('perkembanganBulananChart'), {
    type: 'line',
    data: {
      labels: Object.keys(perkembanganBulanan),
      datasets: [{
        label: 'Aktivitas Harian',
        data: Object.values(perkembanganBulanan),
        borderColor: '#66bb6a',
        backgroundColor: 'rgba(102,187,106,0.2)',
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  new Chart(document.getElementById('belajarSemesterChart'), {
    type: 'bar',
    data: {
      labels: Object.keys(belajarSemester),
      datasets: [{
        label: 'Nilai Rata-Rata',
        data: Object.values(belajarSemester),
        backgroundColor: '#42a5f5'
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true, max: 100 }
      }
    }
  });
</script>

</body>
</html>

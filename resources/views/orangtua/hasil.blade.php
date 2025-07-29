<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hasil Belajar Anak</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>Dashboard Orang Tua</h2>
  <ul>
    <li><a href="{{ route('orangtua.dashboard') }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('orangtua.hasil') }}" class="active">🗓️ Hasil</a></li>
   
  </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">👨‍👩‍👧 {{ $user->name ?? 'Orang Tua' }}</div>
  </div>

  <div class="info-frame">
    <h4>📑 Hasil Belajar Anak</h4>
    <p>Berikut adalah rekap hasil belajar anak berdasarkan mata pelajaran dan penilaian yang tersedia.</p>
  </div>

  <div class="info-frame">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Mata Pelajaran</th>
          <th>Nilai Tugas</th>
          <th>Nilai Ujian</th>
          <th>Nilai Akhir</th>
        </tr>
      </thead>
      <tbody>
        @foreach($hasilBelajar as $index => $hasil)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $hasil['mapel'] }}</td>
            <td>{{ $hasil['tugas'] }}</td>
            <td>{{ $hasil['ujian'] }}</td>
            <td><strong>{{ number_format(($hasil['tugas'] + $hasil['ujian']) / 2, 1) }}</strong></td>
          </tr>
        @endforeach
      </tbody>
    </table>
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

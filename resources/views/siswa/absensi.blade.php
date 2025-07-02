<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Absensi Siswa</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
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
      z-index: 1000;
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
      color: #333;
      text-decoration: none;
      font-weight: 500;
      border-radius: 10px;
      transition: background 0.3s, color 0.3s;
    }

    .sidebar ul li a:hover,
    .sidebar ul li a.active {
      background: linear-gradient(to right, #bbdefb, #d1c4e9);
      color: #4a148c;
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
      padding: 6px 0;
      color: #444;
      display: block;
    }

    .sub-mapel li a:hover { color: #6a1b9a; }

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

    .fullscreen-btn {
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
      border: none;
      color: #0d47a1;
      padding: 8px 16px;
      border-radius: 10px;
      font-weight: 500;
      font-size: 14px;
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
      background-color: #e3f2fd;
      padding: 20px 24px;
      border-left: 5px solid #2196f3;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .info-frame h4 {
      margin: 0 0 8px 0;
      color: #0d47a1;
      font-size: 18px;
    }

    .cards {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .card {
      background: white;
      padding: 24px;
      border-radius: 14px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    .card-title {
      font-size: 20px;
      font-weight: 600;
      color: #3f51b5;
      margin-bottom: 16px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
      margin-top: 12px;
    }

    table thead {
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
      color: #0d47a1;
    }

    table th, table td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid #e0e0e0;
    }

    table tbody tr:hover { background-color: #f9f9f9; }

    .badge {
      padding: 6px 14px;
      border-radius: 20px;
      font-weight: 500;
      font-size: 13px;
      display: inline-block;
    }

    .hadir { background: #d0f0c0; color: #1b5e20; }
    .izin { background: #fff8b2; color: #7b5e00; }
    .alpha { background: #ffcdd2; color: #b71c1c; }

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

    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }

      .main { margin-left: 0 !important; padding: 20px; }
      footer { left: 0 !important; width: 100% !important; }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>E-LEARNING</h2>
  <ul>
    <li><a href="{{ route('siswa.dashboard') }}">🏠 Beranda</a></li>
    <li>
      <a href="javascript:void(0)" onclick="toggleMapel()">📚 Mata Pelajaran</a>
      <ul id="sub-mapel" class="sub-mapel">
        @forelse($mataPelajaran ?? [] as $mapel)
          <li><a href="{{ route('siswa.matapelajaran.show', $mapel['id']) }}">📘 {{ $mapel['nama'] }}</a></li>
        @empty
          <li><em>Tidak ada pelajaran</em></li>
        @endforelse
      </ul>
    </li>
    <li><a href="{{ route('siswa.absensi') }}" class="active">📸 Absensi</a></li>
    <li><a href="{{ route('siswa.nilai') }}">📊 Nilai Akhir</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">👤 {{ $user->name }}</div>
  </div>

  <div class="info-frame">
    <h4>📝 Data Absensi</h4>
    <p>Berikut adalah daftar kehadiran Anda selama semester ini.</p>
  </div>

  <div class="cards">
    <div class="card">
      <div class="card-title">Riwayat Absensi</div>
      <div style="overflow-x:auto;">
        <table>
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Mata Pelajaran</th>
              <th>Jam</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($absensi as $data)
              <tr>
                <td>{{ $data['tanggal'] }}</td>
                <td>{{ $data['mapel'] }}</td>
                <td>{{ $data['jam'] }}</td>
                <td>
                  @php
                    $statusClass = match($data['status']) {
                      'Hadir' => 'hadir',
                      'Izin' => 'izin',
                      default => 'alpha',
                    };
                  @endphp
                  <span class="badge {{ $statusClass }}">{{ $data['status'] }}</span>
                </td>
              </tr>
            @empty
              <tr><td colspan="4">Belum ada data absensi.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
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

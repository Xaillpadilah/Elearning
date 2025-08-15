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
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
    .empty {
      padding: 20px;
      background: #fff3e0;
      border-left: 4px solid #ffb300;
      border-radius: 6px;
      font-weight: 500;
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
    table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

th, td {
  padding: 14px 18px;
  text-align: left;
  border: 1px solid #e0e0e0; /* garis vertikal dan horizontal */
}

th {
  background: linear-gradient(to right, #e8f5e9, #e0f7fa);
  color: #1b5e20;
  font-weight: 600;
  font-size: 14px;
}

td {
  font-size: 13px;
  background-color: #fafafa;
  transition: background-color 0.3s ease;
}

tbody tr:hover td {
  background-color: #f1f8e9; /* efek hover pada baris */
}
.info-frame.bulan {
  border-left: 6px solid #64b5f6;
  background-color: #e3f2fd;
}

.info-frame.perkembangan {
  border-left: 6px solid #81c784;
  background-color: #f1f8e9;
}

.info-frame.semester {
  border-left: 6px solid #9575cd;
  background-color: #ede7f6;
}
.dropdown-header {
  cursor: pointer;
}

.dropdown-header h4:hover {
  color: #2e7d32;
  text-decoration: underline;
}

  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>Dashboard Orang Tua</h2>
  <ul>
    <li><a href="{{ route('orangtua.dashboard') }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('orangtua.nilai') }}" class="active">📑 Hasil</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    
  </div>

  <div class="info-frame">
    <h4>📑 Hasil Belajar Anak</h4>
    <p>Berikut adalah rekap hasil belajar anak berdasarkan mata pelajaran dan penilaian yang tersedia.</p>

<div class="info-frame bulan">
  <div class="dropdown-header" onclick="toggleDropdown('bulan')">
    <h4>📑 Hasil Belajar Anak - 1 Bulan Terakhir ⬇️</h4>
    <p>Berikut adalah rekap hasil belajar anak selama 1 bulan terakhir berdasarkan mata pelajaran dan penilaian.</p>
  </div>

  <div class="dropdown-content" id="bulan" style="display: none;">
    @if($penilaianBulan->isEmpty())
        <p class="empty">Tidak ada data nilai tersedia untuk 1 bulan terakhir.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Mata Pelajaran</th>
                    <th>Tugas</th>
                    <th>Kuis</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penilaianBulan as $nilai)
                    <tr>
                        <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $nilai->nilai_tugas }}</td>
                        <td>{{ $nilai->nilai_kuis }}</td>
                        <td>{{ $nilai->catatan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
  </div>
</div>
<div class="info-frame semester" style="margin-top: 30px;">
  <div class="dropdown-header" onclick="toggleDropdown('semester')">
    <h4>📚 Hasil Belajar Anak - 1 Semester Terakhir ⬇️</h4>
    <p>Berikut adalah rekap hasil belajar anak selama 1 semester terakhir (6 bulan).</p>
  </div>

  <div class="dropdown-content" id="semester" style="display: none;">
    @if($penilaianSemester->isEmpty())
        <p class="empty">Tidak ada data nilai tersedia untuk 1 semester terakhir.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Mata Pelajaran</th>
                    <th>Tugas</th>
                    <th>Kuis</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Nilai Akhir</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penilaianSemester as $nilai)
                    @php
                        $tugas = $nilai->nilai_tugas ?? 0;
                        $kuis = $nilai->nilai_kuis ?? 0;
                        $uts = $nilai->nilai_uts ?? 0;
                        $uas = $nilai->nilai_uas ?? 0;

                        $nilaiAkhir = round(($tugas * 0.2) + ($kuis * 0.2) + ($uts * 0.3) + ($uas * 0.3), 2);
                    @endphp
                    <tr>
                        <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $tugas }}</td>
                        <td>{{ $kuis }}</td>
                        <td>{{ $uts }}</td>
                        <td>{{ $uas }}</td>
                        <td>{{ $nilaiAkhir }}</td>
                        <td>{{ $nilai->catatan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
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
<script>
  function toggleDropdown(id) {
    const content = document.getElementById(id);
    if (content.style.display === "none") {
      content.style.display = "block";
    } else {
      content.style.display = "none";
    }
  }
</script>
</body>
</html>

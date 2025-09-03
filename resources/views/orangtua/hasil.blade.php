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

@php
    // Dummy data: tracking nilai kuis & tugas per minggu selama 1 bulan (4 minggu)
    $penilaianMinggu = collect([
        // Matematika
        ['minggu' => 'Minggu 1', 'mapel' => 'Matematika', 'tugas' => 85, 'kuis' => 88],
        ['minggu' => 'Minggu 2', 'mapel' => 'Matematika', 'tugas' => 86, 'kuis' => 90],
        ['minggu' => 'Minggu 3', 'mapel' => 'Matematika', 'tugas' => 88, 'kuis' => 92],
        ['minggu' => 'Minggu 4', 'mapel' => 'Matematika', 'tugas' => 90, 'kuis' => 95],

        // Bahasa Inggris
        ['minggu' => 'Minggu 1', 'mapel' => 'Bahasa Inggris', 'tugas' => 70, 'kuis' => 75],
        ['minggu' => 'Minggu 2', 'mapel' => 'Bahasa Inggris', 'tugas' => 72, 'kuis' => 78],
        ['minggu' => 'Minggu 3', 'mapel' => 'Bahasa Inggris', 'tugas' => 75, 'kuis' => 80],
        ['minggu' => 'Minggu 4', 'mapel' => 'Bahasa Inggris', 'tugas' => 78, 'kuis' => 85],

        // Seni Budaya
        ['minggu' => 'Minggu 1', 'mapel' => 'Seni Budaya', 'tugas' => 55, 'kuis' => 60],
        ['minggu' => 'Minggu 2', 'mapel' => 'Seni Budaya', 'tugas' => 60, 'kuis' => 65],
        ['minggu' => 'Minggu 3', 'mapel' => 'Seni Budaya', 'tugas' => 65, 'kuis' => 70],
        ['minggu' => 'Minggu 4', 'mapel' => 'Seni Budaya', 'tugas' => 70, 'kuis' => 75],

        // PKN
        ['minggu' => 'Minggu 1', 'mapel' => 'Pendidikan Kewarganegaraan', 'tugas' => 50, 'kuis' => 50],
        ['minggu' => 'Minggu 2', 'mapel' => 'Pendidikan Kewarganegaraan', 'tugas' => 52, 'kuis' => 55],
        ['minggu' => 'Minggu 3', 'mapel' => 'Pendidikan Kewarganegaraan', 'tugas' => 50, 'kuis' => 50],
        ['minggu' => 'Minggu 4', 'mapel' => 'Pendidikan Kewarganegaraan', 'tugas' => 55, 'kuis' => 50],

        // Pendidikan Agama
        ['minggu' => 'Minggu 1', 'mapel' => 'Pendidikan Agama', 'tugas' => 100, 'kuis' => 100],
        ['minggu' => 'Minggu 2', 'mapel' => 'Pendidikan Agama', 'tugas' => 100, 'kuis' => 100],
        ['minggu' => 'Minggu 3', 'mapel' => 'Pendidikan Agama', 'tugas' => 100, 'kuis' => 100],
        ['minggu' => 'Minggu 4', 'mapel' => 'Pendidikan Agama', 'tugas' => 100, 'kuis' => 100],

        // IPA
        ['minggu' => 'Minggu 1', 'mapel' => 'Ilmu Pengetahuan Alam', 'tugas' => 75, 'kuis' => 75],
        ['minggu' => 'Minggu 2', 'mapel' => 'Ilmu Pengetahuan Alam', 'tugas' => 78, 'kuis' => 80],
        ['minggu' => 'Minggu 3', 'mapel' => 'Ilmu Pengetahuan Alam', 'tugas' => 80, 'kuis' => 82],
        ['minggu' => 'Minggu 4', 'mapel' => 'Ilmu Pengetahuan Alam', 'tugas' => 85, 'kuis' => 85],

        // TIK
        ['minggu' => 'Minggu 1', 'mapel' => 'Teknologi Informasi dan Komunikasi', 'tugas' => 55, 'kuis' => 60],
        ['minggu' => 'Minggu 2', 'mapel' => 'Teknologi Informasi dan Komunikasi', 'tugas' => 60, 'kuis' => 65],
        ['minggu' => 'Minggu 3', 'mapel' => 'Teknologi Informasi dan Komunikasi', 'tugas' => 65, 'kuis' => 68],
        ['minggu' => 'Minggu 4', 'mapel' => 'Teknologi Informasi dan Komunikasi', 'tugas' => 70, 'kuis' => 70],

        // Penjas
        ['minggu' => 'Minggu 1', 'mapel' => 'Pendidikan Jasmani', 'tugas' => 50, 'kuis' => 48],
        ['minggu' => 'Minggu 2', 'mapel' => 'Pendidikan Jasmani', 'tugas' => 55, 'kuis' => 50],
        ['minggu' => 'Minggu 3', 'mapel' => 'Pendidikan Jasmani', 'tugas' => 60, 'kuis' => 55],
        ['minggu' => 'Minggu 4', 'mapel' => 'Pendidikan Jasmani', 'tugas' => 65, 'kuis' => 60],

        // IPS
        ['minggu' => 'Minggu 1', 'mapel' => 'Ilmu Pengetahuan Sosial', 'tugas' => 85, 'kuis' => 80],
        ['minggu' => 'Minggu 2', 'mapel' => 'Ilmu Pengetahuan Sosial', 'tugas' => 87, 'kuis' => 85],
        ['minggu' => 'Minggu 3', 'mapel' => 'Ilmu Pengetahuan Sosial', 'tugas' => 90, 'kuis' => 88],
        ['minggu' => 'Minggu 4', 'mapel' => 'Ilmu Pengetahuan Sosial', 'tugas' => 92, 'kuis' => 90],
    ]); // Grouping berdasarkan mata pelajaran

    $groupedPenilaian = $penilaianMinggu->groupBy('mapel');
@endphp

<style>
  /* Frame Utama */
  .info-frame.minggu {
    background: linear-gradient(135deg, #ffffff, #f3f7ff);
    border: 2px solid #d4e0ff;
    border-radius: 16px;
    padding: 20px;
    margin: 20px 0;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
  }

  /* Header Dropdown */
  .info-frame.minggu .dropdown-header {
    cursor: pointer;
    background: #3f72af;
    color: white;
    padding: 14px 18px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 12px;
    transition: all 0.3s ease;
  }
  .info-frame.minggu .dropdown-header:hover {
    background: #2c4f82;
    transform: scale(1.02);
  }

  /* Konten Dropdown */
  .info-frame.minggu .dropdown-content {
    margin-top: 10px;
    padding: 12px;
    background: #f9fbff;
    border-radius: 12px;
    border: 1px solid #e0e7ff;
    animation: fadeIn 0.5s ease-in-out;
  }

  /* Mapel Frame */
  .mapel-frame {
    border: 1px solid #dce7ff;
    border-radius: 12px;
    margin-top: 14px;
    background: #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    padding: 10px;
  }

  /* Sub-header Mapel */
  .mapel-frame .dropdown-header {
    background: #112d4e;
    font-size: 15px;
    border-radius: 8px;
    padding: 10px 14px;
    margin: 0 0 8px 0;
  }

  /* Tabel Nilai */
  .mapel-frame table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 6px;
    font-size: 14px;
    border-radius: 10px;
    overflow: hidden;
  }
  .mapel-frame table thead {
    background: #3f72af;
    color: white;
  }
  .mapel-frame table th,
  .mapel-frame table td {
    padding: 10px;
    text-align: center;
    border: 1px solid #e3ebff;
  }
  .mapel-frame table tbody tr:nth-child(even) {
    background: #f0f6ff;
  }
  .mapel-frame table tbody tr:hover {
    background: #dbe7ff;
    transition: 0.2s;
  }

  /* Animasi Dropdown */
  @keyframes fadeIn {
    from {opacity: 0; transform: translateY(-5px);}
    to {opacity: 1; transform: translateY(0);}
  }

  /* Pesan Kosong */
  .info-frame.minggu .empty {
    text-align: center;
    padding: 10px;
    color: #6c757d;
    font-style: italic;
  }
</style>

<div class="info-frame minggu">
  <div class="dropdown-header" onclick="toggleDropdown('minggu')">
    <h4>🗓️ Hasil Belajar Anak - 1 Bulan ⬇️</h4>
    <p>Berikut adalah rekap nilai tugas dan kuis anak setiap minggu selama 1 bulan terakhir.</p>
  </div>

  <div class="dropdown-content" id="minggu" style="display: none;">
    @if($groupedPenilaian->isEmpty())
        <p class="empty">Tidak ada data nilai mingguan tersedia.</p>
    @else
        @foreach($groupedPenilaian as $mapel => $nilaiMapel)
            <div class="mapel-frame">
                <div class="dropdown-header" onclick="toggleDropdown('mapel-{{ Str::slug($mapel) }}')">
                    <h4> {{ $mapel }} </h4>
                    <p>Rekap nilai tugas & kuis {{ $mapel }} per minggu.</p>
                </div>

                <div class="dropdown-content" id="mapel-{{ Str::slug($mapel) }}" style="display:none;">
                    <table>
                        <thead>
                            <tr>
                                <th>Minggu</th>
                                <th>Tugas</th>
                                <th>Kuis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilaiMapel as $nilai)
                                <tr>
                                    <td>{{ $nilai['minggu'] }}</td>
                                    <td>{{ $nilai['tugas'] }}</td>
                                    <td>{{ $nilai['kuis'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
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
                    <th>Absensi</th>
                    <th>Nilai Akhir</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penilaianSemester as $nilai)
                    @php
                        // Data nilai
                        $tugas = $nilai->nilai_tugas ?? 0;
                        $kuis = $nilai->nilai_kuis ?? 0;
                        $uts = $nilai->nilai_uts ?? 0;
                        $uas = $nilai->nilai_uas ?? 0;

                        // Ambil data pertemuan untuk siswa + mapel ini
                        $pertemuan = \App\Models\Pertemuan::where('siswa_id', $nilai->siswa_id)
                                        ->where('mapel_id', $nilai->mapel_id)
                                        ->first();

                        $hadirSemester1 = $pertemuan->hadir_semester1 ?? 0;
                        $hadirSemester2 = $pertemuan->hadir_semester2 ?? 0;

                        $totalHadir = $hadirSemester1 + $hadirSemester2;

                        $pertemuan1 = $pertemuan->pertemuan_semester1 ?? 0;
                        $pertemuan2 = $pertemuan->pertemuan_semester2 ?? 0;

                        $totalPertemuan = $pertemuan1 + $pertemuan2;

                        // Hitung persentase absensi (kalau mau ditampilkan)
                        $persenAbsensi = $totalPertemuan > 0 
                            ? round(($totalHadir / $totalPertemuan) * 100, 2) 
                            : 0;

                        // Hitung nilai akhir (absensi tidak masuk ke bobot)
                        $nilaiAkhir = round(
                            ($tugas * 0.2) + 
                            ($kuis * 0.2) + 
                            ($uts * 0.25) + 
                            ($uas * 0.35),
                        2);
                    @endphp
                    <tr>
                        <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $tugas }}</td>
                        <td>{{ $kuis }}</td>
                        <td>{{ $uts }}</td>
                        <td>{{ $uas }}</td>
                        <td>{{ $totalHadir }}/{{ $totalPertemuan }}</td> {{-- tampil hadir dari tabel pertemuans --}}
                        <td>{{ $nilaiAkhir }}</td>
                        <td>{{ $nilai->catatan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/dashboarsiswa.css'])
  <style>
    .container {
    padding: 20px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    font-family: 'Poppins', sans-serif;
    overflow-x: auto;
}

.empty {
    text-align: center;
    color: #888;
    font-size: 1.1rem;
    padding: 30px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background-color: #f9f9f9;
    border-radius: 10px;
    overflow: hidden;
}

thead {
    background-color: #4a90e2;
    color: white;
}

thead th {
    padding: 12px 16px;
    font-weight: 600;
    text-align: left;
}

tbody tr {
    transition: background-color 0.2s ease;
}

tbody tr:nth-child(even) {
    background-color: #f0f4fa;
}

tbody tr:hover {
    background-color: #e1ebf7;
}

tbody td {
    padding: 12px 16px;
    color: #333;
    font-size: 0.95rem;
    vertical-align: top;
}

@media screen and (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }

    thead {
        display: none;
    }

    tbody tr {
        margin-bottom: 15px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px;
    }

    tbody td {
        position: relative;
        padding-left: 50%;
    }

    tbody td::before {
        position: absolute;
        top: 12px;
        left: 16px;
        width: 45%;
        white-space: nowrap;
        font-weight: bold;
        color: #555;
    }

    tbody td:nth-of-type(1)::before { content: "Mata Pelajaran"; }
    tbody td:nth-of-type(2)::before { content: "Guru"; }
    tbody td:nth-of-type(3)::before { content: "Tugas"; }
    tbody td:nth-of-type(4)::before { content: "Kuis"; }
    tbody td:nth-of-type(5)::before { content: "UTS"; }
    tbody td:nth-of-type(6)::before { content: "UAS"; }
    tbody td:nth-of-type(7)::before { content: "Catatan"; }
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

<!-- Main Content -->
<div class="main" id="main-content">
    <div class="header">
        <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
        <div class="user">👤 {{ Auth::user()->name ?? 'Nama Siswa' }}</div>
    </div>

  <div class="info-frame">
    <h4>📊 Informasi Nilai</h4>
    <p>Anda dapat melihat daftar nilai, absensi, dan jumlah total pertemuan (36 kali dalam 1 tahun ajaran).</p>
</div>
<div class="container">
    @if($penilaians->isEmpty())
        <p class="empty">Tidak ada data nilai yang tersedia.</p>
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
               @foreach($penilaians as $nilai)
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

        // Hitung persentase absensi (untuk bobot nilai)
        $persenAbsensi = $totalPertemuan > 0 
            ? round(($totalHadir / $totalPertemuan) * 100, 2) 
            : 0;

        // Hitung nilai akhir (tanpa absensi masuk bobot nilai)
        $nilaiAkhir = round(
            ($tugas * 0.2) + 
            ($kuis * 0.2) + 
            ($uts * 0.25) + 
            ($uas * 0.35), // disesuaikan, biar absensi terpisah
        2);
    @endphp
    <tr>
        <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
        <td>{{ $tugas }}</td>
        <td>{{ $kuis }}</td>
        <td>{{ $uts }}</td>
        <td>{{ $uas }}</td>
        <td>{{ $totalHadir }}/{{ $totalPertemuan }}</td> {{-- tampil hadir dari data pertemuans --}}
        <td>{{ $nilaiAkhir }}</td>
        <td>{{ $nilai->catatan }}</td>
    </tr>
@endforeach
            </tbody>
        </table>
    @endif
</div>

    <footer id="footer">
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.
</footer>

    <script>
    function toggleMapel() {
        const el = document.getElementById("sub-mapel");
        el.style.display = (el.style.display === "none" || el.style.display === "") ? "block" : "none";
    }

     function toggleFullscreenDashboard() {
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('main-content').classList.toggle('fullscreen');
    document.getElementById('footer').classList.toggle('fullscreen');
  }
</script>
</body>
</html>

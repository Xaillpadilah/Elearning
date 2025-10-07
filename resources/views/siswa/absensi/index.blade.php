<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Absensi Saya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/dashboarsiswa.css'])
    <style>
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
            font-size: 14px;
        }

        .fullscreen-btn:hover {
            background: linear-gradient(to right, #9fa8da, #80deea);
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

        .info-frame p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        table th,
        table td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }

        table thead {
            background: linear-gradient(to right, #d1c4e9, #bbdefb);
            color: #4a148c;
        }

        table tbody tr:hover {
            background: #f1f8ff;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #888;
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
            <h4>📝 Informasi Absensi</h4>
            <p>Anda dapat melihat data kehadiran yang telah dicatat oleh guru. Pastikan semua data sesuai dengan
                kehadiran Anda.</p>
        </div>

        <div class="container mt-4">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mata Pelajaran</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensis as $absen)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>{{ $absen->mapel->nama_mapel ?? '-' }}</td>
                            <td>{{ ucfirst($absen->status) }}</td>
                            <td>{{ $absen->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="no-data">Belum ada data absensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
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
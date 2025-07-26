<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Absensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/adminguru.css'])
    <style>
        .search-form {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .search-form select, .absensi-form select, .absensi-form input[type="date"], .absensi-form input[type="text"] {
            padding: 10px 14px;
            border: 1px solid #c5cae9;
            border-radius: 10px;
            background: #f9f9fc;
            font-size: 14px;
            color: #333;
            min-width: 220px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 10px;
        }

        .search-form select:focus, .absensi-form select:focus, .absensi-form input:focus {
            border-color: #64b5f6;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(100, 181, 246, 0.2);
        }

        .search-form button, .absensi-form button {
            padding: 10px 20px;
            background: linear-gradient(to right, #64b5f6, #81d4fa);
            color: #0d47a1;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
        }

        .search-form button:hover, .absensi-form button:hover {
            background: linear-gradient(to right, #42a5f5, #4fc3f7);
            transform: scale(1.02);
        }

        .btn-tambah {
            padding: 10px 18px;
            background-color: #4fc3f7;
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s ease;
        }

        .btn-tambah:hover {
            background-color: #039be5;
        }

        .absensi-form {
            background: #eef4fd;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        /* Popup Modal */
.modal {
    display: none; 
    position: fixed;
    z-index: 1000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

/* Konten Modal */
.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 30px;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    font-family: 'Poppins', sans-serif;
}

/* Tombol close */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

/* Tombol Tambah */
.btn-tambah-absensi {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    margin-bottom: 20px;
}
.btn-edit {
    background-color: #3498db; /* Biru terang */
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-edit:hover {
    background-color: #2980b9; /* Biru lebih gelap saat hover */
}

    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h2>Dashboard Guru</h2>
    <ul>
        <li><a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
        <li><a href="{{ route('materi.index') }}" class="{{ request()->routeIs('materi.index') ? 'active' : '' }}"> Materi Dan Konten</a></li>
        <li><a href="{{ route('guru.menu') }}" class="{{ request()->routeIs('guru.menu') ? 'active' : '' }}"> Kuis dan Tugas</a></li>
        <li><a href="{{ route('guru.absensi.index') }}" class="{{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}"> Absensi</a></li>
        <li><a href="{{ route('guru.penilaian.index') }}" class="{{ request()->routeIs('guru.penilaian.index') ? 'active' : '' }}"> Penilaian</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main" id="main-content">
    <div class="header">
        <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
        <div class="user">👨‍🏫 {{ $user->name ?? 'Nama Guru' }}</div>
    </div>

    <div class="info-frame">
        <h4>📢 Absensi</h4>
        <p>Selamat datang di dashboard guru. Silakan kelola jadwal, nilai, dan materi Anda.</p>
    </div>

    <!-- Filter Kelas -->
    <form method="GET" action="{{ route('guru.absensi.index') }}" class="search-form">
        <select name="kelas_id">
            <option value="">-- Semua Kelas --</option>
            @foreach($kelass as $kelas)
                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                </option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
    </form>

    @if(session('success'))
        <div style="color: green; margin-top: 15px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Input Absensi -->
   <!-- Tombol Buka Modal -->
<button onclick="openModal()" class="btn-tambah-absensi">➕ Tambah Absensi</button>

<!-- Modal Popup -->
<!-- Modal Popup -->
<div id="absensiModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>➕ Input Absensi Siswa</h3>

        <form action="{{ route('guru.absensi.store') }}" method="POST">
            @csrf

            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" required>

            <label for="kelas_id">Pilih Kelas:</label>
            <select name="kelas_id" id="kelas_id" required>
                @foreach($kelass as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>

            <label for="mapel_id">Pilih Mapel:</label>
            <select name="mapel_id" id="mapel_id" required>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>

            <h4>✅ Daftar Siswa (Centang yang Hadir):</h4>
            <div style="max-height: 200px; overflow-y: auto; margin-bottom: 15px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                @foreach($siswas as $siswa)
                    <div>
                        <label>
                            <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}">
                            {{ $siswa->nama }}
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit">Simpan Absensi</button>
        </form>
    </div>
</div>
    <!-- Tabel Absensi -->
    <div class="info-frame">
        <table>
            <thead>
    <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Mapel</th>
        <th>Kelas</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @forelse($absensis as $index => $a)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $a->siswa->nama }}</td>
            <td>{{ $a->mapel->nama_mapel ?? '-' }}</td>
            <td>{{ $a->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ $a->tanggal }}</td>
            <td>{{ ucfirst($a->status) }}</td>
            <td>{{ $a->keterangan ?? '-' }}</td>
            <td>
   <button 
    class="btn-edit"
    onclick="editAbsensi(
        '{{ $a->id }}',
        '{{ $a->status }}',
        '{{ $a->keterangan }}'
    )">
    ✏️ Edit
</button>
</td>
        </tr>
    @empty
        <tr><td colspan="8" class="no-data">Belum ada data absensi.</td></tr>
    @endforelse
</tbody>
<!-- Modal Edit Absensi -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>✏️ Edit Status Kehadiran</h3>
        <form method="POST" action="{{ route('guru.absensi.update') }}">
            @csrf
            <input type="hidden" name="absensi_id" id="edit_absensi_id">

            <select name="status" id="edit_status" required>
                <option value="">Status Kehadiran</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpa</option>
            </select>

            <input type="text" name="keterangan" id="edit_keterangan" placeholder="Keterangan (opsional)">
            <button type="submit">Update Absensi</button>
        </form>
    </div>
</div>
<!-- Footer -->
<footer>
    &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.
</footer>
<script>
    function openModal() {
        document.getElementById('absensiModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('absensiModal').style.display = 'none';
    }

    // Tutup modal jika klik di luar area modal
    window.onclick = function(event) {
        const modal = document.getElementById('absensiModal');
        if (event.target === modal) {
            closeModal();
        }
    }
  function toggleFullscreenDashboard() {
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('main-content').classList.toggle('fullscreen');
    document.getElementById('footer').classList.toggle('fullscreen');
  }
</script>
<script>
    function editAbsensi(id, status, keterangan) {
        // Isi data ke form modal edit
        document.getElementById('edit_absensi_id').value = id;
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_keterangan').value = keterangan;

        // Tampilkan modal edit
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Tutup modal saat klik di luar area
    window.onclick = function(event) {
        const addModal = document.getElementById('absensiModal');
        const editModal = document.getElementById('editModal');
        if (event.target === addModal) closeModal();
        if (event.target === editModal) closeEditModal();
    }
</script>
</body>
</html>

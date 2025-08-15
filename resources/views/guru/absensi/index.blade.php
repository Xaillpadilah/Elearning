<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Absensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/adminguru.css'])
    <style>
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
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Popup Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
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
            background-color: #695ff4ff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-edit {
            background-color: #3498db;
            /* Biru terang */
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
            background-color: #2980b9;
            /* Biru lebih gelap saat hover */
        }

        /* Font dan Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }



        /* Tombol Tambah Absensi */
        .btn-tambah-absensi {
            background-color: #1488e6ff;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-tambah-absensi:hover {
            background-color: #2515b5ff;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 40px;
        }

        /* Modal Content */
        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 30px;
            border: 1px solid #ddd;
            width: 60%;
            max-width: 800px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Animasi Muncul Modal */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tombol Close */
        .close {
            color: #888;
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 26px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #e74c3c;
        }

        /* Judul Modal */
        .modal-content h3 {
            margin-bottom: 25px;
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
        }

        .modal-content h4 {
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #34495e;
        }

        /* Form */
        form label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        form input[type="date"],
        form select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            background-color: #fafafa;
        }

        /* Daftar Siswa sebagai Tabel */
        .siswa-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #fff;
            padding: 0;
            margin-top: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .siswa-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .siswa-list th,
        .siswa-list td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .siswa-list th {
            background-color: #f5f5f5;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .siswa-list tr:hover {
            background-color: #f9f9f9;
        }

        form input[type="checkbox"] {
            margin-right: 8px;
            transform: scale(1.1);
        }

        /* Tombol Simpan */
        form button[type="submit"] {
            margin-top: 25px;
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button[type="submit"]:hover {
            background-color: #2980b9;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .modal-content {
                width: 80%;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>Dashboard Guru</h2>
        <ul>
            <li><a href="{{ route('guru.dashboard') }}"
                    class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
            <li><a href="{{ route('materi.index') }}"
                    class="{{ request()->routeIs('materi.index') ? 'active' : '' }}">📚 Materi dan Konten</a></li>
            <li><a href="{{ route('guru.menu') }}" class="{{ request()->routeIs('guru.menu') ? 'active' : '' }}">📝 Kuis
                    dan Tugas</a></li>
            <li><a href="{{ route('guru.absensi.index') }}"
                    class="{{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}">🗓️ Absensi</a></li>
            <li><a href="{{ route('guru.penilaian.index') }}"
                    class="{{ request()->routeIs('guru.penilaian.index') ? 'active' : '' }}">📊 Penilaian</a></li>
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
            <p>Selamat datang di dashboard guru. Silakan kelola Absensi Sesuai kelas .</p>
        </div>



        @if(session('success'))
            <div style="color: green; margin-top: 15px; font-weight: 600;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Buka Modal -->
        <button onclick="openModal()" class="btn-tambah-absensi">➕ Tambah Absensi</button>

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
                    <div
                        style="max-height: 300px; overflow-y: auto; margin-bottom: 15px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                        <table style="width: 100%;">
                            <tbody id="siswa-list">
                                <tr>
                                    <td colspan="3" style="text-align:center; color:gray;">Pilih kelas untuk melihat
                                        siswa</td>
                                </tr>
                            </tbody>
                        </table>
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
                                <button class="btn-edit" onclick="editAbsensi(
                                            '{{ $a->id }}',
                                            '{{ $a->status }}',
                                            '{{ $a->keterangan }}'
                                        )">
                                    ✏️ Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="no-data">Belum ada data absensi.</td>
                        </tr>
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

                            <input type="text" name="keterangan" id="edit_keterangan"
                                placeholder="Keterangan (opsional)">
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
                    window.onclick = function (event) {
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
                    window.onclick = function (event) {
                        const addModal = document.getElementById('absensiModal');
                        const editModal = document.getElementById('editModal');
                        if (event.target === addModal) closeModal();
                        if (event.target === editModal) closeEditModal();
                    }
                </script>
                <script>
                    function openModal() {
                        document.getElementById("absensiModal").style.display = "block";
                    }

                    function closeModal() {
                        document.getElementById("absensiModal").style.display = "none";
                    }

                    // Event ketika kelas dipilih
                    document.getElementById('kelas_id').addEventListener('change', function () {
                        let kelasId = this.value;
                        let siswaList = document.getElementById('siswa-list');

                        if (!kelasId) {
                            siswaList.innerHTML = '<tr><td colspan="3" style="text-align:center;">Pilih kelas terlebih dahulu</td></tr>';
                            return;
                        }

                        siswaList.innerHTML = '<tr><td colspan="3" style="text-align:center;">Memuat data siswa...</td></tr>';

                        // URL di-generate langsung dari Laravel route
                        let baseUrl = `{{ route('guru.absensi.siswa', '') }}`;
                        let fullUrl = `${baseUrl}/${kelasId}`;

                        fetch(fullUrl)
                            .then(response => {
                                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                                return response.json();
                            })
                            .then(data => {
                                siswaList.innerHTML = '';
                                if (data.length === 0) {
                                    siswaList.innerHTML = '<tr><td colspan="3" style="text-align:center; color:red;">Tidak ada siswa di kelas ini</td></tr>';
                                    return;
                                }
                                data.forEach((siswa, index) => {
                                    siswaList.innerHTML += `
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="width: 30px; text-align: center;">${index + 1}</td>
                        <td style="text-align: left;">${siswa.nama}</td>
                        <td style="width: 30px; text-align: right;">
                            <input type="checkbox" name="siswa_ids[]" value="${siswa.id}">
                        </td>
                    </tr>
                `;
                                });
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                                siswaList.innerHTML = '<tr><td colspan="3" style="text-align:center; color:red;">Gagal memuat data siswa</td></tr>';
                            });
                    });
                </script>
</body>

</html>
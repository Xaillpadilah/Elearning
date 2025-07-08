<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Siswa - Admin</title>
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
    }
    .sidebar h2 { color: #4a148c; font-size: 24px; font-weight: 700; margin-bottom: 30px; }
    .sidebar ul { list-style: none; padding: 0; }
    .sidebar ul li { margin: 14px 0; }
    .sidebar ul li a {
      text-decoration: none;
      color: #222;
      padding: 10px 14px;
      display: block;
      border-radius: 10px;
      transition: background 0.3s;
    }
    .sidebar ul li a:hover,
    .sidebar ul li a.active {
      background: linear-gradient(to right, #d1c4e9, #bbdefb);
      color: #6a1b9a;
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
      background: #fff;
      border: 2px solid #c5cae9;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
    }
    .actions {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
    }
    .actions a, .actions button, .actions input[type="file"] {
      font-size: 14px;
      padding: 10px 14px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      color: white;
    }
    .btn-tambah { background: linear-gradient(to right, #81c784, #43a047); }
    .btn-ekspor { background: linear-gradient(to right, #64b5f6, #2196f3); }
    .btn-impor { background: linear-gradient(to right, #ffb74d, #f57c00); color: white; }
    .btn-edit {
      background: linear-gradient(to right, #4fc3f7, #0288d1);
      color: white;
      padding: 8px 14px;
      border-radius: 8px;
      border: none;
      font-size: 14px;
      cursor: pointer;
    }
    .btn-edit:hover {
      background: linear-gradient(to right, #0288d1, #0277bd);
    }
    .search-form {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }
    .search-form input {
      padding: 10px;
      flex: 1;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .search-form button {
      padding: 10px 20px;
      background: linear-gradient(to right, #64b5f6, #81d4fa);
      color: #0d47a1;
      border: none;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    table thead {
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
    }
    table th, table td {
      padding: 12px 16px;
      text-align: left;
      font-size: 14px;
    }
    table th { color: #0d47a1; }
    table tbody tr:nth-child(even) { background-color: #f3f4f6; }
    .no-data {
      text-align: center;
      padding: 20px;
      font-style: italic;
      color: #888;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 99;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      width: 400px;
    }
    .modal-content h3 {
      margin-top: 0;
      color: #4a148c;
    }
    .modal-content input {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .modal-content button {
      background: linear-gradient(to right, #4fc3f7, #0288d1);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
    }
    .hidden { display: none !important; }
    .fullscreen { margin-left: 0 !important; }
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
    }
    .fullscreen footer {
      left: 0;
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Dashboard Admin</h2>
    <ul>
      <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
      <li><a href="{{ route('admin.guru') }}">👨‍🏫 Data Guru</a></li>
      <li><a href="{{ route('admin.siswa') }}" class="active">👥 Data Siswa</a></li>
      <li><a href="{{ route('admin.kelas') }}">🏫 Kelas</a></li>
      <li><a href="{{ route('admin.mapel') }}">📘 Mata Pelajaran</a></li>
      <li><a href="{{ route('admin.pengumuman') }}">📢 Pengumuman</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
      <div class="user">🛡️ {{ auth()->user()->name ?? 'Admin' }}</div>
    </div>

    <div class="info-frame">
      <h4>👥 Data Siswa</h4>
      <p>Berikut adalah daftar siswa yang terdaftar dalam sistem.</p>
    </div>

    <div class="actions">
      <button class="btn-tambah" onclick="document.getElementById('modalTambahSiswa').style.display='flex'">➕ Tambah Siswa</button>
      <a href="{{ route('admin.siswa.export') }}" class="btn-ekspor">📤 Ekspor Excel</a>
      <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px;">
        @csrf
        <input type="file" name="file" required class="btn-impor" style="background: white; color: black;">
        <button type="submit" class="btn-impor">📥 Impor Excel</button>
      </form>
    </div>

    <form action="{{ route('admin.siswa') }}" method="GET" class="search-form">
      <input type="text" name="search" placeholder="Cari siswa..." value="{{ $search ?? '' }}">
      <button type="submit">🔍 Cari</button>
    </form>

    @if($siswas->count())
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>NISN</th>
            <th>Kelas</th>
            <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($siswas as $index => $siswa)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $siswa->nama }}</td>
          <td>{{ $siswa->nisn }}</td>
          <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
          <td>{{ $siswa->email }}</td>
         <td style="display: flex; gap: 6px;">
  <button class="btn-edit" onclick="openEditModal({{ $siswa->id }}, '{{ $siswa->nama }}', '{{ $siswa->nisn }}', '{{ $siswa->kelas_id }}', '{{ $siswa->email }}')">✏️ Edit</button>
  
  <button class="btn-delete" onclick="openDeleteModal({{ $siswa->id }})">🗑️ Hapus</button>
</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
      <div class="info-frame no-data">Tidak ada data siswa ditemukan.</div>
    @endif
  </div>

  <!-- Modal Tambah -->
 @include('admin.siswa.creates')
@include('admin.siswa.delete')
  
  <!-- Modal Edit -->
@include('admin.siswa.edits')

  <footer id="footer">
    &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Dashboard Admin.
  </footer>

  <script>
    function toggleFullscreenDashboard() {
      document.querySelector('.sidebar').classList.toggle('hidden');
      document.querySelector('.main').classList.toggle('fullscreen');
    }

    function openEditModal(id, nama, nisn, kelas, email) {
      const modal = document.getElementById('modalEditSiswa');
      modal.style.display = 'flex';
      document.getElementById('edit-nama').value = nama;
      document.getElementById('edit-nisn').value = nisn;
      document.getElementById('edit-kelas').value = kelas;
      document.getElementById('edit-email').value = email;
      document.getElementById('formEditSiswa').action = `/admin/siswa/${id}`;
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === "Escape") {
        document.getElementById('modalEditSiswa').style.display = 'none';
        document.getElementById('modalTambahSiswa').style.display = 'none';
      }
    });

    window.onclick = function(event) {
      if (event.target === document.getElementById('modalEditSiswa') || event.target === document.getElementById('modalTambahSiswa')) {
        event.target.style.display = "none";
      }
    };
    
  </script>
</body>
</html>

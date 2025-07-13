<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Guru - Admin</title>
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
      transition: left 0.3s ease, width 0.3s ease;
    }

    .fullscreen footer {
      left: 0;
      width: 100%;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Dashboard Admin</h2>
    <ul>
      <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
      <li><a href="{{ route('admin.guru') }}" class="active">👨‍🏫 Data Guru</a></li>
      <li><a href="{{ route('admin.siswa') }}">👥 Data Siswa</a></li>
      <li><a href="{{ route('admin.kelas') }}">🏫 Kelas</a></li>
      <li><a href="{{ route('admin.mapel.index') }}">📚 Mata Pelajaran</a></li>
      <li><a href="{{ route('admin.pengumuman') }}">📢 Pengumuman</a></li>
    </ul>
  </div>

  <!-- Main -->
  <div class="main">
    <div class="header">
      <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
      <div class="user">🛡️ {{ auth()->user()->name ?? 'Admin' }}</div>
    </div>

    <div class="info-frame">
      <h4>👨‍🏫 Data Guru</h4>
      <p>Berikut adalah daftar guru yang terdaftar dalam sistem.</p>
    </div>

    <div class="actions">
      <button class="btn-tambah" onclick="document.getElementById('modalTambahGuru').style.display='flex'">➕ Tambah Guru</button>
      <a href="{{ route('admin.guru.export') }}" class="btn-ekspor">📄 Ekspor Excel</a>
      <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px;">
        @csrf
        <input type="file" name="file" required class="btn-impor" style="background: white; color: black;">
        <button type="submit" class="btn-impor">📅 Impor Excel</button>
      </form>
    </div>

    <form action="{{ route('admin.guru') }}" method="GET" class="search-form">
      <input type="text" name="search" placeholder="Cari guru..." value="{{ $search ?? '' }}">
      <button type="submit">🔍 Cari</button>
    </form>

    @if($gurus->count())
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>NIK</th>
          <th>Mengajar</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
     <tbody>
@foreach($gurus as $index => $guru)
<tr>
  <td>{{ $index + 1 }}</td>
  <td>{{ $guru->nama }}</td>
  <td>{{ $guru->nik }}</td>
  <td>
    @if($guru->mapels->count())
     {{ $guru->mapels->pluck('nama_mapel')->join(', ') }}
    @else
      -
    @endif
  </td>
  <td>{{ $guru->user->email ?? '-' }}</td>
  <td>
    <button class="btn-edit"
      onclick="openEditModal({{ $guru->id }}, '{{ $guru->nama }}', '{{ $guru->nik }}', '{{ $guru->mapels->pluck('nama_mapel')->join(', ') }}', '{{ $guru->user->email ?? '-' }}')">
      ✏️ Edit
    </button>
  </td>
</tr>
@endforeach
</tbody>
    </table>
    @else
      <div class="info-frame no-data">Tidak ada data guru ditemukan.</div>
    @endif
  </div>

  <!-- Modal Tambah Guru -->
  <div id="modalTambahGuru" class="modal">
    <div class="modal-content">
      <h3>Tambah Data Guru</h3>
      <form action="{{ route('admin.guru.store') }}" method="POST">
        @csrf
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="text" name="nik" placeholder="NIK" required>
        <input type="text" name="mengajar" placeholder="Mengajar" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">💾 Simpan</button>
      </form>
    </div>
  </div>

  <!-- Modal Edit Guru -->
  <div id="modalEditGuru" class="modal">
    <div class="modal-content">
      <h3>Edit Data Guru</h3>
      <form id="formEditGuru" method="POST">
        @csrf
        @method('PUT')
        <input type="text" id="edit-nama" name="nama" placeholder="Nama" required>
        <input type="text" id="edit-nik" name="nik" placeholder="NIK" required>
        <input type="text" id="edit-mengajar" name="mengajar" placeholder="Mengajar" required>
        <input type="email" id="edit-email" name="email" placeholder="Email" required>
        <button type="submit">💾 Simpan Perubahan</button>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer id="footer">
    &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Dashboard Admin.
  </footer>

  <script>
    function toggleFullscreenDashboard() {
      const sidebar = document.querySelector('.sidebar');
      const main = document.querySelector('.main');
      const button = document.querySelector('.fullscreen-btn');
      sidebar.classList.toggle('hidden');
      main.classList.toggle('fullscreen');
      button.textContent = sidebar.classList.contains('hidden') ? '☰' : '☰';
    }
    function openEditModal(id, nama, nik, mengajar, email) {
      const modal = document.getElementById('modalEditGuru');
      modal.style.display = 'flex';
      document.getElementById('edit-nama').value = nama;
      document.getElementById('edit-nik').value = nik;
      document.getElementById('edit-mengajar').value = mengajar;
      document.getElementById('edit-email').value = email;
      document.getElementById('formEditGuru').action = `/admin/guru/${id}`;
    }
    document.addEventListener('keydown', function(e) {
      if (e.key === "Escape") {
        document.getElementById('modalEditGuru').style.display = 'none';
        document.getElementById('modalTambahGuru').style.display = 'none';
      }
    });
    window.onclick = function(event) {
      if (event.target === document.getElementById('modalEditGuru')) {
        document.getElementById('modalEditGuru').style.display = "none";
      }
      if (event.target === document.getElementById('modalTambahGuru')) {
        document.getElementById('modalTambahGuru').style.display = "none";
      }
    };
  </script>
</body>
</html>

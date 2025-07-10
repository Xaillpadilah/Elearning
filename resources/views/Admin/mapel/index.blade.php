<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Materi & Konten Pembelajaran - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Poppins', sans-serif;
      display: flex;
      background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
      min-height: 100vh;
      color: #333;
      transition: all 0.3s ease;
    }

    .sidebar {
      width: 250px;
      background: #fff;
      border-right: 1px solid #ddd;
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      overflow-y: auto;
      transition: all 0.3s ease;
    }

    .sidebar h2 {
      color: #4a148c;
      font-size: 22px;
      margin-bottom: 30px;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      margin: 10px 0;
    }

    .sidebar ul li a {
      text-decoration: none;
      display: block;
      padding: 10px 14px;
      color: #333;
      border-radius: 8px;
      transition: 0.3s;
    }

    .sidebar ul li a:hover,
    .sidebar ul li a.active {
      background: linear-gradient(to right, #d1c4e9, #bbdefb);
      color: #4a148c;
    }

    .main {
      margin-left: 250px;
      padding: 30px 40px 80px;
      flex: 1;
      transition: all 0.3s ease;
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
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      color: #0d47a1;
      font-weight: 500;
    }

    .user {
      background: #e0f7fa;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: 600;
      color: #006064;
    }

    .info-frame {
      background: #fff;
      border: 2px solid #c5cae9;
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 20px;
    }

    .info-frame h4 {
      margin-bottom: 8px;
      color: #4a148c;
    }

    .actions {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
    }

    .actions button,
    .actions a,
    .actions input[type="file"] {
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 500;
      color: white;
      text-decoration: none;
    }

    .btn-tambah { background: linear-gradient(to right, #81c784, #43a047); }
    .btn-ekspor { background: linear-gradient(to right, #64b5f6, #2196f3); }
    .btn-impor { background: linear-gradient(to right, #ffb74d, #f57c00); }

    .search-form {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .search-form input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .search-form button {
      background: linear-gradient(to right, #64b5f6, #81d4fa);
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      color: #0d47a1;
      cursor: pointer;
      font-weight: 500;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    table thead {
      background: linear-gradient(to right, #c5cae9, #b2ebf2);
    }

    table th, table td {
      padding: 14px 16px;
      text-align: left;
      font-size: 14px;
    }

    table th {
      color: #0d47a1;
    }

    table tbody tr:nth-child(even) {
      background: #f3f4f6;
    }

    .btn-edit {
      background: linear-gradient(to right, #4fc3f7, #0288d1);
      border: none;
      color: white;
      padding: 8px 14px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 13px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 12px;
      width: 400px;
    }

    .modal-content h3 {
      margin-bottom: 16px;
      color: #4a148c;
    }

    .modal-content input,
    .modal-content select {
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
      float: right;
      cursor: pointer;
    }

    footer {
      position: fixed;
      bottom: 0;
      left: 250px;
      width: calc(100% - 250px);
      background: #eceff1;
      text-align: center;
      padding: 12px;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    /* COLLAPSED SIDEBAR MODE */
    body.sidebar-collapsed .sidebar {
      display: none;
    }

    body.sidebar-collapsed .main {
      margin-left: 0;
    }

    body.sidebar-collapsed footer {
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
      <li><a href="{{ route('admin.siswa') }}">👥 Data Siswa</a></li>
      <li><a href="{{ route('admin.kelas') }}">🏫 Data Kelas</a></li>
      <li><a href="{{ route('admin.mapel.index') }}" class="active">📘 Materi</a></li>
      <li><a href="{{ route('admin.pengumuman') }}">📢 Pengumuman</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <button class="fullscreen-btn" onclick="toggleSidebar()">☰</button>
      <div class="user">🛡️ {{ $user->name ?? 'Admin' }}</div>
    </div>

    <div class="info-frame">
      <h4>📚 Materi & Konten Pembelajaran</h4>
      <p>Kelola daftar materi yang tersedia untuk siswa dan guru di sistem ini.</p>
    </div>

    <div class="actions">
      <button class="btn-tambah" onclick="document.getElementById('modalTambah').style.display='flex'">➕ Tambah Materi</button>
      <a href="{{ route('admin.mapel.export') }}" class="btn-ekspor">📤 Ekspor Excel</a>
      <form method="POST" action="{{ route('admin.mapel.import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" class="btn-impor" name="file" required>
        <button class="btn-impor">📥 Impor Excel</button>
      </form>
    </div>

    <form class="search-form" method="GET" action="{{ route('admin.mapel.index') }}">
      <input type="text" name="search" placeholder="Cari materi..." value="{{ $search ?? '' }}">
      <button type="submit">🔍 Cari</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Judul Materi</th>
          <th>Mata Pelajaran</th>
          <th>Kelas</th>
          <th>Tanggal Upload</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($materi as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $item->judul }}</td>
          <td>{{ $item->mapel }}</td>
          <td>{{ $item->kelas }}</td>
          <td>{{ \Carbon\Carbon::parse($item->uploaded_at)->format('d M Y') }}</td>
          <td>
            <form action="{{ route('admin.mapel.update', $item->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <button class="btn-edit" type="submit">✏️ Edit</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center; padding:20px;">Tidak ada data materi ditemukan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Modal Tambah -->
  <div class="modal" id="modalTambah">
    <div class="modal-content">
      <h3>Tambah Materi</h3>
      <form method="POST" action="{{ route('admin.mapel.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="judul" placeholder="Judul Materi" required>
        <input type="text" name="mapel" placeholder="Mata Pelajaran" required>
        <input type="text" name="kelas" placeholder="Kelas" required>
        <input type="file" name="file" required>
        <button type="submit">💾 Simpan</button>
      </form>
    </div>
  </div>

  <footer>
    &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Kelola Materi Pembelajaran.
  </footer>

  <script>
    function toggleSidebar() {
      document.body.classList.toggle('sidebar-collapsed');
    }

    window.onclick = function(e) {
      const modal = document.getElementById("modalTambah");
      if (e.target == modal) modal.style.display = "none";
    }
  </script>
</body>
</html>

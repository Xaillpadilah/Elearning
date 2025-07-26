@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Kelas {{ $kelas->nama_kelas }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/adminguru.css'])
</head>
{{-- Tambahkan style di bagian atas file (atau dalam @section('style') jika pakai layout) --}}
<style>
 <style>
  /* ===== LAYOUT & GENERAL ===== */
  body {
    font-family: 'Poppins', sans-serif;
    background: #f1f3f6;
    margin: 0;
    padding: 0;
    color: #333;
  }

  
  .main {
    margin-left: 240px;
    padding: 30px;
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
  }

  .header button {
    font-size: 20px;
    background: none;
    border: none;
    cursor: pointer;
  }

  .user {
    font-weight: 600;
  }

  .info-frame {
    background: #ffffff;
    border: 1px solid #ddd;
    padding: 16px;
    border-radius: 10px;
    margin-bottom: 24px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  }

  .info-frame.success {
    background-color: #e8f5e9;
    border-color: #a5d6a7;
    color: #2e7d32;
  }

  .info-frame.no-data {
    text-align: center;
    font-style: italic;
    color: #777;
  }

  /* ===== FORM FLOATING CARD ===== */
  .floating-card {
    max-width: 600px;
    margin: 40px auto;
    padding: 30px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
  }

  .floating-card h3 {
    margin-bottom: 20px;
    font-weight: 600;
    font-size: 18px;
    color: #333;
  }

  .floating-card form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #444;
    font-size: 14px;
  }

  .floating-card form input[type="text"],
  .floating-card form select {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background: #f9f9fc;
    transition: all 0.2s ease;
  }

  .floating-card form input:focus,
  .floating-card form select:focus {
    border-color: #4fc3f7;
    background: #fff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(79, 195, 247, 0.15);
  }

  .floating-card form button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(to right, #43a047, #2e7d32);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .floating-card form button:hover {
    background: linear-gradient(to right, #66bb6a, #388e3c);
    transform: scale(1.01);
  }

  /* ===== TABLE STYLING ===== */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    background: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    border-radius: 12px;
    overflow: hidden;
  }

  table thead {
    background-color: #6a1b9a;
    color: white;
  }

  table th,
  table td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  table tbody tr:hover {
    background-color: #f3e5f5;
  }

  table a {
    color: #1976d2;
    text-decoration: none;
  }

  table a:hover {
    text-decoration: underline;
  }

  /* ===== BUTTON KEMBALI ===== */
  .btn-kembali {
    display: inline-block;
    padding: 10px 16px;
    background: #ccc;
    border-radius: 8px;
    color: #333;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.3s;
  }

  .btn-kembali:hover {
    background: #b0bec5;
  }

  /* ===== RESPONSIVE (Optional) ===== */
  @media (max-width: 768px) {
    .main {
      margin-left: 0;
      padding: 20px;
    }

    .sidebar {
      position: static;
      width: 100%;
      height: auto;
    }
  }
  .btn-tambah-jadwal {
    background-color: #4CAF50;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-bottom: 10px;
  }

  .floating-card {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    z-index: 1000;
    padding: 20px;
    border-radius: 12px;
    width: 400px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .close-btn {
    background-color: transparent;
    border: none;
    font-size: 18px;
    cursor: pointer;
  }

  .floating-card form div {
    margin-bottom: 12px;
  }

  .floating-card form input,
  .floating-card form select {
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
  }

  .floating-card form button[type="submit"] {
    background-color: #007BFF;
    color: white;
    padding: 10px 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
  }
  /* Tombol Tambah Jadwal */
  .btn-tambah-jadwal {
    padding: 8px 14px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    margin-bottom: 16px;
  }

  .btn-tambah-jadwal:hover {
    background-color: #45a049;
  }

  /* Floating Card */
  .floating-card {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 350px;
    background-color: #fff;
    padding: 20px 24px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    z-index: 9999;
  }

  .floating-card .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
  }

  .floating-card h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
  }

  .close-btn {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    color: #333;
  }

  .floating-card form div {
    margin-bottom: 12px;
  }

  .floating-card form label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 4px;
  }

  .floating-card form input,
  .floating-card form select {
    width: 100%;
    padding: 6px 8px;
    font-size: 13px;
    border: 1px solid #ccc;
    border-radius: 6px;
  }

  .floating-card form button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
  }

  .floating-card form button[type="submit"]:hover {
    background-color: #0069d9;
  }

  /* Scrollable Table */
  .tabel-jadwal-container {
    overflow-x: auto;
  }

  .tabel-jadwal-container table {
    width: 100%;
    min-width: 600px;
    border-collapse: collapse;
    font-size: 13px;
  }

  .tabel-jadwal-container th,
  .tabel-jadwal-container td {
    border: 1px solid #ddd;
    padding: 6px 10px;
    text-align: left;
  }

  .tabel-jadwal-container th {
    background-color: #f8f8f8;
    font-weight: 600;
  }
  .form-row {
  display: flex;
  gap: 16px;
  margin-bottom: 16px;
  flex-wrap: wrap;
}

.form-group {
  flex: 1 1 45%;
}

.form-group label {
  display: block;
  margin-bottom: 4px;
  font-size: 13px;
  font-weight: 500;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 8px 10px;
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 6px;
}
.form-group {
  flex: 1 1 30%;
}
.btn-kembali {
  display: inline-block;
  padding: 10px 16px;
  background: #ccc;
  border-radius: 8px;
  color: #333;
  text-decoration: none;
  font-weight: 600;
  transition: background 0.3s;
  margin-top: 20px;
  margin-bottom: 16px; /* Tambahan */
}
</style>

<body>
<div class="sidebar">
  <h2>Dashboard Admin</h2>
  <ul>
    <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('admin.guru') }}">Data Guru</a></li>
    <li><a href="{{ route('admin.siswa') }}">👥 Data Siswa</a></li>
    <li><a href="{{ route('admin.kelas') }}" class="active">Data Kelas Jadwal</a></li>
    <li><a href="{{ route('materi.index') }}">Materi Dan Konten</a></li>
    <li><a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a></li>
  </ul>
</div>

<div class="main">
  <div class="header">
    <button onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">🛡️ {{ auth()->user()->name ?? 'Admin' }}</div>
  </div>

  <div class="info-frame">
    <h4>📆 Jadwal Pelajaran - {{ $kelas->nama_kelas }}</h4>
    <p>Berikut adalah jadwal pelajaran untuk kelas ini.</p>
  </div>
 {{-- Tombol Kembali --}}
  <div style="margin-top: 20px;">
    <a href="{{ route('admin.kelas') }}" class="btn-kembali">🔙 Kembali ke Data Kelas</a>
  </div>

  @if (session('success'))
    <div class="info-frame success">
      ✅ {{ session('success') }}
    </div>

  @endif
 {{-- Tombol Tambah Jadwal --}}
<button onclick="toggleForm()" class="btn-tambah-jadwal">➕ Tambah Jadwal</button>
{{-- Form Tambah Jadwal (Floating Card) --}}
<div id="formTambahJadwal" class="floating-card" style="display: none;">
  <div class="card-header">
    <h3>➕ Tambah Jadwal</h3>
    <button class="close-btn" onclick="toggleForm()">✖</button>
  </div>
  <form action="{{ route('admin.kelas.jadwal.store') }}" method="POST">
    @csrf
    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

    <div class="form-row">
      <div class="form-group">
        <label>Mata Pelajaran</label>
        <select name="mapel_id" required>
          <option value="">-- Pilih Mapel --</option>
          @foreach($mapels as $mapel)
            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Guru</label>
        <select name="guru_id" required>
          <option value="">-- Pilih Guru --</option>
          @foreach($gurus as $guru)
            <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Hari</label>
        <input type="text" name="hari" required placeholder="Contoh: Senin">
      </div>

      <div class="form-group">
        <label>Jam</label>
        <input type="text" name="jam" required placeholder="Contoh: 08.00 - 09.30">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Tipe Ruangan</label>
        <select name="tipe_ruangan" id="tipe_ruangan" required onchange="toggleRuanganField()">
          <option value="">-- Pilih Tipe --</option>
          <option value="online">Online</option>
          <option value="offline">Offline</option>
        </select>
      </div>

      <div class="form-group" id="ruanganField" style="display: none;">
        <label>Link Ruangan / Nama Ruangan</label>
        <input type="text" name="ruangan" placeholder="https://meet.google.com/... atau Ruang A1">
      </div>
    </div>

    <button type="submit">Simpan Jadwal</button>
  </form>
</div>

  {{-- Tabel Jadwal --}}
  @if($jadwals->count())
  <div class="table-container">
    <table class="jadwal-table">
      <thead>
        <tr>
          <th>Hari</th>
          <th>Jam</th>
          <th>Mata Pelajaran</th>
          <th>Guru</th>
          <th>Tipe</th>
          <th>Ruangan/Link</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($jadwals as $jadwal)
        <tr>
          <td>{{ $jadwal->hari }}</td>
          <td>{{ $jadwal->jam }}</td>
          <td>{{ $jadwal->mapel->nama_mapel ?? '-' }}</td>
          <td>{{ $jadwal->guru->nama ?? '-' }}</td>
          <td>{{ ucfirst($jadwal->tipe_ruangan) }}</td>
          <td>
            @if ($jadwal->tipe_ruangan == 'online')
              <a href="{{ $jadwal->ruangan }}" target="_blank">{{ $jadwal->ruangan }}</a>
            @else
              {{ $jadwal->ruangan ?? '-' }}
            @endif
          </td>
          <td>
<a href="javascript:void(0);" class="btn-edit" onclick="editJadwal({{ $jadwal->toJson() }})">✏️ Edit</a>
            <form action="{{ route('admin.kelas.jadwal.destroy', $jadwal->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-delete">🗑️ Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@else
  <div class="info-frame no-data">Tidak ada jadwal untuk kelas ini.</div>
@endif
 
{{-- Form Edit Jadwal (Floating Card) --}}
<div id="formEditJadwal" class="floating-card" style="display: none;">
  <div class="card-header">
    <h3>✏️ Edit Jadwal</h3>
    <button class="close-btn" onclick="toggleFormEdit()">✖</button>
  </div>
   <form id="editJadwalForm" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="kelas_id" id="edit_kelas_id">

    <div class="form-row">
      <div class="form-group">
        <label>Mata Pelajaran</label>
        <select name="mapel_id" id="edit_mapel_id" required>
          <option value="">-- Pilih Mapel --</option>
          @foreach($mapels as $mapel)
            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Guru</label>
        <select name="guru_id" id="edit_guru_id" required>
          <option value="">-- Pilih Guru --</option>
          @foreach($gurus as $guru)
            <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Hari</label>
        <input type="text" name="hari" id="edit_hari" required>
      </div>

      <div class="form-group">
        <label>Jam</label>
        <input type="text" name="jam" id="edit_jam" required>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Tipe Ruangan</label>
        <select name="tipe_ruangan" id="edit_tipe_ruangan" required onchange="toggleEditRuanganField()">
          <option value="">-- Pilih Tipe --</option>
          <option value="online">Online</option>
          <option value="offline">Offline</option>
        </select>
      </div>

      <div class="form-group" id="edit_ruangan_field" style="display: none;">
        <label>Link Ruangan / Nama Ruangan</label>
        <input type="text" name="ruangan" id="edit_ruangan">
      </div>
    </div>

    <button type="submit">Update Jadwal</button>
  </form>
</div>
<footer>&copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.</footer>
<script>
  function toggleFullscreenDashboard() {
    document.querySelector('.sidebar').classList.toggle('hidden');
    document.querySelector('.main').classList.toggle('fullscreen');
  }

  function toggleRuanganField() {
    const tipe = document.getElementById('tipe_ruangan').value;
    const field = document.getElementById('ruanganField');
    field.style.display = tipe === 'online' ? 'block' : 'none';
  }

  document.addEventListener('DOMContentLoaded', function () {
    toggleRuanganField();
  });
</script>
<script>
  function toggleRuanganField() {
    const tipe = document.getElementById('tipe_ruangan').value;
    const field = document.getElementById('ruanganField');
    field.style.display = tipe ? 'block' : 'none';
  }
</script>
<script>
  function toggleForm() {
    const form = document.getElementById('formTambahJadwal');
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
  }

  function toggleRuanganField() {
    const tipe = document.getElementById("tipe_ruangan").value;
    const field = document.getElementById("ruanganField");
    field.style.display = (tipe === "online" || tipe === "offline") ? "block" : "none";
  }
</script>
<script>
  function editJadwal(jadwal) {
    // Tampilkan form edit
    toggleFormEdit();

    // Set nilai form
    document.getElementById('edit_kelas_id').value = jadwal.kelas_id;
    document.getElementById('edit_mapel_id').value = jadwal.mapel_id;
    document.getElementById('edit_guru_id').value = jadwal.guru_id;
    document.getElementById('edit_hari').value = jadwal.hari;
    document.getElementById('edit_jam').value = jadwal.jam;
    document.getElementById('edit_tipe_ruangan').value = jadwal.tipe_ruangan;
    document.getElementById('edit_ruangan').value = jadwal.ruangan ?? '';

    // Tampilkan atau sembunyikan field ruangan sesuai tipe
    toggleEditRuanganField();

    // Set action form edit
    const form = document.getElementById('editJadwalForm');
    form.action = `/admin/kelas/jadwal/${jadwal.id}`;
  }

  function toggleFormEdit() {
    const form = document.getElementById('formEditJadwal');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
  }

  function toggleEditRuanganField() {
    const tipe = document.getElementById('edit_tipe_ruangan').value;
    const field = document.getElementById('edit_ruangan_field');
    if (tipe === 'online' || tipe === 'offline') {
      field.style.display = 'block';
    } else {
      field.style.display = 'none';
      document.getElementById('edit_ruangan').value = '';
    }
  }
</script>

</body>
</html>

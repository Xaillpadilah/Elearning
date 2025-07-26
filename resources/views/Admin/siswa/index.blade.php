@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Siswa - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/adminguru.css'])
  <style>
    
    /* ========== RESPONSIVE ========== */
    @media (max-width: 1024px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .main { margin-left: 0; }
      footer { left: 0; width: 100%; }
    }

    @media (max-width: 768px) {
      .cards .row, .cards .row-two {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
<div class="sidebar">
  <h2>Dashboard Admin</h2>
  <ul>
    <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('admin.guru') }}">    Data Guru</a></li>
    <li><a href="{{ route('admin.siswa') }}" class="active">   Data Siswa</a></li>
    <li><a href="{{ route('admin.kelas') }}">   Data Kelas Jadwal</a></li>
    <li><a href="{{ route('materi.index') }}">    Materi dan Konten</a></li>
    <li><a href="{{ route('admin.pengumuman.index') }}">  Pengumuman</a></li>
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

  @if(session('success'))
    <div class="info-frame" style="color: green;">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="info-frame" style="color: red;">{{ session('error') }}</div>
  @endif

  <div class="actions">
    <button class="btn-tambah" onclick="document.getElementById('modalTambahSiswa').style.display='flex'">➕ Tambah Siswa</button>
    <a href="{{ route('admin.siswa.export') }}" class="btn-ekspor">📄 Ekspor Excel</a>
    <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" class="form-import">
      @csrf
      <input type="file" name="file" required>
      <button type="submit">📅 Impor Excel</button>
    </form>
  </div>

  <form action="{{ route('admin.siswa') }}" method="GET" class="search-form">
    <input type="text" name="search" placeholder="Cari siswa..." value="{{ request('search') }}">
    <button type="submit">🔍 Cari</button>
  </form>

  @if($siswas->count())
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NISN</th>
        <th>Jenis Kelamin</th>
        <th>Kelas</th>
        <th>Email</th>
        <th>Orang Tua</th>
        <th>No. HP</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($siswas as $index => $siswa)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $siswa->nama }}</td>
        <td>{{ $siswa->nisn }}</td>
        <td>{{ $siswa->jenis_kelamin }}</td>
        <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        <td>{{ $siswa->user->email ?? '-' }}</td>
        <td>{{ $siswa->orangtua->nama ?? '-' }}</td>
        <td>{{ $siswa->orangtua->nomor_hp ?? '-' }}</td>
        <td>
          <button class="btn-edit" onclick='openEditModal(@json($siswa))'>✏️ Edit</button>
          <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">🗑️ Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <div class="info-frame no-data">Tidak ada data siswa ditemukan.</div>
  @endif
</div>

<!-- Modal Tambah Siswa -->
<div id="modalTambahSiswa" class="modal">
  <div class="modal-content">
    <h3>Tambah Data Siswa</h3>
    <form action="{{ route('admin.siswa.store') }}" method="POST">
      @csrf
      <label>Nama</label>
      <input type="text" name="nama" required>

      <label>NISN</label>
      <input type="text" name="nisn" required>

      <label>Jenis Kelamin</label>
      <select name="jenis_kelamin" required>
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>

      <label>Kelas</label>
      <select name="kelas_id" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach($kelas as $k)
          <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
        @endforeach
      </select>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Nama Orang Tua</label>
      <input type="text" name="nama_ortu" required>

      <label>Nomor HP Orang Tua</label>
      <input type="text" name="nomor_hp" required>

      <button type="submit" class="btn-simpan-tambah">💾 Simpan</button>
    </form>
  </div>
</div>

<!-- Modal Edit Siswa (dynamic via JS) -->
<div id="modalEditSiswa" class="modal">
  <div class="modal-content">
    <h3>Edit Data Siswa</h3>
    <form id="formEditSiswa" method="POST">
      @csrf
      @method('PUT')
      <label>Nama</label>
      <input type="text" name="nama" id="edit-nama" required>

      <label>NISN</label>
      <input type="text" name="nisn" id="edit-nisn" required>

      <label>Jenis Kelamin</label>
      <select name="jenis_kelamin" id="edit-jk" required>
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>

      <label>Kelas</label>
      <select name="kelas_id" id="edit-kelas" required>
        @foreach($kelas as $k)
          <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
        @endforeach
      </select>

      <label>Email</label>
      <input type="email" name="email" id="edit-email" required>

      <label>Nama Orang Tua</label>
      <input type="text" name="nama_ortu" id="edit-ortu" required>

      <label>Nomor HP</label>
      <input type="text" name="nomor_hp" id="edit-hp" required>

      <button type="submit" class="btn-simpan-edit">💾 Simpan Perubahan</button>
    </form>
  </div>
</div>

<script>
function toggleFullscreenDashboard() {
  document.querySelector('.sidebar').classList.toggle('hidden');
  document.querySelector('.main').classList.toggle('fullscreen');
}

function openEditModal(data) {
  document.getElementById('modalEditSiswa').style.display = 'flex';
  document.getElementById('edit-nama').value = data.nama;
  document.getElementById('edit-nisn').value = data.nisn;
  document.getElementById('edit-jk').value = data.jenis_kelamin;
  document.getElementById('edit-kelas').value = data.kelas_id;
  document.getElementById('edit-email').value = data.user?.email || '';
  document.getElementById('edit-ortu').value = data.orangtua?.nama || '';
  document.getElementById('edit-hp').value = data.orangtua?.nomor_hp || '';
  document.getElementById('formEditSiswa').action = `{{ url('/admin/siswa') }}/${data.id}`;
}

window.onclick = function(event) {
  if (event.target === document.getElementById('modalEditSiswa')) {
    document.getElementById('modalEditSiswa').style.display = "none";
  }
  if (event.target === document.getElementById('modalTambahSiswa')) {
    document.getElementById('modalTambahSiswa').style.display = "none";
  }
};

document.addEventListener('keydown', function(e) {
  if (e.key === "Escape") {
    document.getElementById('modalEditSiswa').style.display = 'none';
    document.getElementById('modalTambahSiswa').style.display = 'none';
  }
});
</script>

<footer>&copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.</footer>
</body>
</html>
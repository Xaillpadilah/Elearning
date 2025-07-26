@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Materi & Konten Pembelajaran - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/adminguru.css'])
 <style>
  .btn-edit,
  .btn-delete,
  .btn-kirim {
    width: 130px;
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: left;
  }

  .btn-edit {
    background-color: #3498db;
    color: white;
  }

  .btn-edit:hover {
    background-color: #2980b9;
  }

  .btn-delete {
    background-color: #e74c3c;
    color: white;
  }

  .btn-delete:hover {
    background-color: #c0392b;
  }

  .btn-kirim {
    background-color: #2ecc71;
    color: white;
  }

  .btn-kirim:hover {
    background-color: #27ae60;
  }
</style>
</head>
<body>
<div class="sidebar">
<h2>Dashboard {{ auth()->user()->role === 'admin' ? 'Admin' : 'Guru' }}</h2>
  <ul>
  <li><a href="{{ route(auth()->user()->role . '.dashboard') }}">🏠 Dashboard</a></li>

  @if(auth()->user()->role === 'admin')
    <li><a href="{{ route('admin.guru') }}"> Data Guru</a></li>
    <li><a href="{{ route('admin.siswa') }}"> Data Siswa</a></li>
    <li><a href="{{ route('admin.kelas') }}"> Data Kelas Jadwal</a></li>
    <li><a href="{{ route('materi.index') }}" class="{{ request()->routeIs('materi.index') ? 'active' : '' }}">  Materi Dan Konten</a></li>
    <li><a href="{{ route('admin.pengumuman.index') }}"> Pengumuman</a></li>
  @elseif(auth()->user()->role === 'guru')
    <li><a href="{{ route('materi.index') }}" class="{{ request()->routeIs('materi.index') ? 'active' : '' }}"> Materi Dan Konten</a></li>
    <li><a href="{{ route('guru.menu') }}" class="{{ request()->routeIs('guru.menu') ? 'active' : '' }}">  Kuis dan Tugas</a></li>
    <li><a href="{{ route('guru.absensi.index') }}" class="{{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}"> Absensi</a></li>
    <li><a href="{{ route('guru.penilaian.index') }}" class="{{ request()->routeIs('guru.penilaian.index') ? 'active' : '' }}"> Penilaian</a></li>
  @endif
</ul>
</div>
<div class="main">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">🛡️ {{ auth()->user()->name ?? 'Admin' }}</div>
  </div>

  <div class="info-frame">
    <h4>📘 Materi & Konten Pembelajaran</h4>
    <p>Berikut adalah daftar materi pembelajaran yang tersedia.</p>
  </div>

  @if(session('success'))
    <div class="info-frame" style="color: green;">{{ session('success') }}</div>
  @endif

  <div class="actions">
    <button class="btn-tambah" onclick="document.getElementById('modalTambahMateri').style.display='flex'">➕ Tambah Materi</button>
  </div>

  @if($materis->count())
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Mata Pelajaran</th>
        <th>Kelas</th>
        <th>Tipe</th>
        <th>Konten</th>
        <th>Pengunggah</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($materis as $index => $materi)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $materi->judul }}</td>
        <td>{{ $materi->mapel->nama_mapel }}</td>
        <td>{{ $materi->kelas->nama_kelas }}</td>
        <td>{{ ucfirst($materi->tipe_konten) }}</td>
        <td>
          @if($materi->tipe_konten === 'link')
            <a href="{{ $materi->link }}" target="_blank">🔗 Lihat</a>
          @elseif($materi->tipe_konten === 'file' || $materi->tipe_konten === 'video')
            <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank">📂 Unduh</a>
          @endif
        </td>
        <td>{{ $materi->uploader->name ?? 'Admin' }}</td>
       <td style="display: flex; flex-direction: column; gap: 6px;">
  {{-- Tombol Edit --}}
  <button type="button" class="btn-edit" onclick="openEditModal({{ $materi->id }})">✏️ Edit</button>

  {{-- Form Hapus --}}
  <form action="{{ route('materi.destroy', $materi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
    @csrf @method('DELETE')
    <button class="btn-delete">🗑️ Hapus</button>
  </form>

  {{-- Form Kirim ke Siswa (hanya untuk guru) --}}
  @if(auth()->user()->role === 'guru')
    <form action="{{ route('materi.kirim', $materi->id) }}" method="POST">
      @csrf
      <button class="btn-kirim">📤 Kirim</button>
    </form>
  @endif
</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <div class="info-frame no-data">Tidak ada data materi ditemukan.</div>
  @endif
</div>

<!-- Modal Tambah Materi -->
<div id="modalTambahMateri" class="modal">
  <div class="modal-content">
    <h3>Tambah Materi</h3>
    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <label>Judul</label>
      <input type="text" name="judul" required>

      <label>Mata Pelajaran</label>
      <select name="mapel_id" required>
        <option value="">-- Pilih Mapel --</option>
        @foreach($mapels as $mapel)
          <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
        @endforeach
      </select>

      <label>Kelas</label>
      <select name="kelas_id" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach($kelas as $kls)
          <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
        @endforeach
      </select>

      <label>Tipe Konten</label>
      <select name="tipe_konten" required onchange="toggleKontenInput(this.value)">
        <option value="">-- Pilih Tipe --</option>
        <option value="file">File</option>
        <option value="video">Video</option>
        <option value="link">Link</option>
      </select>

      <div id="fileInput" style="display:none">
        <label>Upload File</label>
        <input type="file" name="file_upload">
      </div>

      <div id="linkInput" style="display:none">
        <label>Link Konten</label>
        <input type="url" name="link">
      </div>

      <label>Deskripsi</label>
      <textarea name="deskripsi"></textarea>

      <button type="submit" class="btn-simpan-tambah">💾 Simpan</button>
    </form>
  </div>
</div>
<!-- Modal Edit Materi -->
<div id="modalEditMateri" class="modal">
  <div class="modal-content">
    <h3>Edit Materi</h3>
    <form id="formEditMateri" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')
      <label>Judul</label>
      <input type="text" name="judul" id="editJudul" required>

      <label>Mata Pelajaran</label>
      <select name="mapel_id" id="editMapel" required>
        @foreach($mapels as $mapel)
          <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
        @endforeach
      </select>

      <label>Kelas</label>
      <select name="kelas_id" id="editKelas" required>
        @foreach($kelas as $kls)
          <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
        @endforeach
      </select>

      <label>Tipe Konten</label>
      <select name="tipe_konten" id="editTipe" required onchange="toggleEditKontenInput(this.value)">
        <option value="file">File</option>
        <option value="video">Video</option>
        <option value="link">Link</option>
      </select>

      <div id="editFileInput" style="display:none">
        <label>Upload File Baru</label>
        <input type="file" name="file_upload">
      </div>

      <div id="editLinkInput" style="display:none">
        <label>Link Konten</label>
        <input type="url" name="link" id="editLink">
      </div>

      <label>Deskripsi</label>
      <textarea name="deskripsi" id="editDeskripsi"></textarea>

      <button type="submit" class="btn-simpan-tambah">💾 Simpan Perubahan</button>
    </form>
  </div>
</div>

<footer>&copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.</footer>

<script>
  function toggleFullscreenDashboard() {
    document.querySelector('.sidebar').classList.toggle('hidden');
    document.querySelector('.main').classList.toggle('fullscreen');
  }

  function toggleKontenInput(type) {
    document.getElementById('fileInput').style.display = (type === 'file' || type === 'video') ? 'block' : 'none';
    document.getElementById('linkInput').style.display = (type === 'link') ? 'block' : 'none';
  }

  window.onclick = function(event) {
    if (event.target === document.getElementById('modalTambahMateri')) {
      document.getElementById('modalTambahMateri').style.display = "none";
    }
  }
  document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
      document.getElementById('modalTambahMateri').style.display = 'none';
    }
  });
</script>
<script>
  const materis = @json($materis);

  function openEditModal(id) {
    const materi = materis.find(m => m.id === id);
    if (!materi) return;

    document.getElementById('editJudul').value = materi.judul;
    document.getElementById('editMapel').value = materi.mapel_id;
    document.getElementById('editKelas').value = materi.kelas_id;
    document.getElementById('editTipe').value = materi.tipe_konten;
    document.getElementById('editDeskripsi').value = materi.deskripsi ?? '';

    if (materi.tipe_konten === 'link') {
      document.getElementById('editLink').value = materi.link ?? '';
    }

    toggleEditKontenInput(materi.tipe_konten);

    document.getElementById('formEditMateri').action = `/admin/materi/${id}`;
    document.getElementById('modalEditMateri').style.display = 'flex';
  }

  function toggleEditKontenInput(type) {
    document.getElementById('editFileInput').style.display = (type === 'file' || type === 'video') ? 'block' : 'none';
    document.getElementById('editLinkInput').style.display = (type === 'link') ? 'block' : 'none';
  }
  
  
</script>
<script>
  // Tutup modal jika klik di luar modal (untuk Tambah Materi)
  window.onclick = function(event) {
    const modalTambah = document.getElementById('modalTambahMateri');
    const modalEdit = document.getElementById('modalEditMateri');

    if (event.target === modalTambah) {
      modalTambah.style.display = "none";
    }

    if (event.target === modalEdit) {
      modalEdit.style.display = "none";
    }
  };

  // Tutup modal jika tekan tombol ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
      const modalTambah = document.getElementById('modalTambahMateri');
      const modalEdit = document.getElementById('modalEditMateri');

      if (modalTambah) modalTambah.style.display = 'none';
      if (modalEdit) modalEdit.style.display = 'none';
    }
  });
</script>
</body>
</html>

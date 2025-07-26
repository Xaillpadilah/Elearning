@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Tugas & Kuis</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  @vite(['resources/css/tugas.css'])
</head>
<body>

<div class="main">

  <!-- Header -->
  <div class="header">
    <div class="user">🛡️ {{ auth()->user()->name }}</div>
  </div>

  <!-- Notifikasi Sukses -->
 @if(session('success'))
  <div class="info-frame" id="successAlert" style="color: green;">
    {{ session('success') }}
  </div>

  <script>
    setTimeout(() => {
      const alertBox = document.getElementById('successAlert');
      if (alertBox) {
        alertBox.style.transition = 'opacity 0.5s ease';
        alertBox.style.opacity = 0;
        setTimeout(() => alertBox.style.display = 'none', 500);
      }
    }, 3000); // hilang setelah 3 detik
  </script>
@endif
  <!-- Tombol Tambah -->
  <div class="actions">
    <button class="btn-tambah" onclick="document.getElementById('modalTambahTugas').style.display='flex'">
      ➕ Tambah Tugas
    </button>
  </div>

  <!-- Tabel Data -->
  @if($tugas->count())
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Jenis</th>
          <th>Deadline</th>
          <th>File</th>
          <th>Kelas</th>
          <th>Mapel</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tugas as $index => $t)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $t->judul }}</td>
            <td>{{ ucfirst($t->jenis) }}</td>
            <td>{{ $t->tanggal_deadline ?? '-' }}</td>
            <td>
              @if($t->file_path)
                <a href="{{ asset('storage/' . $t->file_path) }}" target="_blank">📄 Lihat</a>
              @else
                Tidak ada
              @endif
            </td>
            <td>{{ $t->relasi->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ $t->relasi->mapel->nama_mapel ?? '-' }}</td>
            <td>
              <!-- Edit -->
              <button type="button" class="btn-edit" onclick="openEditModal({{ $t->id }})">✏️</button>

              <!-- Hapus -->
              <form action="{{ route('guru.tugas.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')" style="display:inline-block">
                @csrf @method('DELETE')
                <button class="btn-delete">🗑️</button>
              </form>

              <!-- Kirim -->
              @if(!$t->dikirim)
                <form action="{{ route('tugas.kirim', $t->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Kirim tugas ini ke siswa?')">
                  @csrf @method('PUT')
                  <button type="submit" class="btn-kirim">📤 Kirim</button>
                </form>
              @else
                <span class="badge-terkirim">✅ Terkirim</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <div class="info-frame">Belum ada tugas atau kuis.</div>
  @endif

</div>

<!-- MODAL TAMBAH -->
<div id="modalTambahTugas" class="modal">
  <div class="modal-content">
    <h3>Tambah Tugas/Kuis</h3>
    <form action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <label>Judul</label>
      <input type="text" name="judul" required>

      <label>Jenis</label>
      <select name="jenis" required>
        <option value="">-- Pilih --</option>
        <option value="tugas">Tugas</option>
        <option value="kuis">Kuis</option>
      </select>

      <label>Tanggal Deadline</label>
      <input type="date" name="tanggal_deadline">

      <label>Kelas & Mapel</label>
      <select name="guru_mapel_kelas_id" required>
        <option value="">-- Pilih --</option>
        @foreach($relasi as $r)
          <option value="{{ $r->id }}">{{ $r->kelas->nama_kelas }} - {{ $r->mapel->nama_mapel }}</option>
        @endforeach
      </select>

      <label>Upload File</label>
      <input type="file" name="file_upload">

      <label>Deskripsi</label>
      <textarea name="deskripsi"></textarea>

      <button type="submit" class="btn-simpan-tambah">💾 Simpan</button>
    </form>
  </div>
</div>

<!-- MODAL EDIT -->
<div id="modalEditTugas" class="modal">
  <div class="modal-content">
    <h3>Edit Tugas/Kuis</h3>
    <form id="formEditTugas" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')

      <label>Judul</label>
      <input type="text" name="judul" id="editJudul" required>

      <label>Jenis</label>
      <select name="jenis" id="editJenis" required>
        <option value="tugas">Tugas</option>
        <option value="kuis">Kuis</option>
      </select>

      <label>Deadline</label>
      <input type="date" name="tanggal_deadline" id="editDeadline">

      <label>Kelas & Mapel</label>
      <select name="guru_mapel_kelas_id" id="editRelasi" required>
        @foreach($relasi as $r)
          <option value="{{ $r->id }}">{{ $r->kelas->nama_kelas }} - {{ $r->mapel->nama_mapel }}</option>
        @endforeach
      </select>

      <label>Upload File Baru</label>
      <input type="file" name="file_upload">

      <label>Deskripsi</label>
      <textarea name="deskripsi" id="editDeskripsi"></textarea>

      <button type="submit" class="btn-simpan-tambah">💾 Simpan Perubahan</button>
    </form>
  </div>
</div>

<!-- SCRIPT -->
<script>
  const tugasData = @json($tugas);

  function openEditModal(id) {
    const t = tugasData.find(item => item.id === id);
    if (!t) return;

    document.getElementById('editJudul').value = t.judul;
    document.getElementById('editJenis').value = t.jenis;
    document.getElementById('editDeadline').value = t.tanggal_deadline;
    document.getElementById('editRelasi').value = t.guru_mapel_kelas_id;
    document.getElementById('editDeskripsi').value = t.deskripsi ?? '';

    document.getElementById('formEditTugas').action = `/guru/tugas/${id}`;
    document.getElementById('modalEditTugas').style.display = 'flex';
  }

  // Tutup modal saat klik luar area
  window.onclick = function(event) {
    if (event.target.id === 'modalTambahTugas') {
      event.target.style.display = "none";
    }
    if (event.target.id === 'modalEditTugas') {
      event.target.style.display = "none";
    }
  };

  // Tutup modal dengan tombol ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
      document.getElementById('modalTambahTugas').style.display = 'none';
      document.getElementById('modalEditTugas').style.display = 'none';
    }
  });
</script>

</body>
</html>

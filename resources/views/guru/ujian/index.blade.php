@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Ujian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  @vite(['resources/css/tugas.css']) {{-- gunakan CSS yang sama --}}
</head>
<body>

<div class="main">
  <div class="header">
    <div class="user">🛡️ {{ auth()->user()->name }}</div>
  </div>

 
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
    }, 3000);
  </script>
@endif
  <div class="actions">
    <button class="btn-tambah" onclick="document.getElementById('modalTambahUjian').style.display='flex'">➕ Tambah Ujian</button>
  </div>

  @if($ujians->count())
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Tanggal</th>
        <th>Tipe</th>
        <th>File</th>
        <th>Kelas - Mapel</th>
        <th>Acak</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($ujians as $index => $u)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $u->judul }}</td>
        <td>{{ $u->tanggal }}</td>
        <td>{{ ucfirst(str_replace('_', ' ', $u->tipe_ujian)) }}</td>
        <td>
          @if($u->file_soal)
            <a href="{{ asset('storage/' . $u->file_soal) }}" target="_blank">📄 Lihat</a>
          @else
            Tidak ada
          @endif
        </td>
        <td>
          {{ $u->guruMapelKelas->kelas->nama_kelas ?? '-' }} - {{ $u->guruMapelKelas->mapel->nama_mapel ?? '-' }}
        </td>
        <td>{{ $u->acak_soal ? '✅' : '❌' }}</td>
        <td>
  {{-- Tombol Edit --}}
  <button type="button" class="btn-edit" onclick="editUjian({{ $u }})">✏️</button>


  {{-- Tombol Hapus --}}
  <form action="{{ route('guru.ujian.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin hapus ujian ini?')" style="display:inline-block">
    @csrf @method('DELETE')
    <button class="btn-delete">🗑️</button>
  </form>
  
  @if(!$u->status_kirim)
<form action="{{ route('guru.ujian.kirim', $u->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Kirim ujian ini ke siswa?')">
  @csrf
  @method('PUT')
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
    <div class="info-frame">Belum ada data ujian.</div>
  @endif
</div>

<!-- Modal Tambah Ujian -->
<div id="modalTambahUjian" class="modal">
  <div class="modal-content">
    <h3>Tambah Ujian</h3>
    <form method="POST" action="{{ route('guru.ujian.store') }}" enctype="multipart/form-data">
      @csrf

      <label>Judul</label>
      <input type="text" name="judul" required>

      <label>Tanggal</label>
      <input type="date" name="tanggal" required>

      <label>Tipe Ujian</label>
      <select name="tipe_ujian" required>
        <option value="pilihan_ganda">Pilihan Ganda</option>
        <option value="essai">Essai</option>
        <option value="campuran">Campuran</option>
      </select>

      <label>Mapel & Kelas</label>
      <select name="guru_mapel_kelas_id" required>
        <option value="">-- Pilih --</option>
        @foreach ($relasi as $item)
          <option value="{{ $item->id }}">
            {{ $item->mapel->nama_mapel }} - {{ $item->kelas->nama_kelas }}
          </option>
        @endforeach
      </select>

      <label>File Soal (Opsional)</label>
      <input type="file" name="file_soal" accept=".pdf,.doc,.docx">

      <label>Keterangan</label>
      <textarea name="keterangan"></textarea>

      <label>
        <input type="checkbox" name="acak_soal" value="1"> Acak Soal
      </label>

      <button type="submit" class="btn-simpan-tambah">💾 Simpan</button>
    </form>
  </div>
</div>
<!-- Modal Edit Ujian -->
<div id="modalEditUjian" class="modal">
  <div class="modal-content">
    <h3>Edit Ujian</h3>
    <form id="formEditUjian" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <label>Judul</label>
      <input type="text" name="judul" id="editJudul" required>

      <label>Tanggal</label>
      <input type="date" name="tanggal" id="editTanggal" required>

      <label>Tipe Ujian</label>
      <select name="tipe_ujian" id="editTipeUjian" required>
        <option value="pilihan_ganda">Pilihan Ganda</option>
        <option value="essai">Essai</option>
        <option value="campuran">Campuran</option>
      </select>

      <label>Mapel & Kelas</label>
      <select name="guru_mapel_kelas_id" id="editGuruMapelKelas" required>
        @foreach ($relasi as $item)
          <option value="{{ $item->id }}">
            {{ $item->mapel->nama_mapel }} - {{ $item->kelas->nama_kelas }}
          </option>
        @endforeach
      </select>

      <label>Ganti File Soal (Opsional)</label>
      <input type="file" name="file_soal" accept=".pdf,.doc,.docx">

      <label>Keterangan</label>
      <textarea name="keterangan" id="editKeterangan"></textarea>

      <label>
        <input type="checkbox" name="acak_soal" id="editAcakSoal" value="1"> Acak Soal
      </label>

      <button type="submit" class="btn-simpan-tambah">💾 Update</button>
    </form>
  </div>
</div>

<script>
  window.onclick = function(event) {
    const modal = document.getElementById('modalTambahUjian');
    if (event.target === modal) modal.style.display = "none";
  };

  document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
      document.getElementById('modalTambahUjian').style.display = 'none';
    }
  });
</script>
<script>
  function editUjian(ujian) {
    const modal = document.getElementById('modalEditUjian');
    modal.style.display = 'flex';

    // Atur data ke form
    document.getElementById('formEditUjian').action = '/guru/ujian/' + ujian.id;
    document.getElementById('editJudul').value = ujian.judul;
    document.getElementById('editTanggal').value = ujian.tanggal;
    document.getElementById('editTipeUjian').value = ujian.tipe_ujian;
    document.getElementById('editGuruMapelKelas').value = ujian.guru_mapel_kelas_id;
    document.getElementById('editKeterangan').value = ujian.keterangan ?? '';
    document.getElementById('editAcakSoal').checked = ujian.acak_soal;

    // Close on escape
    document.addEventListener('keydown', function(e) {
      if (e.key === "Escape") {
        modal.style.display = 'none';
      }
    });
  }

  // Close modal when clicking outside
  window.onclick = function(event) {
    const editModal = document.getElementById('modalEditUjian');
    if (event.target === editModal) {
      editModal.style.display = "none";
    }

    const tambahModal = document.getElementById('modalTambahUjian');
    if (event.target === tambahModal) {
      tambahModal.style.display = "none";
    }
  };
</script>
</body>
</html>

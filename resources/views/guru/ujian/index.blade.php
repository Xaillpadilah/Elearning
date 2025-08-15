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
<!-- Tombol -->
<button class="btn-tambah" onclick="bukaModalSoal({{ $u->id }})">
    ➕ Tambah Soal Manual
</button>

<!-- Modal -->
<div id="modalTambahSoal" class="modal" style="display:none;">
  <div class="modal-content" onclick="event.stopPropagation()">
    <h3>Tambah Soal Manual</h3>
    <form id="formTambahSoal" method="POST" action="{{ route('soal-ujian.store') }}">
      @csrf
      <input type="hidden" name="ujian_id" id="soalUjianId">

      <label>Nomor Soal</label>
      <input type="number" name="nomor" required>

      <label>Pertanyaan</label>
      <textarea name="pertanyaan" required></textarea>

      <label>Opsi A</label>
      <input type="text" name="opsi_a" required>
      <label>Opsi B</label>
      <input type="text" name="opsi_b" required>
      <label>Opsi C</label>
      <input type="text" name="opsi_c" required>
      <label>Opsi D</label>
      <input type="text" name="opsi_d" required>

      <label>Jawaban Benar</label>
      <select name="jawaban_benar" required>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>

      <div style="margin-top:15px;">
        <button type="submit" class="btn-simpan-tambah">💾 Simpan Soal</button>
      </div>
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
<script>
  function bukaModalSoal(ujianId) {
    document.getElementById('modalTambahSoal').style.display = 'flex';
    document.getElementById('soalUjianId').value = ujianId;
  }
</script>
<script>
function bukaModalSoal(ujianId) {
    document.getElementById('soalUjianId').value = ujianId;
    document.getElementById('modalTambahSoal').style.display = 'flex';
}

function tutupModalSoal() {
    document.getElementById('modalTambahSoal').style.display = 'none';
}

document.getElementById('modalTambahSoal').addEventListener('click', tutupModalSoal);

document.getElementById('formTambahSoal').addEventListener('submit', function(event) {
    event.preventDefault();

    let form = this;
    let formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': form.querySelector('[name=_token]').value
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert('Soal berhasil disimpan!');
        tutupModalSoal();
        form.reset();
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan saat menyimpan soal.');
    });
});
</script>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    align-items: center; /* biar modal-content di tengah vertikal */
    justify-content: center; /* tengah horizontal */
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    max-width: 90%;
}
</style>
</body>
</html>
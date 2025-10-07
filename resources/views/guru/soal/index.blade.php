@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Soal Ujian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  @vite(['resources/css/tugas.css'])
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
    h2 { margin-bottom: 20px; }
    .btn { padding: 8px 14px; border: none; border-radius: 5px; cursor: pointer; }
    .btn-tambah { background-color: #28a745; color: white; }
    .btn-edit { background-color: #ffc107; color: white; }
    .btn-delete { background-color: #dc3545; color: white; }
    table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; }
    .modal-content { background: white; padding: 20px; border-radius: 8px; width: 450px; }
    .modal-content input, .modal-content textarea, .modal-content select {
      width: 100%; padding: 8px; margin: 5px 0 10px; border: 1px solid #ccc; border-radius: 5px;
    }
  </style>
</head>
<body>

<h2>Kelola Soal - {{ $ujian->judul }}</h2>

<button class="btn btn-tambah" onclick="document.getElementById('modalTambah').style.display='flex'">➕ Tambah Soal</button>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Soal</th>
      <th>Tipe</th>
      <th>Jawaban Benar</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($soals as $i => $s)
    <tr>
      <td>{{ $s->nomor_urut }}</td>
      <td>{{ Str::limit($s->soal, 80) }}</td>
      <td>{{ ucfirst(str_replace('_',' ', $s->tipe)) }}</td>
      <td>{{ $s->jawaban_benar }}</td>
      <td>
        <button class="btn btn-edit" onclick="editSoal({{ $s }})">✏️</button>
        <form action="{{ route('soal-ujian.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus soal ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-delete">🗑️</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<!-- Modal Tambah -->
<div class="modal" id="modalTambah">
  <div class="modal-content">
    <h3>Tambah Soal</h3>
    <form action="{{ route('soal-ujian.store') }}" method="POST">
      @csrf
      <input type="hidden" name="ujian_id" value="{{ $ujian->id }}">
      <label>Nomor Urut</label>
      <input type="number" name="nomor_urut" required>

      <label>Tipe</label>
      <select name="tipe" id="tipeTambah" onchange="toggleOpsi('Tambah')" required>
        <option value="pilihan_ganda">Pilihan Ganda</option>
        <option value="essai">Essai</option>
      </select>

      <label>Soal</label>
      <textarea name="soal" required></textarea>

      <div id="opsiTambah">
        <label>Opsi Jawaban (pisah dengan |)</label>
        <input type="text" name="opsi">
      </div>

      <label>Jawaban Benar</label>
      <input type="text" name="jawaban_benar" required>

      <button type="submit" class="btn btn-tambah">💾 Simpan</button>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal" id="modalEdit">
  <div class="modal-content">
    <h3>Edit Soal</h3>
    <form id="formEdit" method="POST">
      @csrf @method('PUT')
      <input type="hidden" name="ujian_id" value="{{ $ujian->id }}">

      <label>Nomor Urut</label>
      <input type="number" name="nomor_urut" id="editNomorUrut" required>

      <label>Tipe</label>
      <select name="tipe" id="editTipe" onchange="toggleOpsi('Edit')" required>
        <option value="pilihan_ganda">Pilihan Ganda</option>
        <option value="essai">Essai</option>
      </select>

      <label>Soal</label>
      <textarea name="soal" id="editSoal" required></textarea>

      <div id="opsiEdit">
        <label>Opsi Jawaban (pisah dengan |)</label>
        <input type="text" name="opsi" id="editOpsi">
      </div>

      <label>Jawaban Benar</label>
      <input type="text" name="jawaban_benar" id="editJawabanBenar" required>

      <button type="submit" class="btn btn-tambah">💾 Update</button>
    </form>
  </div>
</div>

<script>
  function editSoal(soal) {
    document.getElementById('modalEdit').style.display = 'flex';
    document.getElementById('formEdit').action = `/soal-ujian/${soal.id}`;
    document.getElementById('editNomorUrut').value = soal.nomor_urut;
    document.getElementById('editTipe').value = soal.tipe;
    document.getElementById('editSoal').value = soal.soal;
    document.getElementById('editOpsi').value = soal.opsi || '';
    document.getElementById('editJawabanBenar').value = soal.jawaban_benar;

    toggleOpsi('Edit');
  }

  function toggleOpsi(mode) {
    const tipe = document.getElementById(mode === 'Edit' ? 'editTipe' : 'tipeTambah').value;
    const container = document.getElementById(mode === 'Edit' ? 'opsiEdit' : 'opsiTambah');
    container.style.display = (tipe === 'pilihan_ganda') ? 'block' : 'none';
  }

  window.onclick = function(event) {
    ['modalTambah', 'modalEdit'].forEach(id => {
      const modal = document.getElementById(id);
      if (event.target === modal) modal.style.display = 'none';
    });
  };
</script>

</body>
</html>

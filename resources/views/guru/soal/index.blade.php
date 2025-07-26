<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Soal Ujian</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f7fb;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 1100px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .header-box {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    h2 {
      margin: 0;
    }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }
    .btn {
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
    }
    .btn-primary {
      background-color: #3498db;
      color: white;
    }
    .btn-danger {
      background-color: #e74c3c;
      color: white;
    }
    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      justify-content: center;
      align-items: center;
      z-index: 99;
    }
    .modal-content {
      background: white;
      padding: 20px;
      width: 600px;
      border-radius: 10px;
      position: relative;
    }
    .close {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      cursor: pointer;
    }
    .form-group {
      margin-top: 10px;
    }
    .form-control {
      width: 100%;
      padding: 8px;
      margin-top: 4px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="header-box">
    <h2>📄 Soal Ujian</h2>
    <button class="btn btn-primary" onclick="openModal()">+ Tambah Soal</button>
  </div>

  @if (session('success'))
    <div style="margin-top: 15px; color: green;">
      {{ session('success') }}
    </div>
  @endif

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Pertanyaan</th>
        <th>Opsi A</th>
        <th>Opsi B</th>
        <th>Opsi C</th>
        <th>Opsi D</th>
        <th>Jawaban Benar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($soalUjians as $index => $soal)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $soal->pertanyaan }}</td>
          <td>{{ $soal->opsi_a }}</td>
          <td>{{ $soal->opsi_b }}</td>
          <td>{{ $soal->opsi_c }}</td>
          <td>{{ $soal->opsi_d }}</td>
          <td>{{ $soal->jawaban_benar }}</td>
          <td>
            <form action="{{ route('guru.soal.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit">🗑 Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align: center;">Belum ada soal</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Modal Tambah Soal --}}
<div class="modal" id="modalForm">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Tambah Soal Ujian</h3>
    <form action="{{ route('guru.soal.store') }}" method="POST">
      @csrf
      <input type="hidden" name="ujian_id" value="{{ $ujian_id }}">
      
      <div class="form-group">
        <label>Pertanyaan</label>
        <textarea name="pertanyaan" class="form-control" required></textarea>
      </div>
      <div class="form-group">
        <label>Opsi A</label>
        <input type="text" name="opsi_a" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Opsi B</label>
        <input type="text" name="opsi_b" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Opsi C</label>
        <input type="text" name="opsi_c" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Opsi D</label>
        <input type="text" name="opsi_d" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Jawaban Benar</label>
        <select name="jawaban_benar" class="form-control" required>
          <option value="">Pilih Jawaban</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
        </select>
      </div>
      <div style="text-align: right; margin-top: 15px;">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById('modalForm').style.display = 'flex';
  }
  function closeModal() {
    document.getElementById('modalForm').style.display = 'none';
  }
</script>

</body>
</html>

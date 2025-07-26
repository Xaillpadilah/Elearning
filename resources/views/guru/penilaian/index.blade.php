@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Penilaian - Kelas Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/adminguru.css'])
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f6f6f6; margin: 0; }

    .card-container {
      display: flex;
      flex-direction: column;
      gap: 24px;
      margin-top: 50px;
      padding: 0 20px;
    }

    .card-kelas {
      width: 100%;
      background: #ffffff;
      border-radius: 20px;
      padding: 40px 24px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.12);
      transition: transform 0.3s ease;
      border: 1px solid #e5e5e5;
    }

    .card-kelas:hover { transform: translateY(-6px); }

    .card-kelas h3 { font-size: 22px; margin-bottom: 10px; color: #333; }
    .card-kelas p { font-size: 16px; color: #666; margin-bottom: 20px; }

    .btn-input {
      background: linear-gradient(to right, #28a745, #218838);
      color: white;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-input:hover { background: linear-gradient(to right, #218838, #1e7e34); }

    .input-nilai-form table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .input-nilai-form th, .input-nilai-form td {
      padding: 8px;
      border: 1px solid #ccc;
      text-align: center;
    }

    .btn-simpan {
      margin-top: 20px;
      padding: 10px 20px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn-simpan:hover { background: #45a049; }

    .modal {
      display: none;
      position: fixed;
      z-index: 10000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow-y: auto;
      background-color: rgba(0, 0, 0, 0.6);
    }

    .modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 20px;
      border-radius: 12px;
      width: 90%;
      max-width: 900px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    .close {
      position: absolute;
      top: 12px;
      right: 20px;
      font-size: 28px;
      color: #333;
      cursor: pointer;
    }.
   button-group {
  display: flex;
  gap: 12px;
  margin-top: 20px;
  justify-content: start; /* tombol sejajar ke kiri */
}

.btn-simpan,
.btn-kirim {
  width: 180px;             /* ❗ Ukuran sama persis */
  height: 45px;             /* ❗ Tinggi konsisten */
  padding: 10px 0;
  text-align: center;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Tombol Simpan (Hijau) */
.btn-simpan {
  background-color: #28a745;
  color: white;
}
.btn-simpan:hover {
  background-color: #218838;
}

/* Tombol Kirim (Biru) */
.btn-kirim {
  background-color: #007bff;
  color: white;
}
.btn-kirim:hover {
  background-color: #0056b3;
}

    .main {
      margin-left: 240px;
      padding: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .fullscreen-btn {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
    }

   

    footer {
      margin-top: 60px;
      text-align: center;
      padding: 20px;
      color: #666;
    }
    .btn-lihat {
  background: linear-gradient(to right, #007bff, #0056b3);
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: background 0.3s ease;
}
.btn-lihat:hover {
  background: linear-gradient(to right, #0056b3, #004494);
}
/* Batasi lebar tabel */

/* Gaya tabel agar tidak terlalu besar */
.input-nilai-form {
  width: 100%;
  min-width: 800px; /* agar tetap readable, tapi scrollable di layar kecil */
  border-collapse: collapse;
}



.btn-simpan,
.btn-kirim {
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  font-size: 14px;
  cursor: pointer;
  transition: background 0.3s;
}

.btn-simpan {
  background-color: #28a745;
  color: white;
}

.btn-kirim {
  background-color: #007bff;
  color: white;
}

.btn-simpan:hover {
  background-color: #218838;
}

.btn-kirim:hover {
  background-color: #0069d9;
}

/* Input kecil agar tidak melebar */
.input-nilai-form input[type="number"],
.input-nilai-form input[type="text"] {
  max-width: 100px;
}
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Dashboard Guru</h2>
    <ul>
      <li><a href="{{ route('guru.dashboard') }}">🏠 Dashboard</a></li>
      <li><a href="{{ route('materi.index') }}"> Materi Dan Konten</a></li>
      <li><a href="{{ route('guru.menu') }}"> Kuis dan Tugas</a></li>
      <li><a href="{{ route('guru.absensi.index') }}" class="{{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}"> Absensi</a></li>
      <li><a href="{{ route('guru.penilaian.index') }}" class="active"> Penilaian</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
      <div class="user">👤 {{ auth()->user()->name ?? 'Guru' }}</div>
    </div>

    
  <div class="info-frame">
    <h4>📝 Input Penilaian Siswa</h4>
    <p>Berikut daftar kelas dan mapel yang Anda ajar. Klik <b>Input Nilai</b> untuk melanjutkan.</p>
  </div>

  @if(session('success'))
    <div class="info-frame" style="color: green;">{{ session('success') }}</div>
  @endif

  @if($relasiGuruMapelKelas->count())
    <div class="card-container">
      @foreach($relasiGuruMapelKelas as $relasi)
      <div class="card-kelas">
        <h3>{{ $relasi->kelas->nama_kelas ?? '-' }}</h3>
        <p><strong>Mapel:</strong> {{ optional($relasi->mapel)->nama_mapel ?? '-' }}</p>
        <button class="btn-input" onclick="openModal({{ $relasi->id }})">📝 Input Nilai</button>


<!-- Tombol Lihat Nilai Siswa -->
<button class="btn-input" style="margin-left: 10px; background: linear-gradient(to right, #007bff, #0056b3);" onclick="toggleNilai({{ $relasi->id }})">📋 Lihat Nilai Siswa</button>

<!-- Tabel Nilai per Relasi -->
<div id="nilai-container-{{ $relasi->id }}" class="info-frame" style="display:none; margin-top: 20px;">
  <h4>📊 Daftar Penilaian Tersimpan</h4>

  @php
      $penilaiansFiltered = $penilaians->where('kelas_id', $relasi->kelas_id)->where('mapel_id', $relasi->mapel_id);
  @endphp

  @if ($penilaiansFiltered->count() > 0)
    <form action="{{ route('guru.penilaian.updateMultiple') }}" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="mapel_id" value="{{ $relasi->mapel_id }}">
      <input type="hidden" name="kelas_id" value="{{ $relasi->kelas_id }}">

      <table class="table table-bordered mt-3 input-nilai-form">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Mapel</th>
            <th>Tugas</th>
            <th>Kuis</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>Catatan</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($penilaiansFiltered as $i => $p)
<tr>
    <td>{{ $i + 1 }}</td>
    <td>{{ $p->siswa->nama ?? '-' }}</td>
    <td>{{ $p->mapel->nama_mapel ?? '-' }}</td>

    <!-- Hidden ID untuk penilaian -->
    <input type="hidden" name="penilaian_ids[]" value="{{ $p->id }}">

    <!-- Input nilai sesuai dengan struktur array nilai[index][field] -->
    <td>
        <input type="number" step="0.01" name="nilai[{{ $i }}][tugas]" class="form-control" value="{{ $p->nilai_tugas }}">
    </td>
    <td>
        <input type="number" step="0.01" name="nilai[{{ $i }}][kuis]" class="form-control" value="{{ $p->nilai_kuis }}">
    </td>
    <td>
        <input type="number" step="0.01" name="nilai[{{ $i }}][uts]" class="form-control" value="{{ $p->nilai_uts }}">
    </td>
    <td>
        <input type="number" step="0.01" name="nilai[{{ $i }}][uas]" class="form-control" value="{{ $p->nilai_uas }}">
    </td>
    <td>
        <input type="text" name="nilai[{{ $i }}][catatan]" class="form-control" value="{{ $p->catatan }}">
    </td>
</tr>
@endforeach
        </tbody>
      </table>
<div class="button-group">
  <button type="submit" class="btn-simpan">💾 Perbarui Nilai</button>
  <button type="submit" name="kirim_ke_siswa" value="1" class="btn-kirim">🚀 Kirim</button>
</div>
    </form>
  @else
    <p style="color: red;">Tidak ada data penilaian untuk kelas dan mapel ini.</p>
  @endif
</div>
        <!-- Modal -->
        <div id="modal-{{ $relasi->id }}" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeModal({{ $relasi->id }})">&times;</span>
            <h3>Input Nilai - {{ $relasi->mapel->nama_mapel ?? '-' }}</h3>

            @php
              $siswaList = \App\Models\Siswa::where('kelas_id', $relasi->kelas_id)->get();
            @endphp

            @if($siswaList->count())
              <form action="{{ route('guru.penilaian.store') }}" method="POST" class="input-nilai-form">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $relasi->kelas_id }}">
                <input type="hidden" name="mapel_id" value="{{ $relasi->mapel_id }}">

                <table>
                  <thead>
                    <tr>
                      <th>Nama Siswa</th>
                      <th>Tugas</th>
                      <th>Kuis</th>
                      <th>UTS</th>
                      <th>UAS</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($siswaList as $siswa)
<tr>
  <td>{{ $siswa->nama }}</td>
  <td><input type="number" step="0.01" name="nilai[{{ $siswa->id }}][tugas]" required></td>
  <td><input type="number" step="0.01" name="nilai[{{ $siswa->id }}][kuis]" required></td>
  <td><input type="number" step="0.01" name="nilai[{{ $siswa->id }}][uts]" required></td>
  <td><input type="number" step="0.01" name="nilai[{{ $siswa->id }}][uas]" required></td>
</tr>
@endforeach
                  </tbody>
                </table>

                <button type="submit" class="btn-simpan">💾 Simpan Nilai</button>
              </form>
            @else
              <p style="color: red;">Tidak ada siswa di kelas ini.</p>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @else
    <div class="info-frame" style="color: red;">Anda belum memiliki kelas atau mapel yang ditugaskan.</div>
  @endif


    <footer>&copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.</footer>
  </div>

  <script>
    function toggleFullscreenDashboard() {
      document.querySelector('.sidebar').classList.toggle('hidden');
      document.querySelector('.main').classList.toggle('fullscreen');
    }

    function openModal(id) {
      document.getElementById('modal-' + id).style.display = 'block';
    }

    function closeModal(id) {
      document.getElementById('modal-' + id).style.display = 'none';
    }

    window.onclick = function(event) {
      const modals = document.querySelectorAll('.modal');
      modals.forEach(modal => {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      });
    }
  </script>
  <script>
  function toggleNilai(id) {
    const el = document.getElementById('nilai-container-' + id);
    if (el.style.display === 'none' || el.style.display === '') {
      el.style.display = 'block';
    } else {
      el.style.display = 'none';
    }
  }
</script>

</body>
</html>

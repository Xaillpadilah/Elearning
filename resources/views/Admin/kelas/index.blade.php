@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Kelas - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/adminguru.css'])
</head>
<body>
  <style>.btn-jadwal {
  background-color: #4e73df;
  color: white;
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  text-decoration: none;
  font-size: 14px;
  cursor: pointer;
}

.btn-jadwal:hover {
  background-color: #2e59d9;
}
.close-btn {
  position: absolute;
  right: 20px;
  top: 10px;
  font-size: 24px;
  cursor: pointer;
  color: #999;
}

.close-btn:hover {
  color: #333;
}
.close-modal {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 24px;
  cursor: pointer;
}
</style>
<!-- Sidebar -->
<div class="sidebar">
  <h2>Dashboard Admin</h2>
  <ul>
    <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('admin.guru') }}">Data Guru</a></li>
    <li><a href="{{ route('admin.siswa') }}">Data Siswa</a></li>
    <li><a href="{{ route('admin.kelas') }}" class="active"> Data Kelas Jadwal</a></li>
    <li><a href="{{ route('materi.index') }}">Materi Dan Konten</a></li>
    <li><a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a></li>
  </ul>
</div>

<div class="main">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
    <div class="user">🛡️ {{ auth()->user()->name ?? 'Admin' }}</div>
  </div>

  <div class="info-frame">
    <h4>🏫 Data Kelas</h4>
    <p>Berikut adalah daftar kelas beserta jumlah siswanya.</p>
  </div>

  @if(session('success'))
    <div class="info-frame" style="color: green;">{{ session('success') }}</div>
  @endif

  <div class="actions">
    <button class="btn-tambah" onclick="document.getElementById('modalTambah').style.display='flex'">➕ Tambah Kelas</button>
    <a href="{{ route('admin.kelas.export') }}" class="btn-ekspor">📄 Ekspor Excel</a>
    <form action="{{ route('admin.kelas.import') }}" method="POST" enctype="multipart/form-data" class="form-import">
      @csrf
      <input type="file" name="file" required>
      <button type="submit">📅 Impor Excel</button>
    </form>
  </div>

  <form action="{{ route('admin.kelas') }}" method="GET" class="search-form">
    <input type="text" name="search" placeholder="Cari kelas atau wali kelas..." value="{{ $search ?? '' }}">
    <button type="submit">🔍 Cari</button>
  </form>

  @if($kelas->count())
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Kelas</th>
        <th>Wali Kelas</th>
        <th>Jumlah Siswa</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
     @foreach($kelas as $index => $k)
<tr>
  <td>{{ $index + 1 }}</td>
  <td>{{ $k->nama_kelas }}</td>
  <td>{{ $k->wali->nama ?? '-' }}</td>
  <td>{{ $k->siswas_count }}</td>
  <td style="display: flex; gap: 6px; align-items: center;">
    <a href="{{ route('admin.kelas.jadwal', $k->id) }}" class="btn-jadwal">📆 Jadwal</a>
    <button class="btn-edit"
      data-id="{{ $k->id }}"
      data-nama="{{ $k->nama_kelas }}"
      data-wali="{{ $k->wali_kelas }}">
      ✏️ Edit
    </button>
    <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
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
    <div class="info-frame no-data">Tidak ada data kelas ditemukan.</div>
  @endif
</div>
<!-- Modal Tambah -->
<div id="modalTambah" class="modal">
  <div class="modal-content">
    <span class="close-btn" id="closeModalTambah">&times;</span> <!-- Tombol Tutup -->
    <h3>Tambah Kelas</h3>
    <form action="{{ route('admin.kelas.store') }}" method="POST">
      @csrf
      <!-- Pilih Nama Kelas -->
      <label>Nama Kelas</label>
      <select name="nama_kelas" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach(['7A', '7B', '7C','8A', '8B','8C','9A', '9B','9C'] as $nama_kelas)
          <option value="{{ $nama_kelas }}">{{ $nama_kelas }}</option>
        @endforeach
      </select>

      <!-- Pilih Wali Kelas -->
      <label>Wali Kelas</label>
      <select name="wali_kelas" required>
        <option value="">-- Pilih Wali Kelas --</option>
        @foreach($gurus as $guru)
          <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
        @endforeach
      </select>

      <button type="submit" class="btn-simpan-tambah">💾 Simpan</button>
    </form>
  </div>
</div>
<!-- Modal Edit -->
<div id="modalEdit" class="modal">
  <div class="modal-content">
    <span class="close-modal" id="closeModalEdit">&times;</span> <!-- Tombol tutup -->
    <h3>Edit Kelas</h3>
    <form id="formEdit" method="POST">
      @csrf
      @method('POST')
      
      <label>Nama Kelas</label>
      <select id="edit-nama-kelas" name="nama_kelas" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach(['7A', '7B','7C','8A', '8B','8C', '9A', '9B','9C'] as $nama_kelas)
          <option value="{{ $nama_kelas }}">{{ $nama_kelas }}</option>
        @endforeach
      </select>

      <label>Wali Kelas</label>
      <select id="edit-wali-kelas" name="wali_kelas" required>
        <option value="">-- Pilih Guru --</option>
        @foreach ($gurus as $guru)
          <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
        @endforeach
      </select>

      <button type="submit" class="btn-simpan-edit">💾 Simpan Perubahan</button>
    </form>
  </div>
</div>


<footer>&copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.</footer>

<script>
  function toggleFullscreenDashboard() {
    document.querySelector('.sidebar').classList.toggle('hidden');
    document.querySelector('.main').classList.toggle('fullscreen');
  }

 unction openEditModal(kelas, gurus) {
  const select = document.getElementById('edit-wali-kelas');
  select.innerHTML = ''; // kosongkan dulu

  gurus.forEach(guru => {
    const option = document.createElement('option');
    option.value = guru.id;
    option.textContent = guru.nama;
    if (guru.id === kelas.wali_kelas) {
      option.selected = true;
    }
    select.appendChild(option);
  });

  // isi nama kelas
  document.getElementById('edit-nama-kelas').value = kelas.nama_kelas;
  document.getElementById('formEdit').action = `/kelas/${kelas.id}`;

  document.getElementById('modalEdit').style.display = 'block';
}
  document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
      document.getElementById('modalEdit').style.display = 'none';
      document.getElementById('modalTambah').style.display = 'none';
    }
  });

  window.onclick = function(event) {
    if (event.target === document.getElementById('modalEdit')) document.getElementById('modalEdit').style.display = "none";
    if (event.target === document.getElementById('modalTambah')) document.getElementById('modalTambah').style.display = "none";
  };
</script>
<script>
  // Tampilkan modal edit
  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function () {
      const id = this.dataset.id;
      const nama = this.dataset.nama;
      const wali = this.dataset.wali;

      document.getElementById('edit-nama-kelas').value = nama;
      document.getElementById('edit-wali-kelas').value = wali;
      document.getElementById('formEdit').action = `/admin/kelas/${id}`;
      document.getElementById('modalEdit').style.display = 'flex';
    });
  });

  // Fungsi: klik tombol tutup
  document.getElementById('closeModalEdit').addEventListener('click', function () {
    document.getElementById('modalEdit').style.display = 'none';
  });

  // Fungsi: klik di luar modal-content untuk menutup
  window.addEventListener('click', function (e) {
    const modal = document.getElementById('modalEdit');
    const content = modal.querySelector('.modal-content');
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
</script>
<script>
  const modalTambah = document.getElementById('modalTambah');
  const closeModalTambah = document.getElementById('closeModalTambah');

  // Tutup saat klik tombol ❌
  closeModalTambah.onclick = () => {
    modalTambah.style.display = 'none';
  };

  // Tutup saat klik di luar modal-content
  window.onclick = function(event) {
    if (event.target === modalTambah) {
      modalTambah.style.display = 'none';
    }
  };
</script>
</body>
</html>

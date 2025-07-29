@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Pengumuman - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/adminguru.css'])
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Dashboard Admin</h2>
    <ul>
      <li><a href="{{ route('admin.dashboard') }}"
          class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
      <li><a href="{{ route('admin.guru') }}" class="{{ request()->routeIs('admin.guru') ? 'active' : '' }}">👨‍🏫 Data
          Guru</a></li>
      <li><a href="{{ route('admin.siswa') }}" class="{{ request()->routeIs('admin.siswa') ? 'active' : '' }}">🧑‍🎓
          Data Siswa</a></li>
      <li><a href="{{ route('admin.kelas') }}" class="{{ request()->routeIs('admin.kelas') ? 'active' : '' }}">📅 Data
          Kelas Jadwal</a></li>
      <li><a href="{{ route('materi.index') }}" class="{{ request()->routeIs('materi.index') ? 'active' : '' }}">📚
          Materi Dan Konten</a></li>
      <li><a href="{{ route('admin.pengumuman.index') }}"
          class="{{ request()->routeIs('admin.pengumuman.index') ? 'active' : '' }}">📢 Pengumuman</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
      <div class="user">🛡️ {{ auth()->user()->name ?? 'Admin' }}</div>
    </div>

    <div class="info-frame">
      <h4>📢 Data Pengumuman</h4>
      <p>Berikut adalah daftar pengumuman yang telah dibuat dalam sistem.</p>
    </div>

    @if(session('success'))
    <div class="info-frame" style="color: green;">{{ session('success') }}</div>
  @endif
    @if(session('error'))
    <div class="info-frame" style="color: red;">{{ session('error') }}</div>
  @endif

    <div class="actions">
      <button class="btn-tambah" onclick="document.getElementById('modalTambahPengumuman').style.display='flex'">➕
        Tambah Pengumuman</button>
    </div>

    @if($pengumumen->count())
    <table>
      <thead>
      <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Tanggal</th>
        <th>Ditujukan</th>
        <th>Isi</th>
        <th>Dibuat Oleh</th>
        <th>Aksi</th>
      </tr>
      </thead>
      <tbody>
      @foreach($pengumumen as $index => $p)
      <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ $p->judul }}</td>
      <td>{{ \Carbon\Carbon::parse($p->tanggal_pengumuman)->format('d M Y') }}</td>
      <td>{{ ucfirst($p->ditujukan_kepada) }}</td>
      <td>{{ Str::limit(strip_tags($p->isi), 50) }}</td>
      <td>{{ $p->dibuat_oleh_user->name ?? '-' }}</td>
      <td style="display: flex; gap: 6px; align-items: center;">
      <button class="btn-edit" onclick='openEditModal(@json($p))'>✏️ Edit</button>
      <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST"
        onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
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
    <div class="info-frame no-data">Belum ada pengumuman.</div>
  @endif
  </div>

  <!-- Modal Tambah -->
  <div id="modalTambahPengumuman" class="modal">
    <div class="modal-content">
      <h3>Tambah Pengumuman</h3>
      <form action="{{ route('admin.pengumuman.store') }}" method="POST">
        @csrf
        <label>Judul</label>
        <input type="text" name="judul" required>

        <label>Tanggal Pengumuman</label>
        <input type="date" name="tanggal_pengumuman" required>

        <label>Ditujukan Kepada</label>
        <select name="ditujukan_kepada" required>
          <option value="">-- Pilih --</option>
          <option value="semua">Semua</option>
          <option value="guru">Guru</option>
          <option value="siswa">Siswa</option>
          <option value="orangtua">Orang Tua</option>
        </select>

        <label>Isi Pengumuman</label>
        <textarea name="isi" rows="5" required></textarea>

        <button type="submit" class="btn-simpan-tambah">💾 Simpan</button>
      </form>
    </div>
  </div>

  <!-- Modal Edit -->
  <div id="modalEditPengumuman" class="modal">
    <div class="modal-content">
      <h3>Edit Pengumuman</h3>
      <form id="formEditPengumuman" method="POST">
        @csrf
        @method('PUT')

        <label>Judul</label>
        <input type="text" name="judul" id="edit-judul" required>

        <label>Tanggal Pengumuman</label>
        <input type="date" name="tanggal_pengumuman" id="edit-tanggal" required>

        <label>Ditujukan Kepada</label>
        <select name="ditujukan_kepada" id="edit-ditujukan" required>
          <option value="semua">Semua</option>
          <option value="guru">Guru</option>
          <option value="siswa">Siswa</option>
          <option value="orangtua">Orang Tua</option>
        </select>

        <label>Isi Pengumuman</label>
        <textarea name="isi" id="edit-isi" rows="5" required></textarea>

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

    function openEditModal(pengumuman) {
      document.getElementById('modalEditPengumuman').style.display = 'flex';
      document.getElementById('edit-judul').value = pengumuman.judul;
      document.getElementById('edit-tanggal').value = pengumuman.tanggal_pengumuman;
      document.getElementById('edit-isi').value = pengumuman.isi;
      document.getElementById('edit-ditujukan').value = pengumuman.ditujukan_kepada;
      document.getElementById('formEditPengumuman').action = `{{ url('/admin/pengumuman') }}/${pengumuman.id}`;
    }

    document.addEventListener('keydown', function (e) {
      if (e.key === "Escape") {
        document.getElementById('modalEditPengumuman').style.display = 'none';
        document.getElementById('modalTambahPengumuman').style.display = 'none';
      }
    });

    window.onclick = function (event) {
      if (event.target === document.getElementById('modalEditPengumuman')) document.getElementById('modalEditPengumuman').style.display = "none";
      if (event.target === document.getElementById('modalTambahPengumuman')) document.getElementById('modalTambahPengumuman').style.display = "none";
    };
  </script>
</body>

</html>
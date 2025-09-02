@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Guru - Admin</title>
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
      <h4>👨‍🏫 Data Guru</h4>
      <p>Berikut adalah daftar guru yang terdaftar dalam sistem.</p>
    </div>

    @if(session('success'))
    <div class="info-frame" style="color: green;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="info-frame" style="color: red;">{{ session('error') }}</div>
    @endif

    <div class="actions">
      <button class="btn-tambah" onclick="document.getElementById('modalTambahGuru').style.display='flex'">➕ Tambah
        Guru</button>
      <a href="{{ route('admin.guru.export') }}" class="btn-ekspor">📄 Ekspor Excel</a>
      <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data" class="form-import">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">📅 Impor Excel</button>
      </form>
    </div>

    <form action="{{ route('admin.guru') }}" method="GET" class="search-form">
      <input type="text" name="search" placeholder="Cari guru..." value="{{ $search ?? '' }}">
      <button type="submit">🔍 Cari</button>
    </form>

    @if($gurus->count())
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>NIP</th>
          <th>Jenis Kelamin</th>
          <th>Mengajar</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($gurus as $index => $guru)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $guru->nama }}</td>
          <td>{{ $guru->nik }}</td>
          <td>{{ $guru->jenis_kelamin ?? '-' }}</td>
          <td>
            <ul>
              @foreach($guru->mapel_kelas as $mk)
              <li>{{ $mk['mapel_nama'] ?? '-' }} - Kelas {{ $mk['kelas_id'] }}</li>
              @endforeach
            </ul>
          </td>
          <td>{{ $guru->user->email ?? '-' }}</td>
          <td style="display: flex; gap: 6px; align-items: center;">
            <button class="btn-edit" onclick='openEditModal(@json($guru))'>✏️ Edit</button>
            <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
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
    <div class="info-frame no-data">Tidak ada data guru ditemukan.</div>
    @endif
  </div>

  <!-- Modal Tambah Guru -->
  <div id="modalTambahGuru" class="modal">
    <div class="modal-content">
      <h3>Tambah Data Guru</h3>
      <form action="{{ route('admin.guru.store') }}" method="POST" id="formTambahGuru">
        @csrf
        <label>Nama</label>
        <input type="text" name="nama" required 
       pattern="[A-Za-z\s\.,]+" 
       title="Nama hanya boleh huruf, spasi, titik, dan koma">

        <label>NIP</label>
        <input type="text" name="nik" required minlength="16" maxlength="16" pattern="\d{16}">

        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
          <option value="">-- Pilih Jenis Kelamin --</option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>

        @for ($i = 0; $i < 3; $i++)
          <label>Pelajaran {{ $i + 1 }}</label>
          <select name="pelajaran[{{ $i }}][nama]" required>
            <option value="">-- Pilih Mapel --</option>
            @foreach($mapels as $mapel)
            <option value="{{ $mapel->nama_mapel }}">{{ $mapel->nama_mapel }}</option>
            @endforeach
          </select>

          <label>Kelas untuk Pelajaran {{ $i + 1 }}</label>
          <select name="pelajaran[{{ $i }}][kelas_id]" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
          @endfor

          <label>Email</label>
          <input type="email" name="email" required>

          <button type="submit" class="btn-simpan-tambah">💾 Simpan</button>
      </form>
    </div>
  </div>

  <!-- Modal Edit Guru -->
  <div id="modalEditGuru" class="modal">
    <div class="modal-content">
      <h3>Edit Data Guru</h3>
      <form id="formEditGuru" method="POST">
        @csrf
        @method('PUT')
        <label>Nama</label>
       <input type="text" id="edit-nama" name="nama" required 
       pattern="[A-Za-z\s\.,]+" 
       title="Nama hanya boleh huruf, spasi, titik, dan koma">

        <label>NIP</label>
        <input type="text" id="edit-nik" name="nik" required minlength="16" maxlength="16" pattern="\d{16}">

        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" id="edit-jenis-kelamin" required>
          <option value="">-- Pilih Jenis Kelamin --</option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>

        @for ($i = 0; $i < 3; $i++)
          <label>Pelajaran {{ $i + 1 }}</label>
          <select name="pelajaran[{{ $i }}][nama]" id="edit-pelajaran-{{ $i }}" required>
            <option value="">-- Pilih Mapel --</option>
            @foreach($mapels as $mapel)
            <option value="{{ $mapel->nama_mapel }}">{{ $mapel->nama_mapel }}</option>
            @endforeach
          </select>

          <label>Kelas untuk Pelajaran {{ $i + 1 }}</label>
          <select name="pelajaran[{{ $i }}][kelas_id]" id="edit-kelas-{{ $i }}" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
          @endfor

          <label>Email</label>
          <input type="email" id="edit-email" name="email" required>

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

    function openEditModal(guru) {
      document.getElementById('modalEditGuru').style.display = 'flex';
      document.getElementById('edit-nama').value = guru.nama;
      document.getElementById('edit-nik').value = guru.nik;
      document.getElementById('edit-email').value = guru.user?.email || '';
      document.getElementById('formEditGuru').action = `{{ url('/admin/guru') }}/${guru.id}`;

      const jk = (guru.jenis_kelamin || '').toLowerCase();
      const selectJK = document.getElementById('edit-jenis-kelamin');
      for (let opt of selectJK.options) {
        opt.selected = opt.value.toLowerCase() === jk;
      }

      for (let i = 0; i < 3; i++) {
        document.getElementById(`edit-pelajaran-${i}`).value = '';
        document.getElementById(`edit-kelas-${i}`).value = '';
      }

      if (guru.mapel_kelas && guru.mapel_kelas.length) {
        guru.mapel_kelas.slice(0, 3).forEach((item, i) => {
          document.getElementById(`edit-pelajaran-${i}`).value = item.mapel_nama;
          document.getElementById(`edit-kelas-${i}`).value = item.kelas_id;
        });
      }
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === "Escape") {
        document.getElementById('modalEditGuru').style.display = 'none';
        document.getElementById('modalTambahGuru').style.display = 'none';
      }
    });

    window.onclick = function(event) {
      if (event.target === document.getElementById('modalEditGuru')) document.getElementById('modalEditGuru').style.display = "none";
      if (event.target === document.getElementById('modalTambahGuru')) document.getElementById('modalTambahGuru').style.display = "none";
    };
  </script>
</body>

</html>
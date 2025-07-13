<div id="modalTambahSiswa" class="modal">
  <div class="modal-content">
    <h3>➕ Tambah Siswa</h3>
    <form action="{{ route('admin.siswa.store') }}" method="POST">
      @csrf
      <input type="text" name="nama" placeholder="Nama Lengkap" required>
      <input type="text" name="nisn" placeholder="NISN" required>

      <select name="kelas_id" required style="width: 100%; padding: 10px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 8px;">
        <option value="">Pilih Kelas</option>
        @foreach($kelas as $k)
          <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
        @endforeach
      </select>

      <input type="email" name="email" placeholder="Email Akun" required>
      <input type="password" name="password" placeholder="Password Akun" required>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" onclick="document.getElementById('modalTambahSiswa').style.display='none'" style="background: #ccc;">Batal</button>
        <button type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>

<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 99;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    justify-content: center;
    align-items: center;
  }
  .modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    width: 400px;
  }
</style>

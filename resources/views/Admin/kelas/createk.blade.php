<div class="modal" id="modalTambahKelas">
  <div class="modal-content">
    <h3>Tambah Kelas</h3>
    <form action="{{ route('admin.kelas.store') }}" method="POST">
      @csrf
      <input type="text" name="nama_kelas" placeholder="Nama Kelas" required>
      <input type="text" name="wali_kelas" placeholder="Wali Kelas" required>
      <input type="number" name="jumlah_siswa" placeholder="Jumlah Siswa" required min="0">
      <button type="submit">Simpan</button>
    </form>
  </div>
</div>
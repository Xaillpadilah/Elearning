<!-- File: resources/views/admin/siswa/partials/creates.blade.php -->
<div id="modalTambahSiswa" class="modal">
  <div class="modal-content">
    <h3>Tambah Data Siswa</h3>
    <form action="{{ route('admin.siswa.store') }}" method="POST">
      @csrf
      <input type="text" name="nama" placeholder="Nama" required>
      <input type="text" name="nisn" placeholder="NISN" required>
      <input type="text" name="kelas" placeholder="Kelas" required>
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit">💾 Simpan</button>
    </form>
  </div>
</div>
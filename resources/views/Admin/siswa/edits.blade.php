<!-- File: resources/views/admin/siswa/partials/edits.blade.php -->
<div id="modalEditSiswa" class="modal">
  <div class="modal-content">
    <h3>Edit Data Siswa</h3>
    <form id="formEditSiswa" method="POST">
      @csrf
      @method('PUT')
      <input type="text" id="edit-nama" name="nama" placeholder="Nama" required>
      <input type="text" id="edit-nisn" name="nisn" placeholder="NISN" required>
      <input type="text" id="edit-kelas" name="kelas" placeholder="Kelas" required>
      <input type="email" id="edit-email" name="email" placeholder="Email" required>
      <button type="submit">💾 Simpan Perubahan</button>
    </form>
  </div>
</div>
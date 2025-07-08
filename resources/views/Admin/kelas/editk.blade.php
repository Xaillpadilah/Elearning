<div class="modal" id="modalEditKelas">
  <div class="modal-content">
    <h3>Edit Kelas</h3>
    <form id="formEditKelas" method="POST">
      @csrf
      {{-- Metode spoofing untuk update --}}
      @method('POST')
      <input type="text" id="edit-nama-kelas" name="nama_kelas" placeholder="Nama Kelas" required>
      <input type="text" id="edit-wali-kelas" name="wali_kelas" placeholder="Wali Kelas" required>
      <input type="number" id="edit-jumlah-siswa" name="jumlah_siswa" placeholder="Jumlah Siswa" required min="0">
      <button type="submit">Perbarui</button>
    </form>
  </div>
</div>
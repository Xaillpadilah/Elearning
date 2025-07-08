<div class="modal" id="modalDeleteSiswa">
  <div class="modal-content">
    <h3>Konfirmasi Hapus</h3>
    <p>Apakah Anda yakin ingin menghapus siswa ini?</p>
    <form id="formDeleteSiswa" method="POST">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn-delete">🗑️ Hapus</button>
      <button type="button" onclick="closeDeleteModal()">Batal</button>
    </form>
  </div>
</div>

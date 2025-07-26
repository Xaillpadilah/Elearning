<div id="modalDelete" class="modal">
  <div class="modal-content">
    <h3>🗑️ Konfirmasi Hapus</h3>
    <p>Apakah Anda yakin ingin menghapus data ini?</p>
    <form id="formDelete" method="POST">
      @csrf
      @method('DELETE')
      <button type="submit">Ya, Hapus</button>
    </form>
  </div>
</div>
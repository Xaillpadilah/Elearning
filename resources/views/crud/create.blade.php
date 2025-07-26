<div id="modalTambah" class="modal">
  <div class="modal-content">
    <h3>➕ Tambah Data</h3>
    <form action="{{ $action }}" method="POST">
      @csrf
      {!! $form !!}
      <button type="submit">Simpan</button>
    </form>
  </div>
</div>
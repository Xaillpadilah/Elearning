<div id="modalEdit" class="modal">
  <div class="modal-content">
    <h3>✏️ Edit Data</h3>
    <form id="formEdit" method="POST">
      @csrf
      @method('PUT')
      {!! $form !!}
      <button type="submit">Update</button>
    </form>
  </div>
</div>
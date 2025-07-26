<form action="{{ $action }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px;">
  @csrf
  <input type="file" name="file" required class="btn-impor" style="background: white; color: black;">
  <button type="submit" class="btn-impor">📥 Impor Excel</button>
</form>
<div id="modalTambahGuru" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
  <div style="background:white; padding:30px; border-radius:12px; width:500px; position:relative;">
    <h3 style="margin-bottom: 20px; color:#4a148c;">➕ Tambah Guru Baru</h3>
    <form action="{{ route('admin.guru.store') }}" method="POST">
      @csrf
      <label>Nama</label>
      <input type="text" name="nama" required style="width:100%; padding:10px; border-radius:8px; margin-bottom:15px; border:1px solid #ccc;">

      <label>NIK</label>
      <input type="text" name="nik" required style="width:100%; padding:10px; border-radius:8px; margin-bottom:15px; border:1px solid #ccc;">

      <label>Mengajar</label>
      <input type="text" name="mengajar" required style="width:100%; padding:10px; border-radius:8px; margin-bottom:15px; border:1px solid #ccc;">

      <label>Email</label>
      <input type="email" name="email" required style="width:100%; padding:10px; border-radius:8px; margin-bottom:15px; border:1px solid #ccc;">

      <div style="display:flex; justify-content:space-between; gap:10px;">
        <button type="submit" class="btn-tambah" style="flex:1;">💾 Simpan</button>
        <button type="button" onclick="document.getElementById('modalTambahGuru').style.display='none'" class="btn-impor" style="flex:1;">❌ Batal</button>
      </div>
    </form>
  </div>
</div>
@if($siswaList->count())
  <form action="{{ route('guru.penilaian.store') }}" method="POST" class="input-nilai-form">
    @csrf
    <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
    <input type="hidden" name="mapel_id" value="{{ $mapel_id }}">

    <table>
      <thead>
        <tr>
          <th>Nama Siswa</th>
          <th>Tugas</th>
          <th>Kuis</th>
          <th>UTS</th>
          <th>UAS</th>
        </tr>
      </thead>
      <tbody>
        @foreach($siswaList as $siswa)
        <tr>
          <td>{{ $siswa->nama }}</td>
          <td><input type="number" name="nilai[{{ $siswa->id }}][tugas]" required></td>
          <td><input type="number" name="nilai[{{ $siswa->id }}][kuis]" required></td>
          <td><input type="number" name="nilai[{{ $siswa->id }}][uts]" required></td>
          <td><input type="number" name="nilai[{{ $siswa->id }}][uas]" required></td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <button type="submit" class="btn-simpan">💾 Simpan Nilai</button>
  </form>
@else
  <p style="color: red;">Tidak ada siswa di kelas ini.</p>
@endif

@if($soals->count())
<table class="table table-bordered">
  <thead>
    <tr>
      <th>No</th>
      <th>Pertanyaan</th>
      <th>Opsi A</th>
      <th>Opsi B</th>
      <th>Opsi C</th>
      <th>Opsi D</th>
      <th>Jawaban Benar</th>
      <th>Kelas - Mapel</th>
    </tr>
  </thead>
  <tbody>
    @foreach($soals as $soal)
      <tr>
        <td>{{ $soal->nomor }}</td>
        <td>{{ $soal->pertanyaan }}</td>
        <td>{{ $soal->opsi_a }}</td>
        <td>{{ $soal->opsi_b }}</td>
        <td>{{ $soal->opsi_c }}</td>
        <td>{{ $soal->opsi_d }}</td>
        <td>{{ $soal->jawaban_benar }}</td>
        <td>
          {{ $ujian->guruMapelKelas->kelas->nama_kelas ?? '-' }} - 
          {{ $ujian->guruMapelKelas->mapel->nama_mapel ?? '-' }}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@else
  <p>Tidak ada soal untuk ujian ini.</p>
@endif

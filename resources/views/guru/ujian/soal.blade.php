@foreach($soals as $soal)
  <tr>
    <td>{{ $soal->nomor }}</td>
    <td>{{ $soal->pertanyaan }}</td>
    <td>{{ $soal->opsi_a }}</td>
    <td>{{ $soal->opsi_b }}</td>
    <td>{{ $soal->opsi_c }}</td>
    <td>{{ $soal->opsi_d }}</td>
    <td>{{ $soal->jawaban_benar }}</td>
  </tr>
@endforeach
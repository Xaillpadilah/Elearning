<h3>Jadwal Kelas {{ $kelas->nama_kelas }}</h3>

@if($jadwals->count())
  <table border="1" cellpadding="8" cellspacing="0">
    <thead>
      <tr>
        <th>Hari</th>
        <th>Jam</th>
        <th>Mata Pelajaran</th>
        <th>Guru</th>
      </tr>
    </thead>
    <tbody>
      @foreach($jadwals as $j)
        <tr>
          <td>{{ $j->hari }}</td>
          <td>{{ $j->jam }}</td>
          <td>{{ $j->mapel->nama_mapel ?? '-' }}</td>
          <td>{{ $j->guru->nama ?? '-' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@else
  <p>Belum ada jadwal untuk kelas ini.</p>
@endif

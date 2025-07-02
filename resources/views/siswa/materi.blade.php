<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $mapel['nama'] }} - Materi</title>
  @vite(['resources/css/app.css'])
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      display: flex;
      min-height: 100vh;
      background: linear-gradient(to bottom right, #f3f4f6, #e0f7fa);
    }
    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #ffffff, #e3f2fd);
      height: 100vh;
      padding: 20px;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
      position: fixed;
      overflow-y: auto;
    }
    .sidebar h2 {
      color: #4a148c;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 35px;
    }
    .sidebar ul { list-style: none; padding: 0; }
    .sidebar ul li { margin: 14px 0; }
    .sidebar ul li a {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      color: #333;
      text-decoration: none;
      font-weight: 500;
      border-radius: 10px;
      transition: background 0.3s, color 0.3s;
    }
    .sidebar ul li a:hover,
    .sidebar ul li a.active {
      background: linear-gradient(to right, #bbdefb, #d1c4e9);
      color: #4a148c;
    }
    .sub-mapel {
      margin-top: 10px;
      margin-left: 12px;
      border-left: 2px solid #e0e0e0;
      padding-left: 10px;
    }
    .sub-mapel li a {
      font-size: 14px;
      padding: 6px 0;
      color: #444;
      display: block;
    }
    .sub-mapel li a.active {
      color: #4a148c;
      font-weight: 600;
    }
    .sub-mapel li a:hover { color: #6a1b9a; }
    .main {
      margin-left: 270px;
      flex: 1;
      padding: 40px;
    }
    .card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f0f0f0;
    }
    a.btn-kembali {
      display: inline-block;
      margin-bottom: 20px;
      background: #6c757d;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      text-decoration: none;
    }
    a.btn-kembali:hover {
      background: #5a6268;
    }
  </style>
</head>
<body>

 <div class="sidebar">
  <h2>E-LEARNING</h2>
  <ul>
    <li><a href="{{ route('siswa.dashboard') }}">🏠 Beranda</a></li>
    <li>
      <a href="javascript:void(0)">📚 Mata Pelajaran</a>
      <ul class="sub-mapel">
        @foreach($mataPelajaran as $m)
          <li>
            <a href="{{ route('siswa.matapelajaran.materi', $m['id']) }}"
               class="{{ $m['id'] == request()->route('id') ? 'active' : '' }}">
              📘 {{ $m['nama'] }}
            </a>
          </li>
        @endforeach
      </ul>
    </li>
    <li><a href="{{ route('siswa.absensi') }}">📸 Absensi</a></li>
    <li><a href="{{ route('siswa.nilai') }}">📊 Nilai Akhir</a></li>
  </ul>
</div>

  <!-- Konten -->
  <div class="main">
    <a href="{{ url()->previous() }}" class="btn-kembali">← Kembali</a>

    <div class="card">
      <h2>{{ $mapel['kode'] }} - {{ $mapel['nama'] }} ({{ $mapel['sks'] }} SKS)</h2>
      <p>
        🏫 {{ $mapel['ruangan'] }}<br>
        👤 {{ $mapel['Guru'] }}<br>
        ✉️ {{ $mapel['email'] }}<br>
        <strong>{{ $mapel['hari'] }}</strong> - {{ $mapel['jam'] }}
      </p>
    </div>

    <div class="card">
      <h3>Materi</h3>
      <table>
        <thead>
          <tr>
            <th>Pertemuan</th>
            <th>Materi Terlampir</th>
            <th>Tanggal Unggah</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($materis as $m)
            <tr>
              <td>{{ $m['pertemuan'] }}</td>
              <td><a href="{{ $m['link'] }}" target="_blank">Link Materi</a></td>
              <td>{{ $m['tanggal'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>

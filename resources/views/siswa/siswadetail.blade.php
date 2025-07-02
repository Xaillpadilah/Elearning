<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $mapel['nama'] }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
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
      transition: all 0.3s ease;
    }

    .hidden { display: none !important; }

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

    .info {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 24px;
      margin-top: 30px;
    }

    .menu-box {
      background: linear-gradient(145deg, #f5f7fa, #e4ecf2);
      border-radius: 14px;
      padding: 24px 20px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
      text-align: center;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      cursor: pointer;
    }

    .menu-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .menu-box .icon {
      font-size: 38px;
      margin-bottom: 12px;
    }

    .menu-box .title {
      font-size: 17px;
      font-weight: 600;
      margin-bottom: 14px;
      color: #2c3e50;
    }

    .menu-box a {
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      color: #1a237e;
      display: inline-flex;
      align-items: center;
      transition: color 0.3s;
    }

    .menu-box a:hover {
      color: #0d47a1;
    }

    .menu-box .arrow {
      margin-left: 6px;
      transition: transform 0.3s ease;
    }

    .menu-box a:hover .arrow {
      transform: translateX(3px);
    }

    footer {
      position: fixed;
      bottom: 0;
      left: 270px;
      width: calc(100% - 270px);
      background: #eceff1;
      color: #333;
      padding: 12px 30px;
      text-align: center;
      font-size: 14px;
      transition: left 0.3s ease, width 0.3s ease;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>E-LEARNING</h2>
    <ul>
      <li><a href="{{ route('siswa.dashboard') }}">🏠 Beranda</a></li>
      <li>
        <a href="javascript:void(0)" onclick="toggleMapel()">📚 Mata Pelajaran</a>
        <ul class="sub-mapel" id="sub-mapel">
          @foreach($mataPelajaran as $m)
            <li>
              <a href="{{ route('siswa.matapelajaran.show', $m['id']) }}"
                 class="{{ $m['id'] == request()->route('id') ? 'active' : '' }}">
                📘 {{ $m['nama'] }}
              </a>
            </li>
          @endforeach
        </ul>
      </li>
       <li><a href="{{ route('siswa.absensi') }}">📸 Absensi</a></li>
    <li><a href="{{ route('siswa.nilai') }}" >📊 Nilai Akhir</a></li>
    </ul>
  </div>

  <!-- Main -->
  <div class="main">
    <div class="card">
      <h2>{{ $mapel['kode'] }} / {{ $mapel['nama'] }} ({{ $mapel['sks'] }} SKS)</h2>
      <div class="info">
        <div>🏫 {{ $mapel['ruangan'] }}</div>
        <div>👤 {{ $mapel['Guru'] }}</div>
        <div>✉️ {{ $mapel['email'] }}</div>
        <div><strong>{{ $mapel['hari'] }}</strong><br>{{ $mapel['jam'] }}</div>
      </div>
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid">
      <div class="menu-box">
        <div class="icon">📘</div>
        <div class="title">Materi</div>
        <a href="{{ route('siswa.matapelajaran.materi', $mapel['id']) }}">
          Lihat Lebih <span class="arrow">→</span>
        </a>
      </div>

      <div class="menu-box">
        <div class="icon">📝</div>
        <div class="title">Tugas</div>
        <a href="/siswa/Dashboard/fitur/tugas/tugas-hari-ini">Lihat Lebih <span class="arrow">→</span></a>
      </div>

      <div class="menu-box">
        <div class="icon">📄</div>
        <div class="title">Ujian</div>
        <a href="#">Lihat Lebih <span class="arrow">→</span></a>
      </div>

      <div class="menu-box">
        <div class="icon">🎥</div>
        <div class="title">Modul Video</div>
        <a href="#">Lihat Lebih <span class="arrow">→</span></a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; {{ date('Y') }} E-Learning SMP NEGERI 5 CIDAUN
  </footer>

  <script>
    function toggleMapel() {
      const subMapel = document.getElementById('sub-mapel');
      subMapel.style.display = subMapel.style.display === 'block' ? 'none' : 'block';
    }
  </script>
</body>
</html>

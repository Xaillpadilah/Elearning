<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nilai Terbaru</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* CSS ada di bawah */
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #e1f5fe, #f3e5f5);
  padding: 30px;
}

.main {
  max-width: 600px;
  margin: auto;
}

.card-container {
  background: #ffffff;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  padding: 30px;
  animation: fadeIn 0.6s ease;
}

.header {
  display: flex;
  align-items: center;
  margin-bottom: 25px;
}

.icon {
  font-size: 36px;
  background-color: #c5cae9;
  color: #1a237e;
  padding: 12px;
  border-radius: 50%;
  margin-right: 15px;
  animation: pulse

  </style>
</head>
<body>
  <div class="main">
    <div class="card-container">
      <div class="header">
        <div class="icon">📊</div>
        <div class="title">
          <h2>Nilai Terbaru</h2>
          <p>Performa akademik Anda saat ini</p>
        </div>
      </div>

      <div class="nilai-box">
        <h4>Mata Pelajaran</h4>
        <p class="mapel">{{ $nilaiTerbaru['mapel'] }}</p>
        <h4>Nilai</h4>
        <div class="nilai">{{ $nilaiTerbaru['nilai'] }}</div>
      </div>
    </div>
  </div>
</body>
</html>

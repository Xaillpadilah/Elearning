<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pelajaran Selanjutnya</title>
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
  background: linear-gradient(135deg, #fce4ec, #e3f2fd);
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
  background-color: #b2dfdb;
  color: #004d40;
  padding: 12px;
  border-radius: 50%;
  margin-right: 15px;
  animation: slide 1s infinite alternate;
}

.title h2 {
  color: #00695c;
  font-size: 24px;
  font-weight: 600;
}

.title p {
  color: #555;
  font-size: 14px;
  margin-top: 4px;
}

.next-box {
  background-color: #e0f2f1;
  border-left: 6px solid #00796b;
  padding: 20px;
  border-radius: 12px;
  transition: background 0.3s ease;
}

.next-box:hover {
  background-color: #b2dfdb;
}

.next-box h4 {
  font-size: 16px;
  font-weight: 600;
  color: #004d40;
  margin-bottom: 6px;
}

.next-box .jam,
.next-box .mapel {
  font-size: 18px;
  colo

  </style>
</head>
<body>
  <div class="main">
    <div class="card-container">
      <div class="header">
        <div class="icon">⏭️</div>
        <div class="title">
          <h2>Pelajaran Selanjutnya</h2>
          <p>Persiapkan diri untuk kelas berikutnya</p>
        </div>
      </div>

      <div class="next-box">
        <h4>Jam</h4>
        <p class="jam">{{ $pelajaranSelanjutnya['jam'] }}</p>
        <h4>Pelajaran</h4>
        <p class="mapel">{{ $pelajaranSelanjutnya['mapel'] }}</p>
      </div>
    </div>
  </div>
</body>
</html>

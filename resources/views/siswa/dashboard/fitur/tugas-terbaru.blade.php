<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tugas Terbaru</title>
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
  background: linear-gradient(135deg, #e0f7fa, #fce4ec);
  padding: 30px;
}

.main {
  max-width: 650px;
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
  background-color: #d1c4e9;
  color: #4a148c;
  padding: 12px;
  border-radius: 50%;
  margin-right: 15px;
  animation: bounce 1s infinite alternate;
}

.title h2 {
  color: #4a148c;
  font-size: 24px;
  font-weight: 600;
}

.title p {
  color: #666;
  font-size: 14px;
  margin-top: 4px;
}

.latest-task {
  background-color: #f3e5f5;
  border-left: 6px solid #7b1fa2;
  padding: 20px;
  border-radius: 12px;
  transition: background 0.3s ease;
}

.latest-task:hover {
  background-color: #e1bee7;
}

.latest-task h4 {
  font-size: 16px;
  font-weight: 600;
  color: #6a1b9a;
  margin-bottom: 6px;
}

.latest-task .mapel,
.latest-task .judul {
  font-size: 16px;
  color: #333;
  margin-bottom: 14px;
}

.latest-task .note {
  font-size: 14px;
  color: #555;
  font-style: italic;
}

/* Animasi */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes bounce {
  from { transform: translateY(0); }
  to { transform: translateY(-5px); }
}

  </style>
</head>
<body>
  <div class="main">
    <div class="card-container">
      <div class="header">
        <div class="icon">🆕</div>
        <div class="title">
          <h2>Tugas Terbaru</h2>
          <p>Segera kerjakan tugas terbaru yang diberikan</p>
        </div>
      </div>

      <div class="latest-task">
        <h4>Mata Pelajaran</h4>
        <p class="mapel">{{ $tugasTerbaru['mapel'] }}</p>
        <h4>Judul Tugas</h4>
        <p class="judul"><strong>{{ $tugasTerbaru['judul'] }}</strong></p>
        <p class="note">Silakan kerjakan tugas ini sebelum deadline yang ditentukan.</p>
      </div>
    </div>
  </div>
</body>
</html>

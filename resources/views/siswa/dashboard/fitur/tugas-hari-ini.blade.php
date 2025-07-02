<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tugas Hari Ini</title>
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
  background: linear-gradient(135deg, #fce4ec, #e1f5fe);
  padding: 30px;
}

.main {
  max-width: 700px;
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
  background-color: #ffe0b2;
  color:rgb(110, 7, 71);
  padding: 12px;
  border-radius: 50%;
  margin-right: 15px;
  animation: bounce 1s infinite alternate;
}

.title h2 {
  color:rgb(146, 6, 111);
  font-size: 24px;
  font-weight: 600;
}

.title p {
  color: #555;
  font-size: 14px;
  margin-top: 4px;
}

.task-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.task-item {
  background-color: #fff3e0;
  border-left: 6px solidrgb(185, 15, 100);
  padding: 16px 20px;
  border-radius: 12px;
  transition: transform 0.3s ease, background 0.3s;
}

.task-item:hover {
  transform: scale(1.02);
  background-color: #ffe0b2;
}

.task-item h4 {
  color:rgb(95, 18, 139);
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 6px;
}

.task-item p {
  font-size: 14px;
  color: #444;
}

/* Animasi */
@keyframes fadeIn {
  from {opacity: 0; transform: translateY(20px);}
  to {opacity: 1; transform: translateY(0);}
}

@keyframes bounce {
  from {transform: translateY(0);}
  to {transform: translateY(-5px);}
}

  </style>
</head>
<body>
  <div class="main">
    <div class="card-container">
      <div class="header">
        <div class="icon">📝</div>
        <div class="title">
          <h2>Tugas Hari Ini</h2>
          <p>Total <strong>{{ $tugasHariIni }}</strong> tugas yang harus diselesaikan</p>
        </div>
      </div>

      <div class="task-list">
        <div class="task-item">
          <h4>Matematika</h4>
          <p>Kerjakan soal Bab 2</p>
        </div>
        <div class="task-item">
          <h4>IPA</h4>
          <p>Lengkapi laporan praktikum</p>
        </div>
        <!-- Tambahkan tugas lainnya di sini -->
      </div>
    </div>
  </div>
</body>
</html>

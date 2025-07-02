<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Jadwal Mingguan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* CSS di bawah */
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
  max-width: 750px;
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
  background-color: #e1bee7;
  color: #6a1b9a;
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

.schedule-week {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.day-box {
  background-color: #f3e5f5;
  border-left: 6px solid #8e24aa;
  padding: 16px 20px;
  border-radius: 12px;
  transition: transform 0.3s ease, background 0.3s;
}

.day-box:hover {
  transform: scale(1.02);
  background-color: #ede7f6;
}

.day-box h4 {
  color: #4a148c;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 6px;
}

.day-box p {
  font-size: 14px;
  color: #555;
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

@media (max-width: 600px) {
  .schedule-week {
    grid-template-columns: 1fr;
  }
}

  </style>
</head>
<body>
  <div class="main">
    <div class="card-container">
      <div class="header">
        <div class="icon">🗓️</div>
        <div class="title">
          <h2>Jadwal Mingguan</h2>
          <p>Total <strong>{{ $jadwalMingguan }}</strong> kelas minggu ini</p>
        </div>
      </div>

      <div class="schedule-week">
        <div class="day-box">
          <h4>Senin</h4>
          <p>Matematika, Bahasa Inggris</p>
        </div>
        <div class="day-box">
          <h4>Selasa</h4>
          <p>IPA, IPS</p>
        </div>
        <div class="day-box">
          <h4>Rabu</h4>
          <p>PPKn</p>
        </div>
        <!-- Tambahkan hari lainnya jika perlu -->
      </div>
    </div>
  </div>
</body>
</html>

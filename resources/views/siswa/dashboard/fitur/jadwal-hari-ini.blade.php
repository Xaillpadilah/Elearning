<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Jadwal Hari Ini</title>
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
  max-width: 700px;
  margin: 0 auto;
}

.card-container {
  background: #ffffff;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  padding: 30px;
  animation: fadeIn 0.6s ease;
  transition: box-shadow 0.3s;
}

.card-container:hover {
  box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.header {
  display: flex;
  align-items: center;
  margin-bottom: 25px;
}

.icon {
  font-size: 36px;
  background-color: #ede7f6;
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

.schedule-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.schedule-item {
  background: #f3e5f5;
  border-left: 6px solid #8e24aa;
  padding: 15px 20px;
  border-radius: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: transform 0.2s;
}

.schedule-item:hover {
  transform: scale(1.02);
}

.schedule-info .subject {
  font-size: 16px;
  font-weight: 600;
  color: #4a148c;
}

.schedule-info .time {
  font-size: 14px;
  color: #555;
}

.badge {
  padding: 6px 14px;
  font-size: 12px;
  border-radius: 20px;
  color: #fff;
  font-weight: 500;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.badge.wajib {
  background-color: #7b1fa2;
}

.badge.online {
  background-color: #388e3c;
}

/* Animasi */
@keyframes fadeIn {
  from {opacity: 0; transform: translateY(20px);}
  to {opacity: 1; transform: translateY(0);}
}

@keyframes

  </style>
</head>
<body>
  <div class="main">
    <div class="card-container">
      <div class="header">
        <div class="icon">
          📅
        </div>
        <div class="title">
          <h2>Jadwal Hari Ini</h2>
          <p>Total <strong>{{ $jadwalHariIni }}</strong> kelas hari ini</p>
        </div>
      </div>

      <div class="schedule-list">
        <div class="schedule-item">
          <div class="schedule-info">
            <div class="subject">Matematika</div>
            <div class="time">08:00 - 09:30</div>
          </div>
          <span class="badge wajib">Wajib</span>
        </div>

        <div class="schedule-item">
          <div class="schedule-info">
            <div class="subject">Bahasa Indonesia</div>
            <div class="time">10:00 - 11:30</div>
          </div>
          <span class="badge online">Online</span>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

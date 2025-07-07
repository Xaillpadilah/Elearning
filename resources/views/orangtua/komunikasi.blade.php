<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Komunikasi dengan Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f3f4f6;
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #ffffff, #e3f2fd);
      height: 100vh;
      padding: 20px;
      position: fixed;
      overflow-y: auto;
    }
    .sidebar h2 {
      color: #388e3c;
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
      color: #222;
      text-decoration: none;
      font-weight: 500;
      border-radius: 12px;
    }
    .sidebar ul li a:hover,
    .sidebar ul li a.active {
      background: linear-gradient(to right, #c8e6c9, #b3e5fc);
      color: #2e7d32;
    }

    .main {
      margin-left: 270px;
      flex: 1;
      padding: 30px 40px 80px;
      background: linear-gradient(to bottom right, #f3f4f6, #e0f7fa);
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .chat-box {
      background: #ffffff;
      border: 2px solid #aed581;
      border-radius: 12px;
      padding: 20px;
      height: 500px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .message {
      max-width: 70%;
      padding: 10px 14px;
      border-radius: 12px;
      font-size: 14px;
      line-height: 1.5;
    }

    .message.user {
      background: #c8e6c9;
      align-self: flex-end;
    }

    .message.guru {
      background: #e1f5fe;
      align-self: flex-start;
    }

    .send-form {
      display: flex;
      margin-top: 15px;
      gap: 10px;
    }

    .send-form input[type="text"] {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    .send-form button {
      padding: 10px 20px;
      background: #4caf50;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    footer {
      position: fixed;
      bottom: 0;
      left: 270px;
      width: calc(100% - 270px);
      background: #f1f8e9;
      color: #333;
      padding: 12px 30px;
      text-align: center;
      font-size: 14px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h2>Dashboard Orang Tua</h2>
  <ul>
    <li><a href="{{ route('orangtua.dashboard') }}">🏠 Dashboard</a></li>
    <li><a href="{{ route('orangtua.hasil') }}">📊 Hasil</a></li>
    <li><a href="{{ route('orangtua.perkembangan') }}">📈 Perkembangan</a></li>
    <li><a href="{{ route('orangtua.komunikasi') }}" class="active">💬 Komunikasi</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main">
  <div class="header">
    <h3>💬 Komunikasi dengan Guru</h3>
    <div class="user">👨‍👩‍👧 {{ $user->name ?? 'Orang Tua' }}</div>
  </div>

  <!-- Chat Box -->
  <div class="chat-box">
    @foreach($chats as $chat)
      <div class="message {{ $chat->from == 'orangtua' ? 'user' : 'guru' }}">
        <strong>{{ $chat->from == 'orangtua' ? 'Anda' : 'Guru' }}:</strong><br>
        {{ $chat->message }}
        <div style="font-size: 11px; color: #666; margin-top: 4px;">{{ $chat->created_at->format('H:i d/m') }}</div>
      </div>
    @endforeach
  </div>

  <!-- Chat Form -->
  <form action="{{ route('orangtua.kirimPesan') }}" method="POST" class="send-form">
    @csrf
    <input type="text" name="message" placeholder="Ketik pesan ke guru..." required />
    <button type="submit">Kirim</button>
  </form>
</div>

<!-- Footer -->
<footer>
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN - Komunikasi.
</footer>

</body>
</html>

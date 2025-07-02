<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #dceeff, #f0f2f5);
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
    }

    .login-box {
      display: flex;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
      max-width: 950px;
      width: 90%;
      transition: transform 0.3s ease;
    }

    .login-box:hover {
      transform: scale(1.01);
    }

    .login-form {
      flex: 1;
      padding: 50px 40px;
    }

    .login-form h2 {
      font-size: 32px;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .login-form p {
      font-size: 15px;
      color: #555;
      margin-bottom: 25px;
    }

    .login-form input,
    .login-form button {
      width: 100%;
      padding: 14px 16px;
      margin: 12px 0;
      font-size: 15px;
      border-radius: 10px;
      box-sizing: border-box;
      display: block;
    }

    .login-form input {
      border: 1px solid #ccc;
      background-color: #f9f9f9;
      transition: border 0.3s ease;
    }

    .login-form input:focus {
      outline: none;
      border-color: #2d9cdb;
      box-shadow: 0 0 0 3px rgba(45, 156, 219, 0.1);
    }

    .login-form button {
      background-color: #2d9cdb;
      color: #fff;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-form button:hover {
      background-color: #1b7dbb;
    }

    .login-image {
      flex: 2; /* Membesarkan area gambar */
      background: url('{{ asset('assets/image/bbg.png') }}') center/contain no-repeat;
      background-color: #e4f2ff;
      border-left: 1px solid #eef6ff;
    }

    .whatsapp-float {
      position: fixed;
      right: 20px;
      bottom: 20px;
      background-color: #25d366;
      color: white;
      border-radius: 50px;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      z-index: 999;
      transition: background-color 0.3s ease;
    }

    .whatsapp-float:hover {
      background-color: #1ebe5b;
    }

    .whatsapp-float img {
      width: 24px;
      height: 24px;
    }

    .whatsapp-float span {
      font-weight: 600;
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .login-box {
        flex-direction: column;
        border-radius: 12px;
      }

      .login-image {
        flex: none;
        height: 180px;
        border-left: none;
        border-bottom: 1px solid #eef6ff;
      }

      .login-form {
        padding: 30px 20px;
      }

      .login-form h2 {
        font-size: 26px;
      }

      .whatsapp-float {
        right: 10px;
        bottom: 10px;
        padding: 8px 12px;
      }

      .whatsapp-float span {
        display: none;
      }
    }
  </style>
</head>
<body>
  @yield('content')
</body>
</html>

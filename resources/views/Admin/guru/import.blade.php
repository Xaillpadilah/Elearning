<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Import Data Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background-color: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      width: 400px;
    }
    h2 {
      text-align: center;
      margin-bottom: 24px;
      color: #333;
    }
    input[type="file"] {
      display: block;
      width: 100%;
      margin-bottom: 16px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
    }
    button:hover {
      background-color: #0056b3;
    }
    .alert {
      padding: 10px;
      margin-bottom: 16px;
      border-radius: 6px;
      font-size: 14px;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }
    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Import Data Guru</h2>

    {{-- Sukses --}}
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    {{-- Error --}}
    @if($errors->any())
      <div class="alert alert-error">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <label for="file">Pilih File Excel:</label>
      <input type="file" name="file" id="file" required>

      <button type="submit">Import Sekarang</button>
    </form>
  </div>
</body>
</html>

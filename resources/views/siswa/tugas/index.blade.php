<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tugas & Kuis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

          body {
        background-color: #f9f9f9;
        font-family: 'Segoe UI', sans-serif;
    }

    h2 {
        font-weight: bold;
        margin-bottom: 30px;
        color: #2c3e50;
    }

    .card {
        border: none;
        border-left: 6px solid #0d6efd;
        transition: transform 0.2s ease;
        background-color: #ffffff;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        color: #0d6efd;
        font-weight: 600;
    }

    .badge.bg-success {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 12px;
    }

    .alert {
        border-left: 5px solid #0d6efd;
    }

    .btn-info {
        background-color: #0dcaf0;
        border: none;
    }

    .btn-success {
        background-color: #198754;
        border: none;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    hr {
        border-top: 2px solid #0d6efd;
    }

    label {
        font-weight: 500;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        padding: 10px 20px;
    }

    .btn-sm {
        margin-top: 10px;
        margin-right: 5px;
    }
      .card-small {
        font-size: 0.9rem;
        padding: 15px;
        border-left: 5px solid #0d6efd;
        background-color: #ffffff;
        transition: transform 0.2s ease;
        height: 100%;
    }

    .card-small:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
    }

    .card-small .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #0d6efd;
    }

    .card-small p {
        margin-bottom: 6px;
        color: #555;
    }

    .card-small .btn-sm {
        font-size: 0.8rem;
        padding: 4px 10px;
    }

    .badge.bg-success {
        font-size: 0.7rem;
        padding: 5px 10px;
    }

    .tugas-grid .col-md-6 {
        padding: 8px;
    }

    @media (min-width: 768px) {
        .tugas-grid .col-md-6 {
            flex: 0 0 auto;
            width: 33.3333%;
        }
    }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>📚 Tugas & Kuis</h2>

  {{-- Tugas Section --}}
<div id="tugas" class="tab-content">
    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Daftar Tugas --}}
    @if ($tugasList->isEmpty())
        <div class="alert alert-info">Tidak ada tugas atau kuis yang tersedia saat ini.</div>
    @else
        <div class="row tugas-grid">
            @foreach ($tugasList as $item)
                @php
                    $sudahDikerjakan = \App\Models\JawabanTugas::where('tugas_id', $item->id)
                        ->where('siswa_id', auth()->id())->exists();
                @endphp

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card card-small shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p>{{ Str::limit($item->deskripsi, 100) }}</p>
                            <p>Jenis: <strong>{{ ucfirst($item->jenis) }}</strong></p>
                            <p>Deadline: {{ \Carbon\Carbon::parse($item->tanggal_deadline)->translatedFormat('d M Y') }}</p>

                            <a href="javascript:void(0)" onclick="openPopup('{{ route('siswa.tugas.index', ['kerjakan' => $item->id]) }}')" class="btn btn-sm btn-success">Kerjakan</a>

                            @if($sudahDikerjakan)
                                <span class="badge bg-success ms-2">✅ Sudah Dikerjakan</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Detail Tugas Jika Ada --}}
    @if ($tugas)
        <hr>
        <h3>📝 {{ $tugas->judul }}</h3>

        @if ($soal)
            <form method="POST" action="{{ route('siswa.tugas.submit', $tugas->id) }}">
                @csrf
                @foreach ($soal as $index => $s)
                    <div class="mb-3">
                        <label><strong>Soal {{ $index + 1 }}:</strong> {{ $s['pertanyaan'] }}</label>
                        <input type="text" name="jawaban[{{ $index }}]" class="form-control" required>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
            </form>
        @elseif ($tugas->file_path)
            <p>📎 Tugas berbentuk file. Silakan unduh & kerjakan lalu unggah hasilnya:</p>
            <a href="{{ asset('storage/' . $tugas->file_path) }}" class="btn btn-sm btn-info">📥 Unduh File</a>

            <form method="POST" action="{{ route('siswa.tugas.submit', $tugas->id) }}" enctype="multipart/form-data" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label for="file_jawaban">📤 Upload File Jawaban</label>
                    <input type="file" name="file_jawaban" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Kirim Jawaban</button>
            </form>
        @else
            <p>Tugas ini tidak memiliki soal atau file.</p>
        @endif
    @endif
</div>
</div>
<script>
    function openPopup(url) {
        document.getElementById('popupModal').style.display = 'block';
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('popupContent').innerHTML = html;
            })
            .catch(err => {
                document.getElementById('popupContent').innerHTML = '<p>Error loading content</p>';
                console.error(err);
            });
    }

    function closePopup() {
        document.getElementById('popupModal').style.display = 'none';
        document.getElementById('popupContent').innerHTML = '';
    }
</script>
</body>
</html>

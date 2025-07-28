<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Ujian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Jika menggunakan Bootstrap (optional): --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            padding: 30px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Daftar Ujian</h2>

        @if($ujians->isEmpty())
            <div class="alert alert-warning">
                Tidak ada ujian yang tersedia saat ini.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Tipe Ujian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ujians as $index => $ujian)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ujian->judul }}</td>
                                <td>{{ \Carbon\Carbon::parse($ujian->tanggal)->format('d M Y') }}</td>
                                <td>{{ $ujian->keterangan }}</td>
                                <td>{{ ucfirst($ujian->tipe_ujian) }}</td>
                                <td>
                                    @if($ujian->file_soal)
                                        <a href="{{ asset('storage/' . $ujian->file_soal) }}" target="_blank" class="btn btn-sm btn-primary">
                                            Lihat Soal
                                        </a>
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada file</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>

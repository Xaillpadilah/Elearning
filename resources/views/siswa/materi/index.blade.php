<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Materi Pembelajaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7fc;
            padding: 30px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
            color: #2d3748;
        }

        .alert {
            padding: 15px;
            background-color: #edf2f7;
            border-left: 4px solid #4299e1;
            border-radius: 6px;
            color: #2d3748;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f7fafc;
            font-weight: 600;
            color: #2d3748;
        }

        td a {
            color: #3182ce;
            text-decoration: none;
            font-weight: 500;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <h2>
        📘 Materi Pembelajaran
        @if(isset($mapel))
            - {{ $mapel->nama_mapel }} (Kelas {{ auth()->user()->kelas->nama_kelas ?? '-' }})
        @else
            Kelas {{ auth()->user()->kelas->nama_kelas ?? '-' }}
        @endif
    </h2>

    @if ($materis->isEmpty())
        <div class="alert">Belum ada materi yang tersedia untuk mata pelajaran ini.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tipe Konten</th>
                    <th>File</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materis as $materi)
                    <tr>
                        <td>{{ $materi->judul }}</td>
                        <td>{{ $materi->deskripsi }}</td>
                        <td>{{ ucfirst($materi->tipe_konten) }}</td>
                        <td>
                            @if ($materi->file_path)
                                <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank">📄 Lihat</a>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>
                            @if ($materi->link)
                                <a href="{{ $materi->link }}" target="_blank">🔗 Kunjungi</a>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>

</html>
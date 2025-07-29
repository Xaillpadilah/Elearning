<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Jawaban Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eef5fb;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h2 {
            color: #007bff;
            margin-bottom: 25px;
            text-align: center;
        }

        h3 {
            color: #0056b3;
            margin-bottom: 15px;
        }

        .table-container {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 40px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th, td {
            padding: 14px 18px;
            border: 1px solid #e0e0e0;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: normal;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e9f2ff;
        }

        a {
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .empty-row {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #888;
        }

        @media (max-width: 768px) {
            th, td {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>

    <h2>Daftar Jawaban Siswa</h2>

    <!-- Jawaban Tugas -->
    <div class="table-container">
        <h3>Jawaban Tugas</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Nama Tugas</th>
                    <th>File Jawaban</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jawabanTugas as $jawaban)
                    <tr>
                        <td>{{ $jawaban->siswa->user->name ?? '-' }}</td>
                        <td>{{ $jawaban->tugas->judul ?? '-' }}</td>
                        <td>
                            @if($jawaban->file_jawaban)
                                <a href="{{ asset('storage/' . $jawaban->file_jawaban) }}" target="_blank">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $jawaban->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-row">Belum ada jawaban tugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Jawaban Ujian -->
    <div class="table-container">
        <h3>Jawaban Ujian</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Nama Ujian</th>
                    <th>File Jawaban</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jawabanUjian as $jawaban)
                    <tr>
                        <td>{{ $jawaban->user->name ?? '-' }}</td>
                        <td>{{ $jawaban->ujian->judul ?? '-' }}</td>
                        <td>
                            @if($jawaban->file_path)
                                <a href="{{ asset('storage/' . $jawaban->file_path) }}" target="_blank">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $jawaban->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-row">Belum ada jawaban ujian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>

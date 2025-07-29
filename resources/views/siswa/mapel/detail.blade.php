<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Mapel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  @vite(['resources/css/siswa.css'])
<style>
    <style>
    .tab-button {
        @apply px-4 py-2 rounded-t-lg bg-gray-200 hover:bg-gray-300 transition-all duration-200 ease-in-out;
    }

    .tab-button.active {
        @apply bg-blue-600 text-white font-semibold;
    }

    .tab-content {
        @apply bg-white p-4 rounded-lg shadow-md;
    }

    .tab-content.hidden {
        display: none;
    }

    .main-content {
        @apply p-6 bg-gray-50 rounded-lg shadow-md;
    }

    ul.list-disc li {
        @apply leading-relaxed;
    }

    a.text-blue-500:hover, a.text-blue-600:hover, a.text-red-500:hover, a.text-green-500:hover {
        @apply underline font-semibold;
    }
#materi.tab-content { background-color: #8ba7f3ff; } /* kuning muda */
#tugas.tab-content { background-color: #e0f2fe; }  /* biru muda */
#ujian.tab-content { background-color: #fce7f3; }  /* pink muda */
<style>
    .info-mapel {
        @apply bg-white shadow-md rounded-lg p-4 border-l-4 border-blue-600 mb-6;
    }

    .info-mapel h2 {
        @apply text-2xl font-bold text-blue-700 mb-2;
    }

    .info-mapel .info-detail {
        @apply text-base font-medium text-gray-700;
    }

    .info-mapel .info-sub {
        @apply text-sm text-gray-600;
    }
    .info-mapel {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.info-mapel:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}
 .tab-button {
        @apply px-4 py-2 rounded-full font-semibold transition duration-200;
        @apply bg-gray-200 text-gray-700 hover:bg-gray-300;
    }

    .tab-button.active {
        background-color: #2563eb; /* bg-blue-600 */
        color: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    /* Warna tab spesifik per jenis (materi/tugas/ujian) saat aktif */
    #tabMateri.active {
        background-color: #332991ff; /* emerald-500 */
    }

    #tabTugas.active {
        background-color: #190a72ff; /* amber-500 */
    }

    #tabUjian.active {
        background-color: #3616acff; /* red-500 */
    }
    #materi {
    font-family: 'Segoe UI', sans-serif;
}

/* Dropdown details */
#materi details {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

/* Saat dropdown dibuka */
#materi details[open] {
    background-color: #fff;
    border-color: #cbd5e1;
}

/* Summary (judul dropdown) */
#materi summary {
    list-style: none; /* hilangkan default marker */
    outline: none;
    position: relative;
    padding-left: 1.5rem;
}

#materi summary::before {
    content: "▶";
    position: absolute;
    left: 0;
    top: 3px;
    font-size: 1rem;
    transition: transform 0.3s ease;
}

#materi details[open] summary::before {
    transform: rotate(90deg);
}

/* List item tanpa bullet */
#materi ul {
    list-style-type: none;
    padding-left: 0;
}

#materi li {
    background-color: #f1f5f9;
    padding: 10px 15px;
    margin-bottom: 8px;
    border-radius: 6px;
    transition: background-color 0.2s;
}

#materi li:hover {
    background-color: #e2e8f0;
}

/* Link file dan link web */
#materi a {
    text-decoration: none;
    font-weight: 500;
}

#materi a:hover {
    text-decoration: underline;
    color: #1d4ed8;
}
#tugas {
    font-family: 'Segoe UI', sans-serif;
}

/* Dropdown details */
#tugas details {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

#tugas details[open] {
    background-color: #fff;
    border-color: #cbd5e1;
}

/* Summary Title */
#tugas summary {
    list-style: none;
    outline: none;
    position: relative;
    padding-left: 1.5rem;
    font-weight: 600;
}

#tugas summary::before {
    content: "▶";
    position: absolute;
    left: 0;
    top: 3px;
    font-size: 1rem;
    transition: transform 0.3s ease;
}

#tugas details[open] summary::before {
    transform: rotate(90deg);
}

/* Hapus bullet */
#tugas ul {
    list-style-type: none;
    padding-left: 0;
}

#tugas li {
    background-color: #f1f5f9;
    padding: 15px;
    margin-bottom: 12px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    transition: background-color 0.2s;
}

#tugas li:hover {
    background-color: #e0f2fe;
}

/* File link */
#tugas a {
    text-decoration: none;
    font-weight: 500;
}

#tugas a:hover {
    text-decoration: underline;
    color: #2563eb;
}

/* Form upload */
#tugas form {
    background-color: #f8fafc;
    padding: 10px;
    margin-top: 10px;
    border-radius: 6px;
    border: 1px dashed #cbd5e1;
}

#tugas form label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
}

#tugas input[type="file"] {
    border: 1px solid #cbd5e1;
    padding: 6px;
    border-radius: 4px;
    width: 100%;
    background-color: #fff;
}

#tugas button[type="submit"] {
    margin-top: 10px;
    background-color: #3b82f6;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

#tugas button[type="submit"]:hover {
    background-color: #2563eb;
}
#ujian {
    font-family: 'Segoe UI', sans-serif;
}

/* Dropdown details */
#ujian details {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

#ujian details[open] {
    background-color: #fff;
    border-color: #cbd5e1;
}

/* Summary Title */
#ujian summary {
    list-style: none;
    outline: none;
    position: relative;
    padding-left: 1.5rem;
    font-weight: 600;
}

#ujian summary::before {
    content: "▶";
    position: absolute;
    left: 0;
    top: 3px;
    font-size: 1rem;
    transition: transform 0.3s ease;
}

#ujian details[open] summary::before {
    transform: rotate(90deg);
}

/* Hapus bullet */
#ujian ul {
    list-style-type: none;
    padding-left: 0;
}

#ujian li {
    background-color: #f1f5f9;
    padding: 15px;
    margin-bottom: 12px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    transition: background-color 0.2s;
}

#ujian li:hover {
    background-color: #e0f2fe;
}

/* File link */
#ujian a {
    text-decoration: none;
    font-weight: 500;
}

#ujian a:hover {
    text-decoration: underline;
    color: #2563eb;
}

/* Form upload */
#ujian form {
    background-color: #f8fafc;
    padding: 10px;
    margin-top: 10px;
    border-radius: 6px;
    border: 1px dashed #cbd5e1;
}

#ujian form label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
}

#ujian input[type="file"] {
    border: 1px solid #cbd5e1;
    padding: 6px;
    border-radius: 4px;
    width: 100%;
    background-color: #fff;
}

#ujian button[type="submit"] {
    margin-top: 10px;
    background-color: #3b82f6;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

#ujian button[type="submit"]:hover {
    background-color: #2563eb;
}
</style>
</head>
<body class="font-sans bg-gray-100">

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h2>E-LEARNING</h2>
   <ul>
            @php
    // Ambil mapel pertama dari daftar
    $firstMapel = \App\Models\Mapel::first();
@endphp
       <li><a href="{{ route('siswa.siswadashboard') }}">🏠 Beranda</a></li>

@if ($firstMapel)
    <li>
        <a href="{{ route('siswa.mapel.detail', ['id' => $firstMapel->id]) }}">
            📚 Mata Pelajaran
        </a>
    </li>
@endif

<li><a href="{{ route('siswa.absensi.index') }}">📋 Absensi</a></li>
<li><a href="{{ route('siswa.nilai.index') }}">📊 Nilai</a></li>
    </ul>
</div>

<div class="main" id="main-content">
  <div class="header">
    <button class="fullscreen-btn" onclick="toggleFullscreenDashboard()">☰</button>
     <div class="user">👤 {{ Auth::user()->name ?? 'Nama Siswa' }}</div>
  </div>
<!-- Main Content -->


<div class="info-frame">
    <h4>📢 Informasi Umum</h4>
    <p>Selamat datang di platform E-Learning! Silakan cek jadwal dan tugas Anda secara berkala.</p>
  </div>

  @if (session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded"
    >
        ✅ {{ session('success') }}
    </div>
@endif
  <!-- Tabs -->
<div class="flex space-x-2 mb-4">
    <button onclick="showTab('materi')" id="tabMateri" class="tab-button active">📚 Materi</button>
    <button onclick="showTab('tugas')" id="tabTugas" class="tab-button">📝 Tugas</button>
    <button onclick="showTab('ujian')" id="tabUjian" class="tab-button">🧪 Ujian</button>
</div>
<!-- Tab Contents -->
<div id="materi" class="tab-content">
    @if($materis->isEmpty())
        <p class="text-gray-600">Belum ada materi.</p>
    @else
        @php
            $grouped = $materis->groupBy(function($item) {
                 $mapel = $item->mapel->nama_mapel ?? '-';
                $guru = $item->guru->nama ?? '-';
                return "{$mapel} - {$guru}";
                
            });
        @endphp

        @foreach($grouped as $mapelGuru => $items)
            <div class="mb-4">
                <details class="border rounded p-3">
                    <summary class="cursor-pointer font-semibold text-lg text-gray-800">
                        📚 {{ $mapelGuru }}
                    </summary>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach($items as $m)
                            <li class="mb-2">
                                <strong>{{ $m->judul }}</strong><br>
                                {{ $m->deskripsi }}<br>
                                @if($m->file_path)
                                    <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" class="text-blue-500">📎 File</a>
                                @endif
                                @if($m->link)
                                    <a href="{{ $m->link }}" target="_blank" class="text-blue-500 ml-2">🔗 Link</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </details>
            </div>
        @endforeach
    @endif
</div>

<!-- Tab Tugas -->
<div id="tugas" class="tab-content hidden">
    @if($tugas->isEmpty())
        <p class="text-gray-600">Belum ada tugas.</p>
    @else
        @php
            $groupedTugas = $tugas->groupBy(function($item) {
              $mapel = $item->relasi->mapel->nama_mapel ?? '-';
$guru = $item->relasi->guru->nama ?? '-';
                return "{$mapel} - {$guru}";
            });
        @endphp

        @foreach($groupedTugas as $mapelNama => $items)
            <div class="mb-4">
                <details class="border rounded p-3">
                    <summary class="cursor-pointer font-semibold text-lg text-gray-800">
                        📚 {{ $mapelNama }}
                    </summary>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach($items as $t)
                            <li class="mb-5 border-b pb-4">
                                <strong>{{ $t->judul }}</strong> ({{ $t->jenis }})<br>
                                {{ $t->deskripsi }}<br>
                                Deadline: {{ \Carbon\Carbon::parse($t->tanggal_deadline)->translatedFormat('d M Y') }}<br>

                                @if($t->file_path)
                                    <a href="{{ asset('storage/' . $t->file_path) }}" target="_blank" class="text-blue-500">📎 Download Soal</a><br>
                                @endif

                                <!-- Form Kirim Jawaban -->
                                <form action="{{ route('siswa.jawaban.store') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="tugas_id" value="{{ $t->id }}">

                                    <label class="block text-sm mt-2">Upload Jawaban (PDF, DOCX, dll)</label>
                                    <input type="file" name="file_jawaban" required class="mt-1 block w-full text-sm">

                                    <button type="submit" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Kirim Jawaban
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </details>
            </div>
        @endforeach
    @endif
</div>

<div id="ujian" class="tab-content hidden">
    @if($ujians->isEmpty())
        <p class="text-gray-600">Belum ada ujian.</p>
    @else
        @php
            $groupedUjian = $ujians->groupBy(function($item) {
                $mapel = $item->relasi->mapel->nama_mapel ?? '-';
                $guru = $item->relasi->guru->nama ?? '-';
                return "{$mapel} - {$guru}";
            });
        @endphp

        @foreach($groupedUjian as $mapelGuru => $items)
            <div class="mb-4">
                <details class="border rounded p-3">
                    <summary class="cursor-pointer font-semibold text-lg text-gray-800">
                        📝 {{ $mapelGuru }}
                    </summary>
                    <ul class="ml-0 mt-2"> {{-- hilangkan list-disc --}}
                        @foreach($items as $u)
                            <li class="mb-5 p-4 bg-gray-100 rounded border">
                                <strong>{{ $u->judul }}</strong> ({{ $u->tipe_ujian }})<br>
                                Tanggal: {{ \Carbon\Carbon::parse($u->tanggal)->translatedFormat('d M Y') }}<br>
                                {{ $u->keterangan }}<br>

                                @if($u->file_soal)
                                    <a href="{{ asset('storage/' . $u->file_soal) }}" target="_blank" class="text-blue-500">
                                        📄 Download Soal
                                    </a>
                                @endif

                                <!-- Form Kirim Jawaban -->
                                <form action="{{ route('siswa.jawaban.ujian.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 bg-white border border-dashed rounded p-3">
                                    @csrf
                                    <input type="hidden" name="ujian_id" value="{{ $u->id }}">

                                    <label class="block text-sm font-medium mb-1">Upload Jawaban (PDF, DOCX, dll)</label>
                                    <input type="file" name="file_jawaban" required class="block w-full text-sm border rounded p-1 mb-2">

                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                        Kirim Jawaban
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </details>
            </div>
        @endforeach
    @endif
</div>

<!-- Script untuk tab -->
<script>
    function showTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
        document.getElementById(tabId).classList.remove('hidden');

        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.getElementById('tab' + tabId.charAt(0).toUpperCase() + tabId.slice(1)).classList.add('active');
    }
</script>

<style>
    .tab-button.active {
        background-color: #2563eb;
        color: white;
    }
    .tab-button {
        padding: 8px 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: white;
        cursor: pointer;
    }
    .tab-content.hidden {
        display: none;
    }
</style>
<!-- Footer -->
<footer id="footer">
  &copy; {{ date('Y') }} E-Learning SMP 5 CIDAUN.
</footer>
   
<script>
    function showTab(tab) {
        ['materi', 'tugas', 'ujian'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
            document.getElementById('tab' + capitalize(id)).classList.remove('active');
        });
        document.getElementById(tab).classList.remove('hidden');
        document.getElementById('tab' + capitalize(tab)).classList.add('active');
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function toggleMapel() {
        const subMapel = document.getElementById('sub-mapel');
        subMapel.style.display = subMapel.style.display === 'block' ? 'none' : 'block';
    }
 function toggleFullscreenDashboard() {
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('main-content').classList.toggle('fullscreen');
    document.getElementById('footer').classList.toggle('fullscreen');
  }
    function toggleSemuaPengumuman() {
        const list = document.getElementById('pengumuman-list');
        const container = document.querySelector('.pengumuman-container');
        const icon = document.getElementById('toggle-icon-semua');

        const isVisible = list.style.display === 'block';
        list.style.display = isVisible ? 'none' : 'block';
        container.classList.toggle('open', !isVisible);
    }
</script>
<script>
    function showTab(tabId) {
        // Sembunyikan semua konten tab
        document.querySelectorAll('.tab-content').forEach((el) => el.classList.add('hidden'));

        // Hilangkan class active dari semua tombol
        document.querySelectorAll('.tab-button').forEach((btn) => btn.classList.remove('active'));

        // Tampilkan konten tab yang dipilih
        document.getElementById(tabId).classList.remove('hidden');
        document.getElementById('tab' + capitalize(tabId)).classList.add('active');
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
</script>
<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>

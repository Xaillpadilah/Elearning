<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Mapel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    @vite(['resources/css/siswa.css'])
    @vite(['resources/css/detail.css'])
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

        a.text-blue-500:hover,
        a.text-blue-600:hover,
        a.text-red-500:hover,
        a.text-green-500:hover {
            @apply underline font-semibold;
        }

        #materi.tab-content {
            background-color: #8ba7f3ff;
        }

        /* kuning muda */
        #tugas.tab-content {
            background-color: #e0f2fe;
        }

        /* biru muda */
        #ujian.tab-content {
            background-color: #fce7f3;
        }

        /* pink muda */
        <style>.info-mapel {
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
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
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
                    $grouped = $materis->groupBy(function ($item) {
                        $mapel = $item->mapel->nama_mapel ?? '-';
                        return "{$mapel}";
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
                                            <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" class="text-blue-500">📎
                                                File</a>
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
            $groupedTugas = $tugas->groupBy(function ($item) {
                $mapel = $item->relasi->mapel->nama_mapel ?? '-';
                return "{$mapel} ";
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
                            @php
                                $deadline = \Carbon\Carbon::parse($t->tanggal_deadline);
                                $now = \Carbon\Carbon::now();
                                $diffMinutes = $now->diffInMinutes($deadline, false); // false = bisa negatif
                            @endphp

                            <li class="mb-5 border-b pb-4">
                                <strong>{{ $t->judul }}</strong> ({{ $t->jenis }})<br>
                                {{ $t->deskripsi }}<br>
                                Deadline: {{ $deadline->translatedFormat('d M Y H:i') }}<br>

                                {{-- Peringatan batas waktu --}}
                                @if ($diffMinutes <= 0)
                                    <p class="text-red-600 font-semibold mt-1">⚠️ Sudah lewat deadline</p>
                                @elseif ($diffMinutes <= 60)
                                    <p class="text-red-500 font-semibold mt-1">⏰ Segera kumpulkan! Deadline tinggal {{ $diffMinutes }} menit lagi</p>
                                @elseif ($diffMinutes <= 1440)
                                    <p class="text-yellow-600 font-semibold mt-1">🕒 Deadline dalam {{ ceil($diffMinutes / 60) }} jam</p>
                                @endif

                                {{-- File tugas --}}
                                @if($t->file_path)
                                    <a href="{{ asset('storage/' . $t->file_path) }}" target="_blank" class="text-blue-500">
                                        📎 Download Soal</a><br>
                                @endif

                                {{-- Form Kirim Jawaban --}}
                                @if($diffMinutes > 0)
                                    <form action="{{ route('siswa.jawaban.store') }}" method="POST"
                                        enctype="multipart/form-data" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="tugas_id" value="{{ $t->id }}">

                                        <label class="block text-sm mt-2">Upload Jawaban (PDF, DOCX, dll)</label>
                                        <input type="file" name="file_jawaban" required class="mt-1 block w-full text-sm">

                                        <button type="submit"
                                            class="mt-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                            Kirim Jawaban
                                        </button>
                                    </form>
                                @else
                                    <p class="text-sm text-gray-500 italic mt-2">Form tidak tersedia karena sudah lewat deadline.</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </details>
            </div>
        @endforeach
    @endif
</div>

      <!-- Tab  ujian-->
<div id="ujian" class="tab-content hidden">
    @if($ujians->isEmpty())
        <p class="text-gray-600">Belum ada ujian.</p>
    @else
        @php
            $groupedUjian = $ujians->groupBy(function ($item) {
                $mapel = $item->guruMapelKelas->mapel->nama_mapel ?? '-';
                return "{$mapel} ";
            });
        @endphp

        @foreach($groupedUjian as $mapelGuru => $items)
            <div class="mb-4">
                <details class="border rounded p-3">
                    <summary class="cursor-pointer font-semibold text-lg text-gray-800">
                        📝 {{ $mapelGuru }}
                    </summary>
                    <ul class="ml-0 mt-2">
                        @foreach($items as $u)
                            <li class="mb-5 p-4 bg-gray-100 rounded border">
                                <strong>{{ $u->judul }}</strong> ({{ $u->tipe_ujian }})<br>
                                Tanggal: {{ \Carbon\Carbon::parse($u->tanggal)->translatedFormat('d M Y') }}<br>
                                {{ $u->keterangan }}<br>

                              @if($u->jawabanSiswa->isNotEmpty())
    ✅ Anda sudah mengerjakan ujian ini
@else
                                    @if($u->tipe_ujian === 'pilihan_ganda')
                                        @php $soalList = $u->soals->shuffle()->values(); @endphp
                                        @if($soalList->count())
                                            <form action="{{ route('siswa.jawaban.ujian.pilihan-ganda.store') }}" method="POST"
                                                class="mt-3" id="form-ujian-{{ $u->id }}">
                                                @csrf
                                                <input type="hidden" name="ujian_id" value="{{ $u->id }}">
                                                <div class="text-right text-sm text-red-600 font-semibold mb-2">
                                                    Sisa Waktu: <span id="timer-{{ $u->id }}">60:00</span>
                                                </div>
                                                @foreach($soalList as $index => $soal)
                                                    <div class="soal-item-{{ $u->id }} hidden" data-index="{{ $index }}">
                                                        <div class="mb-4 border-b pb-2">
                                                            <p><strong>No {{ $index + 1 }}.</strong> {{ $soal->pertanyaan }}</p>
                                                            @foreach(['a', 'b', 'c', 'd'] as $opsi)
                                                                @php $label = 'opsi_' . $opsi; @endphp
                                                                <label class="block ml-4">
                                                                    <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $opsi }}"
                                                                        required>
                                                                    {{ strtoupper($opsi) }}. {{ $soal->$label }}
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="flex justify-between mt-4">
                                                    <button type="button"
                                                        class="prev-btn bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500"
                                                        data-ujian="{{ $u->id }}">Sebelumnya</button>
                                                    <button type="button"
                                                        class="next-btn bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
                                                        data-ujian="{{ $u->id }}">Lanjut</button>
                                                    <button type="submit"
                                                        class="submit-btn bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 hidden"
                                                        data-ujian="{{ $u->id }}">Kirim Jawaban</button>
                                                </div>
                                            </form>
                                        @else
                                            <p class="text-red-500 mt-2">Belum ada soal untuk ujian ini.</p>
                                        @endif

                                    @else
                                        {{-- Ujian Non Pilihan Ganda --}}
                                        @if($u->isi_soal)
                                            <div class="mt-3 text-gray-800 whitespace-pre-line border-t pt-2">
                                                <h4 class="font-semibold mb-1">Soal:</h4>
                                                {!! nl2br(e($u->isi_soal)) !!}
                                            </div>
                                        @endif

                                        @if($u->file_soal)
                                            <a href="{{ asset('storage/' . $u->file_soal) }}" target="_blank"
                                                class="text-blue-500 block mt-2">
                                                📄 Download Soal
                                            </a>
                                        @endif

                                        <form action="{{ route('siswa.jawaban.ujian.store') }}" method="POST"
                                            enctype="multipart/form-data" class="mt-4 bg-white border border-dashed rounded p-3">
                                            @csrf
                                            <input type="hidden" name="ujian_id" value="{{ $u->id }}">

                                            <label class="block text-sm font-medium mb-1">Upload Jawaban (PDF, DOCX, dll)</label>
                                            <input type="file" name="file_jawaban" required
                                                class="block w-full text-sm border rounded p-1 mb-2">

                                            <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                                Kirim Jawaban
                                            </button>
                                        </form>
                                    @endif
                                @endif
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
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll("form[id^='form-ujian-']").forEach(form => {
                    const ujianId = form.querySelector("input[name='ujian_id']").value;
                    const soalItems = form.querySelectorAll(`.soal-item-${ujianId}`);
                    const nextBtn = form.querySelector(`.next-btn[data-ujian='${ujianId}']`);
                    const prevBtn = form.querySelector(`.prev-btn[data-ujian='${ujianId}']`);
                    const submitBtn = form.querySelector(`.submit-btn[data-ujian='${ujianId}']`);
                    const timerElement = document.getElementById(`timer-${ujianId}`);

                    let currentIndex = 0;
                    let totalSeconds = 60 * 60;

                    const jawabanKey = `ujian-jawaban-${ujianId}`;

                    // ✅ Tampilkan soal
                    function showSoal(index) {
                        soalItems.forEach((item, i) => {
                            item.classList.toggle('hidden', i !== index);
                        });

                        prevBtn.disabled = index === 0;
                        nextBtn.classList.toggle('hidden', index === soalItems.length - 1);
                        submitBtn.classList.toggle('hidden', index !== soalItems.length - 1);
                    }

                    // ✅ Timer countdown
                    // Timer countdown yang persist
                    function startTimer() {
                        const startTimeKey = `ujian-start-${ujianId}`;
                        const duration = 60 * 60 * 1000; // 1 jam dalam milidetik
                        let startTime = localStorage.getItem(startTimeKey);

                        if (!startTime) {
                            startTime = Date.now();
                            localStorage.setItem(startTimeKey, startTime);
                        } else {
                            startTime = parseInt(startTime);
                        }

                        const endTime = startTime + duration;

                        const timerInterval = setInterval(() => {
                            const now = Date.now();
                            const remaining = endTime - now;

                            if (remaining <= 0) {
                                clearInterval(timerInterval);
                                alert("Waktu habis! Jawaban akan dikirim otomatis.");
                                localStorage.removeItem(startTimeKey);
                                localStorage.removeItem(jawabanKey);
                                form.submit();
                                return;
                            }

                            const minutes = Math.floor((remaining / 1000) / 60);
                            const seconds = Math.floor((remaining / 1000) % 60);
                            if (timerElement) {
                                timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                            }
                        }, 1000);
                    }
                    // ✅ Simpan jawaban ke localStorage setiap kali radio dipilih
                    form.querySelectorAll("input[type='radio']").forEach(input => {
                        input.addEventListener('change', () => {
                            const stored = JSON.parse(localStorage.getItem(jawabanKey)) || {};
                            stored[input.name] = input.value;
                            localStorage.setItem(jawabanKey, JSON.stringify(stored));
                        });
                    });

                    // ✅ Muat ulang jawaban dari localStorage (jika ada)
                    function restoreJawaban() {
                        const stored = JSON.parse(localStorage.getItem(jawabanKey)) || {};
                        let firstUnfilled = -1;

                        soalItems.forEach((item, index) => {
                            const inputs = item.querySelectorAll("input[type='radio']");
                            const name = inputs.length ? inputs[0].name : null;

                            if (name && stored[name]) {
                                const value = stored[name];
                                const radioToCheck = item.querySelector(`input[name="${name}"][value="${value}"]`);
                                if (radioToCheck) {
                                    radioToCheck.checked = true;
                                }
                            } else if (firstUnfilled === -1) {
                                firstUnfilled = index;
                            }
                        });

                        // Lanjutkan dari soal belum terisi pertama
                        currentIndex = firstUnfilled !== -1 ? firstUnfilled : 0;
                        showSoal(currentIndex);
                    }

                    // ✅ Validasi sebelum kirim
                    submitBtn.addEventListener('click', function (e) {
                        e.preventDefault();

                        const radioGroups = form.querySelectorAll("div[class^='soal-item-']");
                        let unfilledIndex = -1;

                        radioGroups.forEach((soalDiv, index) => {
                            const inputs = soalDiv.querySelectorAll("input[type='radio']");
                            const name = inputs.length ? inputs[0].name : null;

                            if (name) {
                                const checked = form.querySelector(`input[name="${name}"]:checked`);
                                if (!checked && unfilledIndex === -1) {
                                    unfilledIndex = index;
                                }
                            }
                        });

                        if (unfilledIndex !== -1) {
                            alert("Masih ada soal yang belum dijawab. Silakan lengkapi dulu.");
                            currentIndex = unfilledIndex;
                            showSoal(currentIndex);
                            return false;
                        }

                        localStorage.removeItem(jawabanKey); // Hapus cache setelah kirim
                        form.submit();
                    });

                    // ✅ Navigasi tombol
                    nextBtn.addEventListener('click', () => {
                        if (currentIndex < soalItems.length - 1) {
                            currentIndex++;
                            showSoal(currentIndex);
                        }
                    });

                    prevBtn.addEventListener('click', () => {
                        if (currentIndex > 0) {
                            currentIndex--;
                            showSoal(currentIndex);
                        }
                    });

                    // ✅ Inisialisasi
                    restoreJawaban();
                    startTimer();
                });
            });
        </script>

</body>

</html>
<!-- Tab Contents -->
<div id="materi" class="tab-content">
    @if ($materis->isEmpty())
        <div class="text-gray-600">Belum ada materi.</div>
    @else
        <ul class="list-disc ml-5">
            @foreach ($materis as $materi)
                <li class="mb-2">
                    <strong>{{ $materi->judul }}</strong> - {{ $materi->deskripsi }}
                    @if ($materi->file_path)
                        <a href="{{ asset('storage/' . $materi->file_path) }}" class="text-blue-500 underline ml-2" target="_blank">📄 Lihat</a>
                    @endif
                    @if ($materi->link)
                        <a href="{{ $materi->link }}" class="text-green-500 underline ml-2" target="_blank">🔗 Link</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
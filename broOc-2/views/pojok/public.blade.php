<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $playlist->name }} — {{ $station->name ?? 'Pojok KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: system-ui, sans-serif; }
        body { background: #f8fafc; }
    </style>
</head>
<body class="min-h-screen">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="text-center mb-6">
            <span class="text-4xl">{{ $periodIcons[$playlist->period] ?? '🎵' }}</span>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $playlist->name }}</h1>
            <p class="text-sm text-gray-500">{{ $station->name }}</p>
        </div>

        @if ($items->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <p>Belum ada item di playlist ini</p>
        </div>
        @else
        <div class="space-y-2">
            @foreach ($items as $item)
            <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4 hover:shadow-sm transition">
                @if ($item->cover_url)
                <img src="{{ $item->cover_url }}" class="w-12 h-12 rounded-lg object-cover shrink-0">
                @else
                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 text-lg">
                    {{ $item->item_type === 'audio' ? '🎵' : ($item->item_type === 'webstream' ? '🔗' : '🎙️') }}
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 text-sm truncate">{{ $item->title }}</p>
                    @if ($item->artist)
                    <p class="text-xs text-gray-400 truncate">{{ $item->artist }}</p>
                    @endif
                </div>
                @if ($item->duration_display)
                <span class="text-xs font-mono text-gray-400 shrink-0">{{ $item->duration_display }}</span>
                @endif
                @if ($item->item_type === 'audio' && $item->audio_file)
                <button onclick="playAudio('{{ asset('storage/' . $item->audio_file) }}')"
                        class="w-9 h-9 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center shrink-0 transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </button>
                @endif
                @if ($item->item_type === 'webstream' && $item->webstream_url)
                <a href="{{ $item->webstream_url }}" target="_blank"
                   class="text-xs text-purple-600 hover:underline shrink-0">Buka</a>
                @endif
                @if ($item->item_type === 'podcast' && $item->podcast_url)
                <a href="{{ $item->podcast_url }}" target="_blank"
                   class="text-xs text-green-600 hover:underline shrink-0">Dengar</a>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <div class="text-center mt-8 text-xs text-gray-400">
            Pojok KBRBaik — {{ $station->name }}
        </div>
    </div>

    <audio id="player" class="hidden"></audio>
    <script>
        function playAudio(url) {
            var p = document.getElementById('player');
            p.src = url;
            p.play();
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.18.1/dist/echo.iife.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.js"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
    <style>
        #equalizer div { animation: equalize 0.8s steps(4) infinite; }
        .eq-1 { animation-delay: 0s; }
        .eq-2 { animation-delay: 0.1s; }
        .eq-3 { animation-delay: 0.2s; }
        .eq-4 { animation-delay: 0.3s; }
        .eq-5 { animation-delay: 0.4s; }
        @keyframes equalize {
            0% { height: 0.25rem; } 25% { height: 1rem; } 50% { height: 0.5rem; } 75% { height: 1.25rem; } 100% { height: 0.25rem; }
        }
    </style>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen flex flex-col">
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <span class="text-xl font-bold tracking-tight">{{ $station?->name ?? 'KBRBaik' }}</span>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('services') }}" class="hover:text-sky-200 transition">Layanan</a>
                <a href="{{ route('pelatihan') }}" class="hover:text-sky-200 transition">Pelatihan</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>
            <a href="{{ route('pelatihan') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-sky-900">{{ $station?->name ?? 'Radio KBRBaik' }}</h1>
                <p class="text-sky-600 text-sm mt-1">{{ $station?->description ?? '' }}</p>
            </div>

            <div id="now-playing" class="bg-white rounded-xl p-4 border border-sky-100 text-center hidden">
                <p class="text-xs text-sky-500 uppercase tracking-wider mb-1">Now Playing</p>
                <p id="np-title" class="text-lg font-semibold text-gray-900">-</p>
                <p id="np-artist" class="text-sm text-gray-500">-</p>
            </div>

            <div id="studio-status" class="bg-white rounded-xl p-3 border border-sky-100 text-center hidden">
                <span id="studio-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                    <span id="studio-dot" class="w-2 h-2 rounded-full bg-gray-400"></span>
                    <span id="studio-label">Studio offline</span>
                </span>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm border border-sky-100">
                <div id="player-status" class="text-center text-gray-400 text-sm mb-6">Klik play untuk mulai</div>

                <div id="equalizer" class="hidden flex items-end justify-center gap-1 h-8 mb-6">
                    @for ($i = 1; $i <= 5; $i++)
                    <div class="eq-{{ $i }} w-1.5 bg-sky-500 rounded-full"></div>
                    @endfor
                </div>

                <button id="play-btn" class="w-20 h-20 mx-auto flex items-center justify-center rounded-full bg-sky-600 hover:bg-sky-700 transition text-white shadow-lg">
                    <svg id="play-icon" class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <svg id="pause-icon" class="w-8 h-8 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </button>

                <audio id="audio" preload="none" src="https://radio.kbrbaik.live/{{ $station?->id == 1 ? 'stream.mp3' : 'suara.mp3' }}"></audio>
            </div>

            @if ($items->isNotEmpty())
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-sky-100">
                <h2 class="text-lg font-semibold text-sky-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    Daftar Lagu
                </h2>
                <div class="space-y-2">
                    @foreach ($items as $item)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-sky-50 hover:bg-sky-100 transition">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $item->title }}</p>
                            @if ($item->artist)
                            <p class="text-xs text-gray-500 truncate">{{ $item->artist }}</p>
                            @endif
                        </div>
                        @if ($item->duration)
                        <span class="text-xs text-sky-500 ml-2 flex-shrink-0">{{ gmdate('i:s', $item->duration) }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="text-center">
                <p class="text-gray-500 text-sm mb-2">Unduh file playlist</p>
                <div class="flex justify-center gap-3">
                    <a href="/radio-{{ $station?->slug ?? 'kbrbaik' }}.m3u" class="text-sm text-sky-600 hover:text-sky-700 underline">.m3u</a>
                </div>
            </div>
        </div>
    </main>

    <script>
        var stationId = {{ $station?->id ?? 1 }};

        (function() {
            try {
                window.Pusher = Pusher;
                window.Echo = new Echo({
                    broadcaster: 'reverb',
                    key: '{{ env("REVERB_APP_KEY") }}',
                    wsHost: '{{ env("REVERB_HOST") }}',
                    wsPort: {{ env("REVERB_PORT", 443) }},
                    wssPort: {{ env("REVERB_PORT", 443) }},
                    forceTLS: {{ env("REVERB_SCHEME") === 'https' ? 'true' : 'false' }},
                    enabledTransports: ['ws', 'wss'],
                });

                Echo.channel('station.' + stationId)
                    .listen('.now-playing', function(e) {
                        var el = document.getElementById('now-playing');
                        el.classList.remove('hidden');
                        document.getElementById('np-title').textContent = e.title || '-';
                        document.getElementById('np-artist').textContent = e.artist || '-';
                    })
                    .listen('.studio-status', function(e) {
                        var el = document.getElementById('studio-status');
                        el.classList.remove('hidden');
                        var badge = document.getElementById('studio-badge');
                        var dot = document.getElementById('studio-dot');
                        var label = document.getElementById('studio-label');
                        if (e.status === 'on-air') {
                            badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700';
                            dot.className = 'w-2 h-2 rounded-full bg-green-500 animate-pulse';
                            label.textContent = 'ON AIR' + (e.dj ? ' — ' + e.dj : '');
                        } else {
                            badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500';
                            dot.className = 'w-2 h-2 rounded-full bg-gray-400';
                            label.textContent = 'Studio offline';
                        }
                    });
            } catch(e) {
                console.log('Echo not available:', e.message);
            }
        })();

        (function() {
            var audio = document.getElementById('audio');
            var playBtn = document.getElementById('play-btn');
            var playIcon = document.getElementById('play-icon');
            var pauseIcon = document.getElementById('pause-icon');
            var statusEl = document.getElementById('player-status');
            var equalizer = document.getElementById('equalizer');

            function setStatus(text, isError) {
                statusEl.textContent = text;
                statusEl.className = 'text-center text-sm mb-6 ' + (isError ? 'text-red-500' : 'text-gray-400');
            }

            function showPlaying() {
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
                equalizer.classList.remove('hidden');
                setStatus('Siaran langsung');
            }

            function showPaused() {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
                equalizer.classList.add('hidden');
                setStatus('Dijeda');
            }

            playBtn.addEventListener('click', function() {
                if (audio.paused) {
                    setStatus('Memuat...');
                    audio.play().then(showPlaying).catch(function() {
                        setStatus('Stream tidak tersedia', true);
                        showPaused();
                    });
                } else {
                    audio.pause();
                    showPaused();
                }
            });

            audio.addEventListener('play', showPlaying);
            audio.addEventListener('pause', function() { if (audio.src) showPaused(); });
            audio.addEventListener('waiting', function() { setStatus('Buffering...'); });
            audio.addEventListener('canplay', showPlaying);
            audio.addEventListener('error', function() { setStatus('Off air', true); showPaused(); });
        })();
    </script>

</body>
</html>

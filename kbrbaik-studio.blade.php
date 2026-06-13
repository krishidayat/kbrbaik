<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>function toggleMobileMenu(){document.getElementById('mobile-menu').classList.toggle('hidden')}</script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2"><img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-9 w-auto"><span class="text-lg font-bold tracking-tight">Radio KbrBaik</span></a>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button>
            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('studio') }}" class="hover:text-sky-200 transition">Studio</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('pelatihan') }}" class="hover:text-sky-200 transition">Pelatihan</a>
                <a href="{{ route('media') }}" class="hover:text-sky-200 transition">Media</a>
                <a href="{{ route('kredensi') }}" class="hover:text-sky-200 transition flex items-center gap-1">@auth<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>@endauth @guest<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>@endguest</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('studio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Studio</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('pelatihan') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="{{ route('media') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Media</a>
        </div>
    </nav>

    @php $studios = \App\Models\Studio::where('station_id', $station?->id ?? 1)->where('is_active', true)->with('community')->get(); @endphp

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Left: Content Area --}}
            <div class="md:w-3/4 order-2 md:order-1">
                <h1 id="studio-title" class="text-3xl font-bold text-sky-900 mb-2">Studio</h1>
                <p class="text-sky-600 mb-6">Kegiatan produksi konten — Narasi, Podcast, YouTube, Live</p>

                {{-- Tab Filter --}}
                <div class="flex flex-wrap gap-1 mb-6 bg-sky-100/50 rounded-xl p-1">
                    <button onclick="switchTab('narasi')" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold transition bg-sky-800 text-white" data-tab="narasi">✍️ Narasi</button>
                    <button onclick="switchTab('podcast')" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold transition bg-white text-sky-700 border border-sky-200 hover:bg-sky-100" data-tab="podcast">🎙 Podcast</button>
                    <button onclick="switchTab('youtube')" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold transition bg-white text-sky-700 border border-sky-200 hover:bg-sky-100" data-tab="youtube">▶️ YouTube</button>
                    <button onclick="switchTab('live')" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold transition bg-white text-sky-700 border border-sky-200 hover:bg-sky-100" data-tab="live">🔴 Live</button>
                </div>

                {{-- Tab: Narasi --}}
                <div id="tab-narasi" class="tab-panel">
                    <div class="bg-white border border-sky-200 rounded-xl p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-xl">✍️</div>
                            <div>
                                <h3 class="font-bold text-gray-900">Narasi</h3>
                                <p class="text-xs text-gray-400">Tulisan dan artikel</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Skrip, naskah podcast, dan konten tulisan dari studio.</p>
                        <a href="{{ route('kbrbaik.blog') }}" class="inline-block mt-3 text-sm font-semibold text-sky-600 hover:text-sky-800">Buka Blog →</a>
                    </div>
                </div>

                {{-- Tab: Podcast --}}
                <div id="tab-podcast" class="tab-panel hidden">
                    <div class="bg-white border border-green-200 rounded-xl p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-xl">🎙</div>
                            <div>
                                <h3 class="font-bold text-gray-900">Podcast</h3>
                                <p class="text-xs text-gray-400">Episode audio</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Produksi dan distribusi episode podcast.</p>
                        <a href="#" class="inline-block mt-3 text-sm font-semibold text-green-600 hover:text-green-800">Dengarkan →</a>
                    </div>
                </div>

                {{-- Tab: YouTube --}}
                <div id="tab-youtube" class="tab-panel hidden">
                    <div class="bg-white border border-red-200 rounded-xl p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-xl">▶️</div>
                            <div>
                                <h3 class="font-bold text-gray-900">YouTube</h3>
                                <p class="text-xs text-gray-400">Kanal video</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Konten video dan dokumentasi kegiatan.</p>
                        <a href="#" class="inline-block mt-3 text-sm font-semibold text-red-500 hover:text-red-700">Buka Channel →</a>
                    </div>
                </div>

                {{-- Tab: Live --}}
                <div id="tab-live" class="tab-panel hidden">
                    <div class="bg-white border border-purple-200 rounded-xl p-6 hover:shadow-md transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-xl">🔴</div>
                            <div>
                                <h3 class="font-bold text-gray-900">Live Streaming</h3>
                                <p class="text-xs text-gray-400">Siaran langsung</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Siaran langsung radio dan konten real-time.</p>
                        <a href="#" class="inline-block mt-3 text-sm font-semibold text-purple-600 hover:text-purple-800">Tonton →</a>
                    </div>
                </div>
            </div>

            {{-- Right: Studio Filter --}}
            <div class="md:w-1/4 order-1 md:order-2">
                <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                    <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Studio</h3>
                    <div class="space-y-2" id="studio-list">
                        <button onclick="pilihStudio(0)" class="tab-studio flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-sky-800 text-white" data-sid="0">Semua</button>
                        @foreach ($studios as $s)
                        @php $nama = ($s->community) ? preg_replace('/^Kabar /', '', $s->community->name) . ' - ' . $s->name : $s->name; @endphp
                        <button onclick="pilihStudio({{ $s->id }})" class="tab-studio flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-white text-sky-700 border border-sky-200 hover:bg-sky-100" data-sid="{{ $s->id }}" 
                            data-youtube="{{ $s->youtube_url ?? '' }}" 
                            data-spotify="{{ $s->spotify_url ?? '' }}" 
                            data-live="{{ $s->community->stream_url ?? '' }}">
                            🎙 {{ $nama }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.player')

    <script>
    function switchTab(tab) {
        document.querySelectorAll('.tab-btn').forEach(function(b) {
            var a = b.dataset.tab === tab;
            b.classList.toggle('bg-sky-800', a);
            b.classList.toggle('text-white', a);
            b.classList.toggle('bg-white', !a);
            b.classList.toggle('text-sky-700', !a);
            b.classList.toggle('border', !a);
            b.classList.toggle('border-sky-200', !a);
        });
        document.querySelectorAll('.tab-panel').forEach(function(el) {
            el.classList.add('hidden');
        });
        var target = document.getElementById('tab-' + tab);
        if (target) target.classList.remove('hidden');
    }

    function pilihStudio(id) {
        document.querySelectorAll('.tab-studio').forEach(function(b) {
            var a = parseInt(b.dataset.sid) === id;
            b.classList.toggle('bg-sky-800', a);
            b.classList.toggle('text-white', a);
            b.classList.toggle('text-sky-700', !a);
            b.classList.toggle('bg-white', !a);
            b.classList.toggle('border', !a);
            b.classList.toggle('border-sky-200', !a);
        });
        var title = id === 0 ? 'Semua Studio' : (studioData[id]?.name || 'Studio');
        document.getElementById('studio-title').textContent = title;

        // Update links based on selected studio
        var yt = id === 0 ? '' : (studioData[id]?.youtube || '');
        var sp = id === 0 ? '' : (studioData[id]?.spotify || '');
        var lv = id === 0 ? '' : (studioData[id]?.live || '');
        // ... link updates would go here but tabs now show real content
    }

    var studioData = {};
    document.querySelectorAll('.tab-studio').forEach(function(b) {
        var sid = b.dataset.sid;
        if (sid !== '0') {
            studioData[sid] = {
                youtube: b.dataset.youtube,
                spotify: b.dataset.spotify,
                live: b.dataset.live,
                name: b.textContent.trim().replace('🎙', '').trim()
            };
        }
    });
    </script>
</body>
</html>

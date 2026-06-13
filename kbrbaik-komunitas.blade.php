<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komunitas - {{ $station?->name ?? "KBRBaik" }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">

    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight">Radio KbrBaik</span>
            </a>
            <button onclick="document.getElementById("mobile-menu").classList.toggle("hidden")" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route("home") }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('komunitas') }}" class="text-sky-200 font-semibold transition">Komunitas</a>
t			<a href="{{ route('studio') }}" class="hover:text-sky-200 transition">Studio</a>
                <a href="{{ route("pelatihan") }}" class="hover:text-sky-200 transition">Pelatihan</a>
                <a href="{{ route("radio") }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route("home") }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('kbrbaik.blog') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Narasi</a>
                <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
t			<a href="{{ route('studio') }}" class="hover:text-sky-200 transition">Studio</a>
            <a href="{{ route("pelatihan") }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="{{ route("radio") }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>
    </nav>

    <section class="bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
        <div class="max-w-6xl mx-auto px-4 py-16 md:py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Komunitas Klasikal</h1>
            <p class="text-lg text-sky-100 max-w-2xl mx-auto">Stasiun satelit per wilayah Klasikal — wadah kreatif dan pelayanan bersama.</p>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Filter Sinode --}}
            <div class="flex flex-wrap gap-2 mb-8 border-b border-sky-200 pb-3">
                <button onclick="filterSinode('semua')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-sky-800 text-white transition sinode-filter" data-sinode="semua">Semua</button>
                <button onclick="filterSinode('gkj')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-white text-sky-700 border border-sky-200 hover:bg-sky-50 transition sinode-filter" data-sinode="gkj">GKJ</button>
                <button onclick="filterSinode('gki')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-white text-sky-700 border border-sky-200 hover:bg-sky-50 transition sinode-filter" data-sinode="gki">GKI</button>
                <button onclick="filterSinode('gerejawi')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-white text-sky-700 border border-sky-200 hover:bg-sky-50 transition sinode-filter" data-sinode="gerejawi">Gerejawi</button>
            </div>

            @php
            $komunitas = \App\Models\Community::where('station_id', $station?->id ?? 1)->where('is_active', true)->get();
            @endphp

            @if ($komunitas->isEmpty())
            <div class="text-center py-16">
                <p class="text-sky-500">Belum ada komunitas.</p>
            </div>
            @else
            @foreach ($komunitas as $kom)
            @php $studios = $kom->studios()->where('is_active', true)->get(); @endphp
            <div class="sinode-group bg-white rounded-xl border border-sky-100 overflow-hidden shadow-sm mb-6" data-sinode="{{ $kom->slug }}">
                <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold">{{ $kom->name }}</h2>
                            <p class="text-sm text-sky-200 mt-0.5">{{ $studios->count() }} studio • {{ $kom->description ?? 'Klasis' }}</p>
                        </div>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-semibold">{{ $kom->slug }}</span>
                    </div>
                </div>
                @if ($studios->isEmpty())
                <div class="p-6 text-center text-gray-400 text-sm">Belum ada studio.</div>
                @else
                <div class="p-6 grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($studios as $s)
                    <div class="border border-sky-100 rounded-xl p-4 hover:shadow-md transition group">
                        <a href="{{ route('komunitas.show', $kom->slug) }}?studio={{ $s->id }}" class="block">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-lg">🎙</div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm group-hover:text-sky-700">{{ $s->name }}</h3>
                                    <span class="text-xs text-gray-400">Studio</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-400 mt-2">
                                @if ($s->youtube_url) <span>▶️ YouTube</span> @endif
                                @if ($s->spotify_url) <span>🎵 Spotify</span> @endif
                                @if ($s->stream_url) <span>🔴 Live</span> @endif
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
            @endif
        </div>
    </section>

    <script>
    function filterSinode(slug) {
        document.querySelectorAll('.sinode-filter').forEach(function(btn) {
            var isActive = btn.dataset.sinode === slug;
            btn.classList.toggle('bg-sky-800', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('bg-white', !isActive);
            btn.classList.toggle('text-sky-700', !isActive);
            btn.classList.toggle('border', !isActive);
            btn.classList.toggle('border-sky-200', !isActive);
        });
        document.querySelectorAll('.sinode-group').forEach(function(g) {
            g.style.display = (slug === 'semua' || g.dataset.sinode === slug || g.dataset.sinode.includes(slug)) ? '' : 'none';
        });
    }
    </script>
        </div>
    </section>

    <footer class="bg-sky-800 text-sky-200 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date("Y") }} {{ $station?->name ?? "Radio Kabar Baik" }}. All rights reserved.</p>
        </div>
    </footer>
@include('partials.player')
</body>
</html>

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
                <a href="{{ route("pelatihan") }}" class="hover:text-sky-200 transition">Pelatihan</a>
                <a href="{{ route("radio") }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route("home") }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
                <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route("pelatihan") }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="{{ route("radio") }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>
    </nav>

    <section class="bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
        <div class="max-w-6xl mx-auto px-4 py-16 md:py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Komunitas Stasiun Lokal</h1>
            <p class="text-lg text-sky-100 max-w-2xl mx-auto">Stasiun komunitas per wilayah — wadah kreatif dan pelayanan bersama.</p>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            @php
            $allKom = \App\Models\Community::where('station_id', $station?->id ?? 1)->where('is_active', true)->get();
            $allStudios = \App\Models\Studio::where('station_id', $station?->id ?? 1)->where('is_active', true)->with('community')->get();
            @endphp

            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-3/4 order-2 md:order-1">
                    <h1 id="studio-title" class="text-3xl font-bold text-sky-900 mb-8">Semua Studio</h1>

                    {{-- Profil Komunitas (hidden default, muncul saat filter) --}}
                    <div id="profil-kom" class="hidden mb-8"></div>

                    {{-- Data profil semua komunitas (hidden, dipanggil JS) --}}
                    <div id="profil-data" class="hidden">
                        @foreach ($allKom as $kom)
                        @php $nama = preg_replace('/^Kabar /', '', $kom->name); @endphp
                        <div data-kom="{{ $kom->id }}">
                            <div class="bg-white rounded-xl border border-sky-200 overflow-hidden shadow-sm">
                                <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-xl font-bold">{{ $kom->name }}</h3>
                                        @auth
                                        <a href="{{ url('/admin/communities/' . $kom->id . '/edit') }}" class="text-white/70 hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                        @endauth
                                    </div>
                                    @if ($kom->city || $kom->region)
                                    <p class="text-sm text-sky-200 mt-1">{{ $kom->city }}{{ $kom->city && $kom->region ? ' — ' : '' }}{{ $kom->region }}</p>
                                    @endif
                                </div>
                                <div class="p-5 space-y-4">
                                    @if ($kom->manager)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-lg font-bold">{{ substr($kom->manager, 0, 1) }}</div>
                                        <div><p class="text-xs text-amber-500 font-semibold">Manajer Radio</p><p class="font-medium text-gray-900">{{ $kom->manager }}</p></div>
                                    </div>
                                    @endif
                                    @if ($kom->pic_name)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-lg font-bold">{{ substr($kom->pic_name, 0, 1) }}</div>
                                        <div><p class="text-xs text-sky-500 font-semibold">Penanggung Jawab</p><p class="font-medium text-gray-900">{{ $kom->pic_name }}</p></div>
                                    </div>
                                    @endif
                                    <div>
                                        <h4 class="text-xs font-bold text-sky-800 uppercase tracking-widest mb-1">Deskripsi</h4>
                                        <p class="text-sm text-gray-600">{{ $kom->description ?? $kom->vision ?? $kom->mission ?? 'Belum ada deskripsi.' }}</p>
                                    </div>
                                    @php
                                    $partners = [];
                                    $partners[] = ['Web', route('komunitas.show', $kom->slug)];
                                    if ($kom->partner_radio) $partners[] = ['Radio', $kom->partner_radio];
                                    if ($kom->partner_spotify) $partners[] = ['Spotify', $kom->partner_spotify];
                                    if ($kom->partner_youtube) $partners[] = ['YouTube', $kom->partner_youtube];
                                    if ($kom->partner_local) $partners[] = ['Lokal', $kom->partner_local];
                                    @endphp
                                    @if (count($partners) > 0)
                                    <div>
                                        <h4 class="text-xs font-bold text-sky-800 uppercase tracking-widest mb-2">Media Mitra</h4>
                                        <div class="flex flex-wrap gap-2">@foreach ($partners as $p)<a href="{{ $p[1] }}" target="_blank" class="text-xs bg-sky-50 text-sky-600 px-3 py-1.5 rounded-full hover:bg-sky-100 transition">{{ $p[0] }}</a>@endforeach</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if ($allStudios->isEmpty())
                    <div class="text-center py-16"><p class="text-sky-500">Belum ada studio.</p></div>
                    @else
                    <div id="studio-grid" class="grid md:grid-cols-2 gap-6">
                        @foreach ($allStudios as $s)
                        @php $city = preg_replace('/^Kabar /', '', $s->community->name ?? ''); @endphp
                        <div class="studio-card bg-white border border-sky-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition" data-kom="{{ $s->community_id }}">
                            <div class="p-5">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-xl shrink-0">🎙</div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $s->name }}</h3>
                                        <span class="text-xs text-sky-500">{{ $city }}</span>
                                    </div>
                                    @auth
                                    <a href="{{ url('/admin/studios/' . $s->id . '/edit') }}" class="ml-auto text-gray-300 hover:text-sky-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                    @endauth
                                </div>
                                @if ($s->description)
                                <p class="text-sm text-gray-500 mb-3">{{ Str::limit($s->description, 80) }}</p>
                                @endif
                                <div class="flex flex-wrap gap-2">
                                    @if ($s->youtube_url) <a href="{{ $s->youtube_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-full hover:bg-red-100 transition">▶️ YouTube</a> @endif
                                    @if ($s->spotify_url) <a href="{{ $s->spotify_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-green-50 text-green-600 px-3 py-1.5 rounded-full hover:bg-green-100 transition">🎵 Spotify</a> @endif
                                    @if ($s->stream_url) <a href="{{ $s->stream_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-purple-50 text-purple-600 px-3 py-1.5 rounded-full hover:bg-purple-100 transition">🔴 Live</a> @endif
                                    <a href="{{ route('komunitas.show', $s->community->slug) }}" class="inline-flex items-center gap-1 text-xs bg-sky-50 text-sky-600 px-3 py-1.5 rounded-full hover:bg-sky-100 transition">🏠 Profil</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="md:w-1/4 order-1 md:order-2">
                    <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                        <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Komunitas</h3>
                        <div class="space-y-2">
                            <button onclick="filterKom(0)" class="tab-kom flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-sky-800 text-white" data-id="0">Semua</button>
                            @foreach ($allKom as $kom)
                            @php $nama = preg_replace('/^Kabar /', '', $kom->name); @endphp
                            <button onclick="filterKom({{ $kom->id }})" class="tab-kom flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-white text-sky-700 border border-sky-200 hover:bg-sky-100" data-id="{{ $kom->id }}">
                                {{ $nama }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    function filterKom(id) {
        document.querySelectorAll('.tab-kom').forEach(function(b) {
            var a = parseInt(b.dataset.id) === id;
            b.classList.toggle('bg-sky-800', a);
            b.classList.toggle('text-white', a);
            b.classList.toggle('text-sky-700', !a);
            b.classList.toggle('bg-white', !a);
            b.classList.toggle('border', !a);
            b.classList.toggle('border-sky-200', !a);
        });
        document.querySelectorAll('.studio-card').forEach(function(c) {
            c.style.display = id === 0 || parseInt(c.dataset.kom) === id ? '' : 'none';
        });
        var title = id === 0 ? 'Semua Studio' : document.querySelector('.tab-kom[data-id="' + id + '"]').textContent.trim() + ' Studio';
        document.getElementById('studio-title').textContent = title;

        // Show/hide komunitas profile
        var profil = document.getElementById('profil-kom');
        if (id === 0) {
            profil.classList.add('hidden');
        } else {
            var data = document.querySelector('#profil-data > div[data-kom="' + id + '"]');
            if (data) {
                profil.innerHTML = data.innerHTML;
                profil.classList.remove('hidden');
            }
        }
    }
    </script>

    <footer class="bg-sky-800 text-sky-200 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date("Y") }} {{ $station?->name ?? "Radio Kabar Baik" }}. All rights reserved.</p>
        </div>
    </footer>
@include('partials.player')
</body>
</html>

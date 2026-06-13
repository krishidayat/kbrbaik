<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $community->name }} - {{ $station?->name ?? "KBRBaik" }}</title>
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
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
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
        <div class="max-w-6xl mx-auto px-4 py-12 md:py-16">
            <a href="{{ route('komunitas') }}" class="inline-flex items-center gap-1 text-sm text-white/70 hover:text-white transition mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div class="flex items-start gap-6">
                @if ($community->cover_image)
                <img src="{{ asset("storage/" . $community->cover_image) }}" alt="{{ $community->name }}" class="w-20 h-20 rounded-xl object-cover border-2 border-white/20">
                @endif
                <div class="flex-1">
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-white/70">Komunitas Stasiun Lokal</span>
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold mt-1">{{ $community->name }}</h1>
                            @if ($community->region || $community->city)
                            <p class="text-sm text-sky-200 mt-1">{{ $community->city }}{{ $community->city && $community->region ? ' — ' : '' }}{{ $community->region }}</p>
                            @endif
                        </div>
                        @auth
                        <a href="{{ url('/admin/communities/' . $community->id . '/edit') }}" class="shrink-0 bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1 backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                        @endauth
                    </div>
                    @if ($community->description)
                    <p class="text-sm text-sky-100 mt-2 max-w-2xl">{{ $community->description }}</p>
                    @endif
                    <p class="text-xs text-sky-200 mt-2">{{ $studios->count() }} studio</p>
                </div>
            </div>
        </div>
    </section>

    {{-- VISI & MISI --}}
    @if ($community->vision || $community->mission)
    <section class="py-12 bg-white border-b border-sky-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-8">
                @if ($community->vision)
                <div>
                    <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-3">Visi</h3>
                    <p class="text-gray-700">{{ $community->vision }}</p>
                </div>
                @endif
                @if ($community->mission)
                <div>
                    <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-3">Misi</h3>
                    <p class="text-gray-700">{{ $community->mission }}</p>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- PENANGGUNG JAWAB & MANAJER --}}
    @if ($community->pic_name || $community->manager)
    <section class="py-8 bg-sky-50 border-b border-sky-100">
        <div class="max-w-6xl mx-auto px-4 flex flex-wrap items-center gap-6">
            @if ($community->manager)
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-amber-200 text-amber-600 flex items-center justify-center text-xl font-bold">{{ substr($community->manager, 0, 1) }}</div>
                <div>
                    <p class="text-xs text-amber-500 font-semibold uppercase tracking-widest">Manajer Radio</p>
                    <p class="font-semibold text-gray-900">{{ $community->manager }}</p>
                </div>
            </div>
            @endif
            @if ($community->pic_name)
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-sky-200 text-sky-600 flex items-center justify-center text-xl font-bold">{{ substr($community->pic_name, 0, 1) }}</div>
                <div>
                    <p class="text-xs text-sky-500 font-semibold uppercase tracking-widest">Penanggung Jawab</p>
                    <p class="font-semibold text-gray-900">{{ $community->pic_name }}</p>
                </div>
            </div>
            @endif
    </section>
    @endif

    {{-- MEDIA MITRA --}}
    @php $partners = []; @endphp
    @if ($community->partner_web) @php $partners[] = ['Web', $community->partner_web, 'text-blue-600', '🌐']; @endphp @endif
    @if ($community->partner_radio) @php $partners[] = ['Radio', $community->partner_radio, 'text-sky-600', '📻']; @endphp @endif
    @if ($community->partner_spotify) @php $partners[] = ['Spotify', $community->partner_spotify, 'text-green-600', '🎵']; @endphp @endif
    @if ($community->partner_youtube) @php $partners[] = ['YouTube', $community->partner_youtube, 'text-red-600', '▶️']; @endphp @endif
    @if ($community->partner_local) @php $partners[] = ['Radio/TV Lokal', $community->partner_local, 'text-purple-600', '📡']; @endphp @endif

    @if (count($partners) > 0)
    <section class="py-8 bg-white border-b border-sky-100">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Media Mitra</h3>
            <div class="flex flex-wrap gap-3">
                @foreach ($partners as $p)
                <a href="{{ $p[1] }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 hover:shadow-sm transition {{ $p[2] }} text-sm font-medium">
                    <span>{{ $p[3] }}</span> {{ $p[0] }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- STUDIO --}}
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-sky-900 mb-8">Studio</h2>

            @if ($studios->isEmpty())
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-sky-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 0 2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128m0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" /></svg>
                <p class="text-sky-500">Belum ada studio di komunitas ini.</p>
            </div>
            @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($studios as $studio)
                <div class="bg-white border border-sky-200 rounded-xl p-5 hover:shadow-md transition">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center shrink-0">
                            @if ($studio->logo)
                            <img src="{{ asset("storage/" . $studio->logo) }}" alt="{{ $studio->name }}" class="w-full h-full object-cover rounded-xl">
                            @else
                            <svg class="w-7 h-7 text-sky-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z" /></svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $studio->name }}</h3>
                            @if ($studio->location)
                            <p class="text-xs text-gray-400">{{ $studio->location }}</p>
                            @endif
                        </div>
                    </div>
                    @if ($studio->description)
                    <p class="text-sm text-gray-500 mt-3">{{ Str::limit($studio->description, 100) }}</p>
                    @endif
                    <div class="flex flex-wrap gap-2 mt-3">
                        @if ($studio->youtube_url) <a href="{{ $studio->youtube_url }}" target="_blank" class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded hover:bg-red-100">▶️ YouTube</a> @endif
                        @if ($studio->spotify_url) <a href="{{ $studio->spotify_url }}" target="_blank" class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded hover:bg-green-100">🎵 Spotify</a> @endif
                        @if ($studio->stream_url) <a href="{{ $studio->stream_url }}" target="_blank" class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded hover:bg-purple-100">🔴 Live</a> @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
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

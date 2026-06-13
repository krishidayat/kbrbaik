<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Pojok KBRBaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex">
    @auth
    {{-- SIDEBAR --}}
    <div class="w-64 bg-sky-900 text-white flex flex-col fixed h-full z-30 transition-all duration-300" id="sidebar">
        <div class="p-5 border-b border-sky-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr($station->name ?? 'P', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-sm truncate">{{ $station->name ?? 'Pojok' }}</p>
                    <p class="text-[10px] text-sky-300 truncate">{{ $station->stream_mount ?? 'offline' }}</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
            <a href="{{ route('pojok.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('pojok.dashboard') ? 'bg-sky-800 text-white' : 'text-sky-200 hover:bg-sky-800/50 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                Dashboard
            </a>

            <div class="pt-3 pb-1">
                <p class="px-3 text-[10px] font-semibold uppercase tracking-widest text-sky-400">Playlist</p>
            </div>

            @php $periodList = ['subuh'=>'Subuh','pagi'=>'Pagi','siang'=>'Siang','sore'=>'Sore','malam'=>'Malam']; @endphp
            @php $icons = ['subuh'=>'🌅','pagi'=>'☀️','siang'=>'🌤️','sore'=>'🌆','malam'=>'🌙']; @endphp
            @foreach ($periodList as $key => $label)
            <a href="{{ route('pojok.playlist', $key) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->segment(2) === $key ? 'bg-sky-800 text-white' : 'text-sky-200 hover:bg-sky-800/50 hover:text-white' }}">
                <span class="text-base">{{ $icons[$key] ?? '🎵' }}</span>
                {{ $label }}
            </a>
            @endforeach

            <div class="pt-3 pb-1">
                <p class="px-3 text-[10px] font-semibold uppercase tracking-widest text-sky-400">Lainnya</p>
            </div>
            <a href="{{ route('pojok.webcast') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('pojok.webcast') ? 'bg-sky-800 text-white' : 'text-sky-200 hover:bg-sky-800/50 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                Webcast Relay
            </a>
            <a href="{{ route('pojok.liquidsoap') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('pojok.liquidsoap') ? 'bg-sky-800 text-white' : 'text-sky-200 hover:bg-sky-800/50 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25"/></svg>
                Liquidsoap
            </a>
            <a href="{{ route('kredensi.tulis') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-sky-200 hover:bg-sky-800/50 hover:text-white transition">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                Dashboard Utama
            </a>
        </nav>

        <div class="p-4 border-t border-sky-800 text-sm">
            <p class="text-sky-200 truncate">{{ auth()->user()->name }}</p>
            <a href="{{ route('kredensi.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-sky-400 hover:text-white text-xs transition">Logout</a>
            <form id="logout-form" method="POST" action="{{ route('kredensi.logout') }}" class="hidden">@csrf</form>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="ml-64 flex-1 min-h-screen flex flex-col" id="main-content">
        {{-- TOP BAR --}}
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-64')"
                        class="lg:hidden p-1.5 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>
                <h1 class="font-bold text-lg text-sky-900">@yield('page_title', 'Dashboard')</h1>
            </div>
            @if ($station ?? false)
            <a href="https://radio.kbrbaik.live{{ $station->stream_mount }}" target="_blank"
               class="bg-sky-600 hover:bg-sky-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                Dengar
            </a>
            @endif
        </header>

        {{-- FLASH --}}
        @if (session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-xl shadow-lg text-sm font-medium" id="flash-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-50 border border-red-200 text-red-800 px-5 py-3 rounded-xl shadow-lg text-sm font-medium" id="flash-error">
            {{ session('error') }}
        </div>
        @endif

        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <footer class="border-t border-gray-200 px-6 py-4 text-center text-xs text-gray-400">
            Pojok Dashboard &copy; {{ date('Y') }} KBRBaik
        </footer>
    </div>
    @endauth

    @guest
    <div class="w-full">
        @yield('guest_content')
    </div>
    @endguest

    <script>
        setTimeout(function() {
            var f = document.getElementById('flash-success');
            if (f) f.remove();
            var e = document.getElementById('flash-error');
            if (e) e.remove();
        }, 4000);

        if (window.innerWidth < 1024) {
            var s = document.getElementById('sidebar');
            if (s) s.classList.add('-translate-x-64');
        }
    </script>
    @stack('scripts')
</body>
</html>

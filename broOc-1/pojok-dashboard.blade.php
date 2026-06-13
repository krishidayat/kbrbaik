<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pojok — Dashboard Komunitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <div class="w-64 bg-sky-900 text-white flex flex-col">
            <div class="p-6 border-b border-sky-800">
                <h1 class="text-lg font-bold">Pojok</h1>
                <p class="text-xs text-sky-300">Dashboard Komunitas</p>
            </div>
            <div class="flex-1 p-4 space-y-1 text-sm">
                <a href="#" class="block px-3 py-2 rounded bg-sky-800 font-semibold">Beranda</a>
                <a href="#" class="block px-3 py-2 rounded hover:bg-sky-800">Siaran</a>
                <a href="#" class="block px-3 py-2 rounded hover:bg-sky-800">Audio</a>
                <a href="#" class="block px-3 py-2 rounded hover:bg-sky-800">Anggota</a>
                <a href="#" class="block px-3 py-2 rounded hover:bg-sky-800">Pengaturan</a>
            </div>
            <div class="p-4 border-t border-sky-800 text-sm">
                @if (auth()->check())
                <p class="text-sky-200">{{ auth()->user()->name }}</p>
                <a href="{{ route('kredensi.logout') }}" class="text-sky-400 hover:text-white text-xs">Logout</a>
                @else
                <a href="{{ route('kredensi') }}" class="text-sky-400 hover:text-white text-xs">Login</a>
                @endif
            </div>
        </div>

        {{-- Main --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            <header class="bg-white border-b px-6 py-4 flex items-center justify-between">
                <div>
                    @if ($station)
                    <h2 class="text-xl font-bold text-sky-900">{{ $station->name }}</h2>
                    <p class="text-sm text-gray-400">{{ $station->stream_mount }}</p>
                    @elseif (auth()->check())
                    <h2 class="text-xl font-bold text-sky-900">Selamat Datang</h2>
                    <p class="text-sm text-gray-400">Anda belum terdaftar di studio/komunitas</p>
                    @else
                    <h2 class="text-xl font-bold text-sky-900">Pojok KBRBaik</h2>
                    <p class="text-sm text-gray-400">Dashboard manajemen radio komunitas</p>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    @if ($station)
                    <a href="https://radio.kbrbaik.live{{ $station->stream_mount }}" target="_blank"
                        class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        Dengar
                    </a>
                    @endif
                    @auth
                    <a href="{{ route('kredensi.tulis') }}" class="text-gray-500 hover:text-sky-700 text-sm">Dashboard Utama</a>
                    @endauth
                </div>
            </header>

            {{-- Content --}}
            <div class="flex-1 p-6 overflow-y-auto">
                @if (!auth()->check())
                <div class="max-w-md mx-auto mt-12 text-center">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Masuk ke Dashboard</h3>
                    <p class="text-sm text-gray-400 mb-6">Login untuk mengelola radio komunitas Anda</p>
                    <a href="{{ route('kredensi') }}"
                        class="inline-block bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Login / Daftar
                    </a>
                </div>
                @elseif (!$station)
                <div class="max-w-md mx-auto mt-12 text-center">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Terdaftar</h3>
                    <p class="text-sm text-gray-400">Anda belum terdaftar di studio/komunitas mana pun.</p>
                </div>
                @else
                {{-- Station Info Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl border p-5">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Stasiun</p>
                        <p class="text-lg font-bold text-sky-900 mt-1">{{ $station->name }}</p>
                        <p class="text-sm text-gray-400">{{ $station->description ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-xl border p-5">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Studio</p>
                        <p class="text-lg font-bold text-sky-900 mt-1">{{ $userStudio->name ?? '-' }}</p>
                        <p class="text-sm text-gray-400">{{ $userStudio->description ?? '' }}</p>
                    </div>
                    <div class="bg-white rounded-xl border p-5">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Stream</p>
                        <a href="https://radio.kbrbaik.live{{ $station->stream_mount }}" target="_blank"
                            class="text-lg font-bold text-sky-600 hover:underline mt-1 block">
                            radio.kbrbaik.live{{ $station->stream_mount }}
                        </a>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-xl border p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Fitur</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ url('/admin/audio-tracks') }}"
                            class="bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg p-4 text-center transition">
                            <p class="text-2xl">🎵</p>
                            <p class="text-sm font-semibold text-sky-700 mt-2">Audio Tracks</p>
                            <p class="text-xs text-sky-500">Upload lagu</p>
                        </a>
                        <a href="{{ url('/admin/stations') }}"
                            class="bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg p-4 text-center transition">
                            <p class="text-2xl">📻</p>
                            <p class="text-sm font-semibold text-sky-700 mt-2">Stasiun</p>
                            <p class="text-xs text-sky-500">Pengaturan</p>
                        </a>
                        <a href="{{ route('kredensi.undangan.buat') }}"
                            class="bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg p-4 text-center transition">
                            <p class="text-2xl">👥</p>
                            <p class="text-sm font-semibold text-sky-700 mt-2">Anggota</p>
                            <p class="text-xs text-sky-500">Undang</p>
                        </a>
                        <a href="https://radio.kbrbaik.live{{ $station->stream_mount }}" target="_blank"
                            class="bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg p-4 text-center transition">
                            <p class="text-2xl">🔊</p>
                            <p class="text-sm font-semibold text-sky-700 mt-2">Stream</p>
                            <p class="text-xs text-sky-500">Dengar langsung</p>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>

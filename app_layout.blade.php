<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $station?->name ?? 'KBRBaik')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81', 950: '#1e1b4b' }
                    }
                }
            }
        }
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <nav class="bg-primary-700 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-xl font-bold">{{ $station?->name ?? 'KBRBaik' }}</span>
                </a>
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-primary-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="hidden md:flex space-x-6 text-sm">
                    <a href="{{ route('home') }}" class="hover:text-primary-200 transition">Beranda</a>
                    <a href="{{ route('komunitas') }}" class="hover:text-primary-200 transition">Komunitas</a>
                    @auth
                    <a href="{{ route('profil') }}" class="hover:text-primary-200 transition">{{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-primary-200 transition">Keluar</button>
                    </form>
                    @else
                    <a href="{{ route('masuk') }}" class="hover:text-primary-200 transition">Masuk</a>
                    @endauth
                </div>
            </div>
            <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Beranda</a>
                <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Komunitas</a>
                @auth
                <a href="{{ route('profil') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">{{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg hover:bg-primary-600 transition">Keluar</button>
                </form>
                @else
                <a href="{{ route('masuk') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-primary-800 text-white mt-12">
        <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                <div>
                    <h3 class="text-white font-semibold mb-3">Radio</h3>
                    <ul class="space-y-1.5 text-primary-300">
                        <li><a href="https://radio.kbrbaik.live/stream" target="_blank" class="hover:text-white transition">Main Stream</a></li>
                        <li><a href="https://radio.kbrbaik.live/suara" target="_blank" class="hover:text-white transition">Suara PGIW Jabar</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-3">Komunitas</h3>
                    <ul class="space-y-1.5 text-primary-300">
                        @php $commStreams = [['Kabar Purwodadi','kabar-purwodadi'],['Kabar Semarang','kabar-semarang'],['Kabar Wonogiri','kabar-wonogiri'],['Kabar Wonosobo','kabar-wonosobo'],['Kabar Depok','kabar-depok'],['Kabar Jogjakarta','kabar-jogjakarta'],['Kabar Bandung','kabar-bandung'],['Kabar Solo','kabar-solo']]; @endphp
                        @foreach ($commStreams as $cs)
                        <li><a href="https://radio.kbrbaik.live/{{ $cs[1] }}" target="_blank" class="hover:text-white transition">{{ $cs[0] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-3">Tautan</h3>
                    <ul class="space-y-1.5 text-primary-300">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('komunitas') }}" class="hover:text-white transition">Komunitas</a></li>
                        <li><a href="{{ route('kbrbaik.blog') }}" class="hover:text-white transition">Blog</a></li>
                        <li><a href="{{ route('kbrbaik.agenda') }}" class="hover:text-white transition">Agenda</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-3">{{ $station?->name ?? 'KBRBaik' }}</h3>
                    <p class="text-primary-300">Radio Komunitas berbasis klasis</p>
                    <p class="text-primary-400 text-xs mt-2">&copy; {{ date('Y') }} {{ $station?->name ?? 'KBRBaik' }}</p>
                </div>
            </div>
        </div>
    </footer>

    @include('partials.player')
</body>
</html>

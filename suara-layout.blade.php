<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $station?->name ?? 'Suara PGIW Jabar')</title>
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
    </script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    {{-- NAV --}}
    <nav class="bg-primary-700 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-xl font-bold">{{ $station?->name ?? 'Suara PGIW Jabar' }}</span>
                </a>
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-primary-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-primary-200 transition">Beranda</a>
                    <a href="{{ route('agenda') }}" class="hover:text-primary-200 transition">Agenda</a>
                    <a href="{{ route('bidang') }}" class="hover:text-primary-200 transition">Bidang</a>
                    <a href="{{ route('pgis') }}" class="hover:text-primary-200 transition">PGIS</a>
                    <a href="{{ route('pouk') }}" class="hover:text-primary-200 transition">POUK</a>
                    <a href="{{ route('gereja') }}" class="hover:text-primary-200 transition">Gereja</a>
                    <a href="{{ route('media') }}" class="hover:text-primary-200 transition">Media</a>
                </div>
            </div>
            <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Beranda</a>
                <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Agenda</a>
                <a href="{{ route('bidang') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Bidang</a>
                <a href="{{ route('pgis') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">PGIS</a>
                <a href="{{ route('pouk') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">POUK</a>
                <a href="{{ route('gereja') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Gereja</a>
                <a href="{{ route('media') }}" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Media</a>
            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-primary-800 text-white mt-12">
        <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-3">{{ $station?->name ?? 'Suara PGIW Jabar' }}</h3>
                    <p class="text-primary-200 text-sm mb-3">{{ $station?->description ?? 'Radio Suara PGIW Jawa Barat' }}</p>
                    <div class="space-y-1.5">
                        <a href="{{ route('struktur') }}" class="text-primary-300 hover:text-white transition inline-flex items-center gap-1.5 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Struktur &amp; Personalia
                        </a>
                        <a href="{{ route('struktur.pgis') }}" class="text-primary-300 hover:text-white transition inline-flex items-center gap-1.5 text-sm ml-6">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Struktur PGIS
                        </a>
                        <a href="{{ route('struktur.pouk') }}" class="text-primary-300 hover:text-white transition inline-flex items-center gap-1.5 text-sm ml-6">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Struktur POUK
                        </a>
                        <a href="{{ route('struktur.gereja') }}" class="text-primary-300 hover:text-white transition inline-flex items-center gap-1.5 text-sm ml-6">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Struktur Gereja
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">Menu</h4>
                    <ul class="space-y-2 text-sm text-primary-200">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">Kontak</h4>
                    <ul class="space-y-2 text-sm text-primary-200">
                        <li>Email: info@pgiwjabar.org</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-primary-600 mt-6 pt-6 text-center text-sm text-primary-300">
                &copy; {{ date('Y') }} {{ $station?->name ?? 'Suara PGIW Jabar' }}
            </div>
        </div>
    </footer>
@include('partials.player')
</body>
</html>

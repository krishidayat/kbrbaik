<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelatihan - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>function toggleMobileMenu(){document.getElementById('mobile-menu').classList.toggle('hidden')}</script>
    <style>
        .materi-card:hover img{transform:scale(1.05)}
        @keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        .animate-fade{animation:fadeIn 0.5s ease}
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">
    {{-- NAV --}}
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight">Radio KbrBaik</span>
            </a>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('kbrbaik.blog') }}" class="hover:text-sky-200 transition">Narasi</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('studio') }}" class="hover:text-sky-200 transition">Studio</a>
                <a href="{{ route('pelatihan') }}" class="font-semibold text-sky-200 transition">Pelatihan</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('kbrbaik.blog') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Narasi</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('studio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Studio</a>
            <a href="{{ route('pelatihan') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>
    </nav>

    {{-- HERO --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
        <div class="relative max-w-6xl mx-auto px-4 py-16 md:py-20 text-center">
            <h1 class="text-3xl md:text-5xl font-bold">Pelatihan Radio & Media Gereja</h1>
            <p class="text-white/80 mt-3 max-w-2xl mx-auto">Belajar memproduksi podcast, mengelola siaran radio, dan menjadi kreator konten Kabar Baik — berbasis proyek nyata.</p>
            <a href="#" class="inline-block mt-6 bg-white text-sky-700 px-8 py-3 rounded-lg font-bold hover:bg-sky-50 transition">Mulai Belajar →</a>
        </div>
    </div>

    {{-- KURIKULUM --}}
    <div class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-sky-900 mb-8">📚 Kurikulum Pelatihan</h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Course 1: Dasar Radio & Streaming --}}
            <div class="bg-white rounded-xl border border-sky-200 overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-2 bg-sky-600"></div>
                <div class="p-5">
                    <span class="text-xs font-mono font-bold text-sky-500 uppercase tracking-widest">Modul 1</span>
                    <h3 class="font-bold text-gray-900 mt-1">Dasar Radio & Streaming</h3>
                    <p class="text-sm text-gray-500 mt-2">Mengenal teknologi radio streaming, Icecast, dan setup server siaran digital.</p>
                    <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
                        <span>📖 4 materi</span>
                        <span>⏱ 2 jam</span>
                    </div>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-sky-600 hover:text-sky-800">Mulai →</a>
                </div>
            </div>

            {{-- Course 2: Produksi Podcast --}}
            <div class="bg-white rounded-xl border border-sky-200 overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-2 bg-green-600"></div>
                <div class="p-5">
                    <span class="text-xs font-mono font-bold text-green-500 uppercase tracking-widest">Modul 2</span>
                    <h3 class="font-bold text-gray-900 mt-1">Produksi Podcast</h3>
                    <p class="text-sm text-gray-500 mt-2">Riset, naskah, rekaman, editing, mastering, dan distribusi podcast ke Spotify/YouTube.</p>
                    <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
                        <span>📖 6 materi</span>
                        <span>⏱ 4 jam</span>
                    </div>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-green-600 hover:text-green-800">Mulai →</a>
                </div>
            </div>

            {{-- Course 3: Konten Kreatif --}}
            <div class="bg-white rounded-xl border border-sky-200 overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-2 bg-amber-600"></div>
                <div class="p-5">
                    <span class="text-xs font-mono font-bold text-amber-500 uppercase tracking-widest">Modul 3</span>
                    <h3 class="font-bold text-gray-900 mt-1">Konten Kreatif Media</h3>
                    <p class="text-sm text-gray-500 mt-2">Fotografi, videografi, copywriting, dan desain grafis untuk media sosial gereja.</p>
                    <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
                        <span>📖 5 materi</span>
                        <span>⏱ 3 jam</span>
                    </div>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-amber-600 hover:text-amber-800">Mulai →</a>
                </div>
            </div>

            {{-- Course 4: Laravel untuk Media --}}
            <div class="bg-white rounded-xl border border-sky-200 overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-2 bg-purple-600"></div>
                <div class="p-5">
                    <span class="text-xs font-mono font-bold text-purple-500 uppercase tracking-widest">Modul 4</span>
                    <h3 class="font-bold text-gray-900 mt-1">Laravel untuk Media Gereja</h3>
                    <p class="text-sm text-gray-500 mt-2">Membangun backend komunitas, auth multi-tenant, dan API konten dengan Laravel.</p>
                    <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
                        <span>📖 8 materi</span>
                        <span>⏱ 6 jam</span>
                    </div>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-purple-600 hover:text-purple-800">Mulai →</a>
                </div>
            </div>

            {{-- Course 5: Manajemen Komunitas --}}
            <div class="bg-white rounded-xl border border-sky-200 overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-2 bg-red-600"></div>
                <div class="p-5">
                    <span class="text-xs font-mono font-bold text-red-500 uppercase tracking-widest">Modul 5</span>
                    <h3 class="font-bold text-gray-900 mt-1">Manajemen Komunitas Klasikal</h3>
                    <p class="text-sm text-gray-500 mt-2">CRUD wilayah, studio, anggota, dan dashboard statistik komunitas.</p>
                    <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
                        <span>📖 5 materi</span>
                        <span>⏱ 4 jam</span>
                    </div>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-red-600 hover:text-red-800">Mulai →</a>
                </div>
            </div>

            {{-- Course 6: API & Integrasi --}}
            <div class="bg-white rounded-xl border border-sky-200 overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-2 bg-indigo-600"></div>
                <div class="p-5">
                    <span class="text-xs font-mono font-bold text-indigo-500 uppercase tracking-widest">Modul 6</span>
                    <h3 class="font-bold text-gray-900 mt-1">API & Integrasi Next.js</h3>
                    <p class="text-sm text-gray-500 mt-2">Membangun API Laravel, dokumentasi Swagger, dan konsumsi dari frontend Next.js.</p>
                    <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
                        <span>📖 4 materi</span>
                        <span>⏱ 3 jam</span>
                    </div>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Mulai →</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ROADMAP --}}
    <div class="bg-white border-t border-b border-gray-200 py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-sky-900 mb-8 text-center">🗺️ Roadmap 4 Fase</h2>
            <div class="grid md:grid-cols-4 gap-4">
                <div class="bg-sky-50 border border-sky-200 rounded-xl p-5 text-center">
                    <span class="text-2xl font-bold text-sky-600">1</span>
                    <h3 class="font-bold text-gray-900 mt-1">Auth & CRUD</h3>
                    <p class="text-xs text-gray-500 mt-1">Laravel dasar, login, role, data jemaat & studio</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center">
                    <span class="text-2xl font-bold text-green-600">2</span>
                    <h3 class="font-bold text-gray-900 mt-1">Komunitas</h3>
                    <p class="text-xs text-gray-500 mt-1">Modul wilayah, studio, anggota, & statistik</p>
                </div>
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 text-center">
                    <span class="text-2xl font-bold text-amber-600">3</span>
                    <h3 class="font-bold text-gray-900 mt-1">Konten</h3>
                    <p class="text-xs text-gray-500 mt-1">Episode podcast, jadwal siaran, & katalog</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-5 text-center">
                    <span class="text-2xl font-bold text-purple-600">4</span>
                    <h3 class="font-bold text-gray-900 mt-1">API & Frontend</h3>
                    <p class="text-xs text-gray-500 mt-1">Integrasi API ke Next.js & mobile app</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 3 TAHAP KETERLIBATAN --}}
    <div class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-sky-900 mb-8 text-center">🎯 3 Tahap Keterlibatan</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white border border-sky-200 rounded-xl p-6 text-center hover:shadow-md transition">
                <div class="w-14 h-14 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center mx-auto mb-3 text-2xl">📢</div>
                <h3 class="font-bold text-gray-900">Sosialisasi</h3>
                <p class="text-sm text-gray-500 mt-2">Mengenal ekosistem Kabar Baik dan peluang keterlibatan sebagai kreator konten.</p>
            </div>
            <div class="bg-white border border-green-200 rounded-xl p-6 text-center hover:shadow-md transition">
                <div class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-3 text-2xl">🎓</div>
                <h3 class="font-bold text-gray-900">Pelatihan</h3>
                <p class="text-sm text-gray-500 mt-2">Mengikuti kursus terstruktur dan praktek langsung produksi konten media.</p>
            </div>
            <div class="bg-white border border-amber-200 rounded-xl p-6 text-center hover:shadow-md transition">
                <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-3 text-2xl">🚀</div>
                <h3 class="font-bold text-gray-900">Belajar sambil Berbuat</h3>
                <p class="text-sm text-gray-500 mt-2">Bergabung dengan studio, produksi konten nyata, dan dapatkan pengakuan.</p>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white py-12">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold">Siap Bergabung?</h2>
            <p class="text-white/80 mt-2">Daftar sekarang dan mulai perjalananmu sebagai kreator konten Kabar Baik.</p>
            <a href="{{ route('home') }}#bergabung" class="inline-block mt-6 bg-white text-sky-700 px-8 py-3 rounded-lg font-bold hover:bg-sky-50 transition">Daftar Sekarang →</a>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="bg-sky-800 text-sky-200 py-6">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm">
            &copy; {{ date('Y') }} {{ $station?->name ?? 'KBRBaik' }}
        </div>
    </footer>

    @include('partials.player')
</body>
</html>

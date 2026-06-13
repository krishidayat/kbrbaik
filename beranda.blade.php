<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $station?->name ?? 'KBRBaik' }} - Radio Komunitas & AI Otonom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">
    {{-- NAV --}}
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
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('services') }}" class="hover:text-sky-200 transition">Layanan</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>
        </div>
    </nav>

    {{-- HERO SLIDER --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white" id="hero-slider">
        @if (isset($heroPosts) && $heroPosts->count())
        <div class="relative h-[60vh] min-h-[400px]">
            @foreach ($heroPosts as $i => $post)
            <div class="absolute inset-0 transition-opacity duration-700 {{ $i === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $i }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent z-10"></div>
                @if ($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full bg-gradient-to-br from-sky-400 to-sky-600"></div>
                @endif
                <div class="absolute bottom-0 left-0 right-0 z-20 p-6 md:p-12 max-w-6xl mx-auto">
                    @if ($post->category)
                    <span class="text-xs font-semibold bg-white/20 text-white px-3 py-1 rounded-full backdrop-blur">{{ $post->category->name }}</span>
                    @endif
                    <h2 class="text-2xl md:text-4xl font-bold text-white mt-3 mb-2 max-w-2xl">{{ $post->title }}</h2>
                    @if ($post->excerpt)
                    <p class="text-sm md:text-base text-gray-200 max-w-xl">{{ Str::limit($post->excerpt, 150) }}</p>
                    @endif
                    <a href="{{ route('post', $post->slug) }}" class="inline-block mt-4 bg-white text-sky-700 px-5 py-2 rounded-lg font-semibold text-sm hover:bg-sky-50 transition">Baca Selengkapnya</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="absolute bottom-4 right-4 md:right-12 z-30 flex gap-2">
            @foreach ($heroPosts as $i => $post)
            <button class="w-2.5 h-2.5 rounded-full transition-all {{ $i === 0 ? 'bg-white w-6' : 'bg-white/50' }}" data-dot="{{ $i }}" onclick="goSlide({{ $i }})"></button>
            @endforeach
        </div>
        <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition backdrop-blur">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition backdrop-blur">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        @else
        <div class="max-w-6xl mx-auto px-4 py-20 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">{{ $station?->name ?? 'Radio Kabar Baik' }}</h1>
            <p class="text-xl text-sky-100 max-w-2xl mx-auto">Radio komunitas, konten kreatif, dan otomatisasi AI — Satu ekosistem untuk pelayanan ekumenis PGIW Jawa Barat.</p>
            <div class="mt-8 flex justify-center gap-4 flex-wrap">
                <a href="#aktivitas" class="bg-white text-sky-700 px-6 py-3 rounded-lg font-semibold hover:bg-sky-50 transition">Jelajahi Layanan</a>
                <button onclick="document.getElementById('kbr-btn-play').click()" class="border border-white/30 px-6 py-3 rounded-lg font-semibold hover:bg-white/10 transition">Dengarkan Live</button>
            </div>
        </div>
        @endif
    </section>

    <script>
    var currentSlide = 0;
    var totalSlides = {{ isset($heroPosts) && $heroPosts->count() ? $heroPosts->count() : 0 }};
    var autoSlide = totalSlides > 1 ? setInterval(nextSlide, 5000) : null;

    function showSlide(i) {
        if (totalSlides === 0) return;
        document.querySelectorAll('#hero-slider [data-slide]').forEach(function(el, idx) {
            el.classList.toggle('opacity-100', idx === i);
            el.classList.toggle('opacity-0', idx !== i);
        });
        document.querySelectorAll('#hero-slider [data-dot]').forEach(function(el, idx) {
            el.classList.toggle('bg-white', idx === i);
            el.classList.toggle('bg-white/50', idx !== i);
            el.classList.toggle('w-6', idx === i);
            el.classList.toggle('w-2.5', idx !== i);
        });
    }

    function goSlide(i) { clearInterval(autoSlide); currentSlide = i; showSlide(i); if (totalSlides > 1) autoSlide = setInterval(nextSlide, 5000); }
    function prevSlide() { goSlide(currentSlide === 0 ? totalSlides - 1 : currentSlide - 1); }
    function nextSlide() { goSlide((currentSlide + 1) % totalSlides); }
    </script>

    {{-- AKTIVITAS KABAR BAIK --}}
    <section id="aktivitas" class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-3 text-sky-900">Aktivitas Kabar Baik</h2>
            </div>

            <div class="grid md:grid-cols-4 gap-4">
                <div class="bg-white border border-sky-200 rounded-xl p-5 hover:border-sky-400 hover:shadow-lg transition-all group">
                    <div class="w-full h-32 rounded-lg bg-gradient-to-br from-sky-100 to-sky-50 mb-4 flex items-center justify-center border border-sky-100 group-hover:border-sky-200 transition-all">
                        <svg class="w-16 h-16 text-sky-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 0 2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128m0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-sky-500">Aktivitas 01</span>
                    <h3 class="text-lg font-display font-bold text-gray-900 mt-1">Kabar Media & AI</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">Otomatisasi konten berbasis AI generatif untuk publikasi ganda secara otonom.</p>
                </div>

                <div class="bg-white border border-sky-200 rounded-xl p-5 hover:border-indigo-300 hover:shadow-lg transition-all group">
                    <div class="w-full h-32 rounded-lg bg-gradient-to-br from-indigo-100 to-indigo-50 mb-4 flex items-center justify-center border border-indigo-100 group-hover:border-indigo-200 transition-all">
                        <svg class="w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-indigo-500">Aktivitas 02</span>
                    <h3 class="text-lg font-display font-bold text-gray-900 mt-1">Kabar Intergenerasi</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">Kolaborasi lintas generasi dalam pelayanan, pelatihan, dan kreativitas bersama.</p>
                </div>

                <div class="bg-white border border-sky-200 rounded-xl p-5 hover:border-amber-300 hover:shadow-lg transition-all group">
                    <div class="w-full h-32 rounded-lg bg-gradient-to-br from-amber-100 to-amber-50 mb-4 flex items-center justify-center border border-amber-100 group-hover:border-amber-200 transition-all">
                        <svg class="w-16 h-16 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-amber-500">Aktivitas 03</span>
                    <h3 class="text-lg font-display font-bold text-gray-900 mt-1">Kabar Pojok Muda</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">Wadah kreatif pemuda — podcast, diskusi, dan konten digital kekinian.</p>
                </div>

                <div class="bg-white border border-sky-200 rounded-xl p-5 hover:border-purple-300 hover:shadow-lg transition-all group">
                    <div class="w-full h-32 rounded-lg bg-gradient-to-br from-purple-100 to-purple-50 mb-4 flex items-center justify-center border border-purple-100 group-hover:border-purple-200 transition-all">
                        <svg class="w-16 h-16 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-purple-500">Aktivitas 04</span>
                    <h3 class="text-lg font-display font-bold text-gray-900 mt-1">Kabar Kolaborasi</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">Sinergi lintas gereja dan mitra strategis untuk jejaring ekumenis.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- KABAR BAIK UNTUK SEMUA --}}
    <section id="blog" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-sky-900">Kabar Baik Untuk Semua</h2>
                <a href="{{ route('kbrbaik.blog') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-sky-600 hover:text-sky-800 transition">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                </a>
            </div>

            <div class="flex flex-wrap gap-2 mb-8 border-b border-sky-200 pb-2" id="blog-tabs"></div>

            <div id="posts-loading" class="text-center py-12 hidden">
                <svg class="animate-spin h-8 w-8 text-sky-400 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="posts-grid"></div>
            <div id="posts-empty" class="text-center py-12 text-sky-400 hidden">Belum ada postingan.</div>
        </div>
    </section>

    <script>
    var currentCategory = 'kabar';

    function switchTab(slug) {
        currentCategory = slug;
        document.querySelectorAll('#blog .tab-btn').forEach(function(btn) {
            var isActive = btn.dataset.category === slug;
            btn.classList.toggle('bg-sky-800', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('bg-sky-50', !isActive);
            btn.classList.toggle('text-sky-600', !isActive);
        });
        fetchPosts(slug);
    }

    function renderPost(post) {
        var img = post.featured_image
            ? '<img src="' + post.featured_image + '" alt="' + post.title + '" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">'
            : '<div class="w-full h-full bg-gradient-to-br from-sky-200 to-sky-300"></div>';
        return '<a href="/posts/' + post.slug + '" class="group relative block rounded-xl overflow-hidden shadow-sm border border-sky-100 hover:shadow-lg transition-all duration-300">'
            + '<div class="aspect-[4/3] overflow-hidden">' + img + '</div>'
            + '<div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/70 to-transparent">'
            + '<h4 class="text-white font-semibold text-sm leading-tight">' + post.title + '</h4>'
            + '<span class="text-xs text-white/80">' + post.published_at + '</span></div></a>';
    }

    async function fetchPosts(slug) {
        var grid = document.getElementById('posts-grid');
        var loading = document.getElementById('posts-loading');
        var empty = document.getElementById('posts-empty');
        grid.classList.add('hidden');
        empty.classList.add('hidden');
        loading.classList.remove('hidden');
        try {
            var url = '/api/posts/group/kbrbaik/' + slug;
            var res = await fetch(url);
            var json = await res.json();
            var posts = json.data || [];
            loading.classList.add('hidden');
            if (posts.length === 0) {
                empty.classList.remove('hidden');
                grid.classList.add('hidden');
            } else {
                grid.innerHTML = posts.map(renderPost).join('');
                grid.classList.remove('hidden');
            }
        } catch(e) {
            loading.classList.add('hidden');
            empty.classList.remove('hidden');
            empty.textContent = 'Gagal memuat postingan.';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var container = document.getElementById('blog-tabs');
        if (!container) return;
        fetch('/api/kbrbaik/categories').then(function(r) { return r.json(); }).then(function(cats) {
            cats.forEach(function(c, i) {
                var btn = document.createElement('button');
                btn.className = 'tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200';
                if (i === 0) { btn.classList.add('bg-sky-800', 'text-white'); }
                else { btn.classList.add('bg-sky-50', 'text-sky-600'); }
                btn.dataset.category = c.slug;
                btn.textContent = c.name;
                btn.onclick = function() { switchTab(c.slug); };
                container.appendChild(btn);
            });
        }).catch(function() {});
        fetchPosts('kabar');
    });
    </script>

    {{-- FOOTER --}}
    <footer class="bg-sky-800 text-sky-200 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $station?->name ?? 'Radio Kabar Baik' }}. All rights reserved.</p>
        </div>
    </footer>
@include('partials.player')
</body>
</html>

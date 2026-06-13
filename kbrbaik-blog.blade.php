<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - {{ $station?->name ?? 'Radio Kabar Baik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight">Radio KbrBaik</span>
            </a>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('services') }}" class="hover:text-sky-200 transition">Layanan</a>
                <a href="{{ route('pelatihan') }}" class="hover:text-sky-200 transition">Pelatihan</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>
            <a href="{{ route('pelatihan') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>
    </nav>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Left: Title + Blog Posts --}}
                <div class="md:w-3/4">
                    <h1 class="text-4xl font-bold mb-8 text-sky-900">Kabar Baik Untuk Semua</h1>

                    <div id="posts-loading" class="text-center py-12">
                        <svg class="animate-spin h-8 w-8 text-sky-400 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6 hidden" id="posts-grid"></div>
                    <div id="posts-empty" class="text-center py-12 text-sky-400 hidden">Belum ada postingan.</div>
                </div>

                {{-- Right: Category Tabs --}}
                <div class="md:w-1/4">
                    <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                        <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Kategori</h3>
                        <div id="tab-container" class="space-y-2"></div>
                        <button id="btn-semua" onclick="switchTab('semua')" class="mt-3 flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm font-semibold bg-sky-800 text-white hover:bg-sky-700 transition w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            Semua
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-sky-800 text-sky-200 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $station?->name ?? 'Radio Kabar Baik' }}. All rights reserved.</p>
        </div>
    </footer>
    @include('partials.player')

    <script>
    var currentCategory = 'kabar';

    function switchTab(slug) {
        currentCategory = slug;
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            var isActive = btn.dataset.category === slug;
            btn.classList.toggle('bg-sky-800', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('text-sky-700', !isActive);
            btn.classList.toggle('bg-white', !isActive);
        });
        // Reset 'Semua' button active state
        var semuaBtn = document.getElementById('btn-semua');
        if (slug === 'semua') {
            semuaBtn.classList.add('ring-2', 'ring-sky-400');
        } else {
            semuaBtn.classList.remove('ring-2', 'ring-sky-400');
        }
        fetchPosts(slug);
    }

    var icons = {
        'kabar': '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>',
        'inspirasi': '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>',
        'kbrbaik-opini': '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/></svg>',
        'cerita': '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>',
        'puisi': '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>',
        'lagu': '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>',
        'buku': '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>'
    };

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
        var container = document.getElementById('tab-container');
        if (!container) return;
        fetch('/api/kbrbaik/categories').then(function(r) { return r.json(); }).then(function(cats) {
            cats.forEach(function(c, i) {
                var btn = document.createElement('button');
                btn.className = 'tab-btn flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-left';
                if (i === 0) { btn.classList.add('bg-sky-800', 'text-white'); }
                else { btn.classList.add('bg-white', 'text-sky-700', 'border', 'border-sky-200'); }
                btn.dataset.category = c.slug;
                btn.innerHTML = (icons[c.slug] || '') + ' ' + c.name;
                btn.onclick = function() { switchTab(c.slug); };
                container.appendChild(btn);
            });
        }).catch(function() {});
        fetchPosts('kabar');
    });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen flex flex-col">
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

    <main class="flex-1 max-w-6xl mx-auto px-4 py-8 w-full">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Left: Content Area --}}
            <div class="md:w-3/4 order-2 md:order-1">
                {{-- Tab: Foto --}}
                <div id="gallery-foto" class="tab-content-galeri">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-sky-900">Galeri Foto</h1>
                            <p class="text-sky-600 mt-1">{{ $station?->name ?? 'KBRBaik' }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openModal('upload-modal')" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12"/></svg>
                                Upload
                            </button>
                            <button onclick="openModal('unsplash-modal')" class="bg-white border border-sky-300 hover:bg-sky-100 text-sky-700 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Unsplash
                            </button>
                </div>
            </div>
            <div class="md:sticky md:top-6 mt-4 bg-sky-50 rounded-xl p-5 border border-sky-100">
                <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Album</h3>
                <div id="album-container" class="space-y-2"></div>
            </div>

                    <div id="gallery-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse ($items as $item)
                    <div class="gallery-card relative bg-white rounded-xl overflow-hidden shadow-sm border border-sky-100 hover:shadow-md transition group" data-id="{{ $item->id }}" data-album="{{ $item->album }}">
                <div class="aspect-square min-h-[200px] bg-sky-100 overflow-hidden cursor-pointer"
                     onclick="openViewer('{{ asset("storage/" . $item->image_path) }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->description ?? '') }}')">
                    <img src="{{ asset("storage/" . ($item->thumbnail_path ?? $item->image_path)) }}"
                         alt="{{ $item->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-3 pt-8">
                    <p class="text-white font-semibold text-sm leading-tight truncate">{{ $item->title }}</p>
                    @if ($item->description)
                    <p class="text-white/80 text-xs mt-0.5 line-clamp-1">{{ $item->description }}</p>
                    @endif
                </div>
                @auth
                <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button onclick="event.stopPropagation(); editItem({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->description ?? '') }}')"
                            class="bg-white/90 hover:bg-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button onclick="event.stopPropagation(); deleteItem({{ $item->id }})"
                            class="bg-white/90 hover:bg-red-500 hover:text-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                @endauth
            </div>
            @empty
            <p id="empty-msg" class="text-center text-sky-400 py-12 col-span-full">Belum ada foto di galeri</p>
            @endforelse
                </div>
            </div>

            {{-- Tab: Podcast --}}
            <div id="gallery-podcast" class="tab-content-galeri hidden">
                <h1 class="text-3xl font-bold text-sky-900 mb-6">Podcast</h1>
                @if ($episodes->isEmpty())
                <div class="bg-white border border-sky-100 rounded-xl p-8 text-center">
                    <svg class="w-12 h-12 text-sky-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                    <p class="text-sky-500">Belum ada podcast.</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach ($episodes as $ep)
                    <div class="bg-white border border-sky-100 rounded-xl p-5 hover:shadow-md transition flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900">{{ $ep->title }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ $ep->published_at ? $ep->published_at->format('d M Y') : '' }}</p>
                        </div>
                        @if ($ep->audio_file)
                        @php $au = str_starts_with($ep->audio_file, 'http') ? $ep->audio_file : asset('storage/' . $ep->audio_file); @endphp
                        <button onclick="playEpisode('{{ $au }}', '{{ addslashes($ep->title) }}')" class="w-10 h-10 rounded-full bg-sky-600 hover:bg-sky-700 text-white flex items-center justify-center shrink-0 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Tab: YouTube --}}
            <div id="gallery-youtube" class="tab-content-galeri hidden">
                <h1 class="text-3xl font-bold text-sky-900 mb-6">YouTube</h1>
                @php $yt = $studios->filter(fn($s) => $s->youtube_url); @endphp
                @if ($yt->isEmpty())
                <div class="bg-white border border-sky-100 rounded-xl p-8 text-center">
                    <svg class="w-12 h-12 text-red-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 24 24"><path d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z"/></svg>
                    <p class="text-sky-500">Belum ada konten YouTube.</p>
                </div>
                @else
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach ($yt as $s)
                    <div class="bg-white border border-sky-100 rounded-xl overflow-hidden">
                        <div class="aspect-video"><iframe src="{{ $s->youtube_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe></div>
                        <div class="p-4"><h3 class="font-semibold text-gray-900">{{ $s->name }}</h3></div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Tab: Live Streaming --}}
            <div id="gallery-live" class="tab-content-galeri hidden">
                <h1 class="text-3xl font-bold text-sky-900 mb-6">Live Streaming</h1>
                @php $lv = $studios->filter(fn($s) => $s->stream_url); @endphp
                @if ($lv->isEmpty())
                <div class="bg-white border border-sky-100 rounded-xl p-8 text-center">
                    <svg class="w-12 h-12 text-sky-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75a.75.75 0 00-.75.75v9c0 .414.336.75.75.75h15a.75.75 0 00.75-.75v-9a.75.75 0 00-.75-.75h-15z"/></svg>
                    <p class="text-sky-500">Belum ada live streaming.</p>
                </div>
                @else
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach ($lv as $s)
                    <div class="bg-white border border-sky-100 rounded-xl p-5">
                        <div class="flex items-center gap-3 mb-3"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span><h3 class="font-semibold text-gray-900">{{ $s->name }}</h3></div>
                        <audio controls class="w-full" preload="none"><source src="{{ $s->stream_url }}" type="audio/mpeg"></audio>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Right: Category Sidebar --}}
        <div class="md:w-1/4 order-1 md:order-2">
            <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Kategori</h3>
                <div class="space-y-2">
                    <button onclick="galeriTab('foto')" class="tab-galeri flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-sky-800 text-white" data-tab="foto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                        Foto
                    </button>
                    <button onclick="galeriTab('podcast')" class="tab-galeri flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-white text-sky-700 border border-sky-200" data-tab="podcast">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z"/></svg>
                        Podcast
                    </button>
                    <button onclick="galeriTab('youtube')" class="tab-galeri flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-white text-sky-700 border border-sky-200" data-tab="youtube">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z"/></svg>
                        YouTube
                    </button>
                    <button onclick="galeriTab('live')" class="tab-galeri flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-white text-sky-700 border border-sky-200" data-tab="live">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75a.75.75 0 00-.75.75v9c0 .414.336.75.75.75h15a.75.75 0 00.75-.75v-9a.75.75 0 00-.75-.75h-15z"/></svg>
                        Live Streaming
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

    <div id="toast" class="fixed top-4 right-4 z-[100] hidden max-w-sm w-full shadow-lg rounded-lg px-4 py-3 text-sm font-medium"></div>

    <div id="upload-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-sky-900">Upload Foto</h3>
                <button onclick="closeModal('upload-modal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <form id="upload-form" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" id="upload-title" required maxlength="255"
                           class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                    <textarea id="upload-desc" rows="2" maxlength="1000"
                              class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Album</label>
                    <select id="upload-album" class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                        <option value="">Tanpa Album</option>
                    </select>
                    <input type="text" id="upload-album-new" placeholder="atau ketik nama album baru..." 
                           class="w-full px-3 py-2 mt-1 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Foto</label>
                    <input type="file" id="upload-file" accept="image/jpeg,image/png,image/webp" required
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                    <p class="text-xs text-gray-400 mt-1">Maksimal 100MB. JPEG, PNG, WebP.</p>
                </div>
                <div id="upload-progress-area" class="hidden space-y-1">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span id="progress-label">Mengupload...</span>
                        <span id="progress-pct">0%</span>
                    </div>
                    <div class="w-full bg-sky-100 rounded-full h-2 overflow-hidden">
                        <div id="progress-bar" class="bg-sky-600 h-2 rounded-full transition-all duration-300" style="width:0%"></div>
                    </div>
                </div>
                <button type="submit" id="upload-btn" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-2.5 rounded-lg font-semibold text-sm transition flex items-center justify-center gap-2">
                    <span id="upload-btn-text">Upload & Proses</span>
                    <svg id="upload-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div id="unsplash-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-sky-900">Import dari Unsplash</h3>
                <button onclick="closeModal('unsplash-modal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <form id="unsplash-form" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" id="unsplash-title" required maxlength="255"
                           class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                    <textarea id="unsplash-desc" rows="2" maxlength="1000"
                              class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Foto Unsplash</label>
                    <input type="url" id="unsplash-url" required placeholder="https://unsplash.com/photos/xxx"
                           class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                    <p class="text-xs text-gray-400 mt-1">Tempel link foto dari unsplash.com/photos/...</p>
                </div>
                <div id="unsplash-progress-area" class="hidden space-y-1">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Mengunduh & memproses...</span>
                        <span id="unsplash-progress-text">loading</span>
                    </div>
                    <div class="w-full bg-sky-100 rounded-full h-2 overflow-hidden">
                        <div id="unsplash-progress-bar" class="bg-sky-600 h-2 rounded-full" style="width:50%"></div>
                    </div>
                </div>
                <button type="submit" id="unsplash-btn" class="w-full bg-white border-2 border-sky-600 text-sky-700 hover:bg-sky-50 py-2.5 rounded-lg font-semibold text-sm transition flex items-center justify-center gap-2">
                    <span id="unsplash-btn-text">Import & Proses</span>
                    <svg id="unsplash-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div id="edit-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-sky-900">Edit Foto</h3>
                <button onclick="closeModal('edit-modal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <form id="edit-form" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" id="edit-title" required maxlength="255"
                           class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                    <textarea id="edit-desc" rows="2" maxlength="1000"
                              class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-2.5 rounded-lg font-semibold text-sm transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <div id="delete-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl text-center" onclick="event.stopPropagation()">
            <div class="text-4xl mb-3">🗑️</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Foto?</h3>
            <p class="text-sm text-gray-500 mb-6">Foto akan dihapus permanen. Yakin?</p>
            <input type="hidden" id="delete-id">
            <div class="flex gap-3">
                <button onclick="closeModal('delete-modal')" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-lg font-semibold text-sm transition">Batal</button>
                <button id="delete-confirm-btn" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg font-semibold text-sm transition">Hapus</button>
            </div>
        </div>
    </div>

    <div id="viewer" class="fixed inset-0 z-50 bg-black/90 hidden items-center justify-center p-4" onclick="closeViewer(event)">
        <button class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10" onclick="closeViewer()">&times;</button>
        <div class="max-w-4xl max-h-[90vh]" onclick="event.stopPropagation()">
            <img id="viewer-img" class="max-w-full max-h-[80vh] mx-auto rounded-lg" src="">
            <div class="text-center mt-4">
                <p id="viewer-title" class="text-lg font-medium text-white"></p>
                <p id="viewer-desc" class="text-sm text-gray-400"></p>
            </div>
        </div>
    </div>

    <script>
    function showToast(message, type) {
        var t = document.getElementById('toast');
        t.textContent = message;
        t.className = 'fixed top-4 right-4 z-[100] max-w-sm w-full shadow-lg rounded-lg px-4 py-3 text-sm font-medium transition-all duration-300 ';
        t.classList.add(type === 'success' ? 'bg-green-600' : 'bg-red-600', 'text-white');
        t.classList.remove('hidden');
        t.style.opacity = '1';
        t.style.transform = 'translateY(0)';
        setTimeout(function() { t.style.opacity = '0'; t.style.transform = 'translateY(-10px)'; setTimeout(function() { t.classList.add('hidden'); }, 300); }, 4000);
    }

    function renderCard(item, isAuth) {
        var desc = item.description ? '<p class="text-white/80 text-xs mt-0.5 line-clamp-1">' + item.description + '</p>' : '';
        var actions = isAuth
            ? '<div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">'
            + '<button onclick="event.stopPropagation(); editItem(' + item.id + ', \'' + item.title.replace(/'/g, "\\'") + '\', \'' + (item.description || '').replace(/'/g, "\\'") + '\')" class="bg-white/90 hover:bg-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow">'
            + '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>'
            + '</button>'
            + '<button onclick="event.stopPropagation(); deleteItem(' + item.id + ')" class="bg-white/90 hover:bg-red-500 hover:text-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow">'
            + '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>'
            + '</button></div>'
            : '';
        return '<div class="gallery-card relative bg-white rounded-xl overflow-hidden shadow-sm border border-sky-100 hover:shadow-md transition group" data-id="' + item.id + '">'
            + '<div class="aspect-square min-h-[200px] bg-sky-100 overflow-hidden cursor-pointer" onclick="openViewer(\'' + item.image_url + '\', \'' + item.title.replace(/'/g, "\\'") + '\', \'' + (item.description || '').replace(/'/g, "\\'") + '\')">'
            + '<img src="' + item.thumbnail_url + '" alt="' + item.title + '" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">'
            + '</div>'
            + '<div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-3 pt-8">'
            + '<p class="text-white font-semibold text-sm leading-tight truncate">' + item.title + '</p>'
            + desc
            + '</div>'
            + actions
            + '</div>';
    }

    var isAuth = {{ auth()->check() ? 'true' : 'false' }};

    document.getElementById('upload-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var file = document.getElementById('upload-file').files[0];
        if (!file) return;

        var btn = document.getElementById('upload-btn');
        var btnText = document.getElementById('upload-btn-text');
        var spinner = document.getElementById('upload-spinner');
        var progressArea = document.getElementById('upload-progress-area');
        var progressBar = document.getElementById('progress-bar');
        var progressPct = document.getElementById('progress-pct');
        var progressLabel = document.getElementById('progress-label');

        btn.disabled = true;
        btnText.textContent = 'Mengupload...';
        spinner.classList.remove('hidden');
        progressArea.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressPct.textContent = '0%';
        progressLabel.textContent = 'Mengupload...';

        var formData = new FormData();
        formData.append('_token', document.querySelector('[name=_token]').value);
        formData.append('title', document.getElementById('upload-title').value);
        formData.append('description', document.getElementById('upload-desc').value);
        var album = document.getElementById('upload-album-new').value || document.getElementById('upload-album').value;
        formData.append('album', album);
        formData.append('image', file);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("galeri.upload") }}');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var pct = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = pct + '%';
                progressPct.textContent = pct + '%';
                if (pct < 100) progressLabel.textContent = 'Mengupload... ' + formatSize(e.loaded) + ' / ' + formatSize(e.total);
            }
        };

        xhr.onload = function() {
            progressLabel.textContent = 'Memproses gambar...';
            progressBar.style.width = '100%';
            progressPct.textContent = '100%';
            try {
                var res = JSON.parse(xhr.responseText);
                if (xhr.status >= 200 && xhr.status < 300 && res.success) {
                    closeModal('upload-modal');
                    addCard(res.item);
                    showToast(res.success, 'success');
                    resetUploadForm();
                } else {
                    showToast(res.error || 'Upload gagal (status ' + xhr.status + ')', 'error');
                    resetUploadButton();
                }
            } catch(e) {
                var msg = 'Gagal membaca respons server';
                if (xhr.status === 419) msg = 'Sesi habis. Silakan refresh halaman.';
                else if (xhr.status === 401) msg = 'Harus login terlebih dahulu.';
                else if (xhr.status === 422) msg = 'Data tidak valid. Periksa input.';
                showToast(msg, 'error');
                resetUploadButton();
            }
        };
        xhr.onerror = function() { showToast('Koneksi gagal. Coba lagi.', 'error'); resetUploadButton(); };
        xhr.send(formData);
    });

    function resetUploadForm() {
        document.getElementById('upload-title').value = '';
        document.getElementById('upload-desc').value = '';
        document.getElementById('upload-file').value = '';
        resetUploadButton();
        document.getElementById('upload-progress-area').classList.add('hidden');
    }

    function resetUploadButton() {
        var btn = document.getElementById('upload-btn');
        btn.disabled = false;
        document.getElementById('upload-btn-text').textContent = 'Upload & Proses';
        document.getElementById('upload-spinner').classList.add('hidden');
    }

    document.getElementById('unsplash-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('unsplash-btn');
        var btnText = document.getElementById('unsplash-btn-text');
        var spinner = document.getElementById('unsplash-spinner');
        var progressArea = document.getElementById('unsplash-progress-area');
        var progressText = document.getElementById('unsplash-progress-text');
        var progressBar = document.getElementById('unsplash-progress-bar');

        btn.disabled = true;
        btnText.textContent = 'Mengunduh...';
        spinner.classList.remove('hidden');
        progressArea.classList.remove('hidden');
        progressBar.style.width = '30%';
        progressText.textContent = 'mengunduh...';

        fetch('{{ route("galeri.unsplash") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('[name=_token]').value },
            body: JSON.stringify({ title: document.getElementById('unsplash-title').value, description: document.getElementById('unsplash-desc').value, unsplash_url: document.getElementById('unsplash-url').value })
        })
        .then(function(r) { progressBar.style.width = '70%'; progressText.textContent = 'memproses...'; return r.json(); })
        .then(function(res) {
            progressBar.style.width = '100%'; progressText.textContent = 'selesai';
            if (res.success) { closeModal('unsplash-modal'); addCard(res.item); showToast(res.success, 'success'); resetUnsplashForm(); }
            else { showToast(res.error || 'Import gagal', 'error'); resetUnsplashButton(); }
        })
        .catch(function() { showToast('Koneksi gagal. Coba lagi.', 'error'); resetUnsplashButton(); });
    });

    function resetUnsplashForm() {
        document.getElementById('unsplash-title').value = '';
        document.getElementById('unsplash-desc').value = '';
        document.getElementById('unsplash-url').value = '';
        resetUnsplashButton();
        document.getElementById('unsplash-progress-area').classList.add('hidden');
    }

    function resetUnsplashButton() {
        var btn = document.getElementById('unsplash-btn');
        btn.disabled = false;
        document.getElementById('unsplash-btn-text').textContent = 'Import & Proses';
        document.getElementById('unsplash-spinner').classList.add('hidden');
    }

    function editItem(id, title, desc) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-desc').value = desc;
        openModal('edit-modal');
    }

    document.getElementById('edit-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var id = document.getElementById('edit-id').value;
        fetch('/galeri/' + id, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('[name=_token]').value },
            body: JSON.stringify({ title: document.getElementById('edit-title').value, description: document.getElementById('edit-desc').value })
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success) { closeModal('edit-modal'); updateCard(res.item); showToast(res.success, 'success'); }
            else { showToast(res.error || 'Gagal', 'error'); }
        })
        .catch(function() { showToast('Koneksi gagal', 'error'); });
    });

    function updateCard(item) {
        var card = document.querySelector('.gallery-card[data-id="' + item.id + '"]');
        if (card) {
            var newCard = document.createElement('div');
            newCard.innerHTML = renderCard(item, isAuth);
            card.outerHTML = newCard.firstElementChild.outerHTML;
        }
    }

    function deleteItem(id) {
        document.getElementById('delete-id').value = id;
        openModal('delete-modal');
    }

    document.getElementById('delete-confirm-btn').addEventListener('click', function() {
        var id = document.getElementById('delete-id').value;
        fetch('/galeri/' + id, {
            method: 'DELETE',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('[name=_token]').value }
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success) {
                closeModal('delete-modal');
                var card = document.querySelector('.gallery-card[data-id="' + id + '"]');
                if (card) card.remove();
                showToast(res.success, 'success');
                if (document.querySelectorAll('.gallery-card').length === 0) {
                    document.getElementById('gallery-grid').innerHTML = '<p id="empty-msg" class="text-center text-sky-400 py-12 col-span-full">Belum ada foto di galeri</p>';
                }
            } else { showToast(res.error || 'Gagal', 'error'); }
        })
        .catch(function() { showToast('Koneksi gagal', 'error'); });
    });

    function addCard(item) {
        var grid = document.getElementById('gallery-grid');
        var empty = document.getElementById('empty-msg');
        if (empty) empty.remove();
        grid.insertAdjacentHTML('afterbegin', renderCard(item, isAuth));
    }

    function formatSize(bytes) {
        if (bytes < 1024) return bytes + 'B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + 'KB';
        return (bytes / 1048576).toFixed(1) + 'MB';
    }

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
        document.body.style.overflow = '';
    }
    function openViewer(src, title, desc) {
        document.getElementById('viewer-img').src = src;
        document.getElementById('viewer-title').textContent = title;
        document.getElementById('viewer-desc').textContent = desc;
        openModal('viewer');
    }
    function closeViewer(e) {
        if (e && e.target !== e.currentTarget) return;
        document.getElementById('viewer').classList.add('hidden');
        document.getElementById('viewer').classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeViewer(); closeModal('upload-modal'); closeModal('unsplash-modal'); closeModal('edit-modal'); closeModal('delete-modal'); }
    });
    document.querySelectorAll('#upload-modal, #unsplash-modal, #edit-modal, #delete-modal').forEach(function(m) {
        m.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
    });

    // Load albums
    fetch('/api/galeri/albums')
        .then(function(r) { return r.json(); })
        .then(function(albums) {
            var sel = document.getElementById('upload-album');
            if (sel) {
                sel.innerHTML = '<option value="">Tanpa Album</option>';
                albums.forEach(function(a) {
                    if (a.album) sel.innerHTML += '<option value="' + a.album + '">' + a.album + '</option>';
                });
            }
            var container = document.getElementById('album-container');
            if (container) {
                container.innerHTML = '';
                albums.forEach(function(a) {
                    if (a.album) container.innerHTML += '<button onclick="filterAlbum(\'' + a.album + '\')" class="tab-album flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold bg-white text-sky-700 border border-sky-200 hover:bg-sky-100 transition text-left w-full">📁 ' + a.album + ' (' + a.count + ')</button>';
                });
                if (albums.length > 0) {
                    container.innerHTML += '<button onclick="filterAlbum(\'\')" class="tab-album flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-xs font-semibold bg-sky-50 text-sky-500 hover:bg-sky-100 transition text-left w-full mt-1">× Hapus Filter</button>';
                }
            }
        })
        .catch(function() {});

    function filterAlbum(name) {
        document.querySelectorAll('.gallery-card').forEach(function(card) {
            var cardAlbum = card.dataset.album || '';
            card.style.display = !name || cardAlbum === name ? '' : 'none';
        });
    }
    </script>

    @include('partials.player')
</body>
</html>

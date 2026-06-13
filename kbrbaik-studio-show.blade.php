<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $studio->name }} - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">

    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <span class="text-xl font-bold tracking-tight">{{ $station?->name ?? 'KBRBaik' }}</span>
            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
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

    <section class="relative overflow-hidden bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(255,255,255,0.08),transparent_60%)]"></div>
        <div class="absolute top-1/4 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-20">
            <a href="{{ route('komunitas.show', $community->slug) }}" class="inline-flex items-center gap-1 text-sm text-white/70 hover:text-white transition mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                {{ $community->name }}
            </a>
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <div class="w-20 h-20 rounded-xl bg-white/10 backdrop-blur flex items-center justify-center shrink-0 border-2 border-white/20 overflow-hidden">
                    <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="w-full h-full object-contain p-2">
                </div>
                <div class="flex-1">
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-white/70">Studio</span>
                    <h1 class="text-3xl md:text-4xl font-bold mt-1">{{ $studio->name }}</h1>
                    @if ($studio->description)
                    <p class="text-sm text-sky-100 mt-2 max-w-2xl">{{ $studio->description }}</p>
                    @endif
                    <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-sky-200">
                        @if ($studio->location)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            {{ $studio->location }}
                        </span>
                        @endif
                        <span>{{ $episodes->count() }} episode</span>
                    </div>
                </div>
                <div class="shrink-0 flex flex-wrap gap-2">
                    @if ($studio->stream_url)
                    <a href="{{ $studio->stream_url }}" target="_blank" class="inline-flex items-center gap-1.5 bg-green-500/20 hover:bg-green-500/30 text-white px-4 py-2 rounded-lg font-semibold text-xs transition backdrop-blur">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.5 6.75a.75.75 0 00-.75.75v9c0 .414.336.75.75.75h15a.75.75 0 00.75-.75v-9a.75.75 0 00-.75-.75h-15z"/></svg>
                        Live
                    </a>
                    @endif
                    @if ($studio->youtube_url)
                    <a href="{{ $studio->youtube_url }}" target="_blank" class="inline-flex items-center gap-1.5 bg-red-500/20 hover:bg-red-500/30 text-white px-4 py-2 rounded-lg font-semibold text-xs transition backdrop-blur">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z"/></svg>
                        YouTube
                    </a>
                    @endif
                    @if ($studio->spotify_url)
                    <a href="{{ $studio->spotify_url }}" target="_blank" class="inline-flex items-center gap-1.5 bg-green-600/20 hover:bg-green-600/30 text-white px-4 py-2 rounded-lg font-semibold text-xs transition backdrop-blur">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                        Spotify
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-8 md:py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Left: Content Area --}}
                <div class="md:w-3/4 order-2 md:order-1">
                    {{-- Narasi --}}
                    <div id="content-narasi" class="tab-content">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-sky-900">Narasi</h2>
                            <button onclick="toggleForm('narasi')" class="text-sm font-semibold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                Tulis Narasi
                            </button>
                        </div>

                        <div id="form-narasi" class="hidden bg-white border border-sky-200 rounded-xl p-6 mb-6">
                            <h3 class="text-sm font-bold text-sky-800 mb-4">Tulis Narasi Baru</h3>
                            <div class="space-y-4">
                                <input type="text" id="narasi-title" placeholder="Judul narasi..." class="w-full px-4 py-2.5 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                                <textarea id="narasi-body" rows="6" placeholder="Tulis narasi di sini...&#10;&#10;Bisa pakai format Markdown." class="w-full px-4 py-2.5 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none font-mono"></textarea>
                                <input type="text" id="narasi-author" placeholder="Nama kamu" class="w-full px-4 py-2.5 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                                <button onclick="submitNarasi(this)" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">Kirim Narasi</button>
                                <span id="msg-narasi" class="text-sm text-green-600 hidden"></span>
                            </div>
                        </div>

                        <div class="space-y-4">
                        @php $studioPosts = \App\Models\Post::where('studio_id', $studio->id)->latest()->get(); @endphp
                        @forelse ($studioPosts as $post)
                        <div class="bg-white border border-sky-100 rounded-xl p-5 hover:shadow-md transition">
                            <h3 class="font-semibold text-gray-900">{{ $post->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($post->body), 200) }}</p>
                            <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                                <span>{{ $post->author }}</span>
                                <span>{{ ($post->published_at ?? $post->created_at)->format('d M Y') }}</span>
                                @if (!$post->is_published)
                                <span class="text-amber-500 font-semibold">Draft</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="bg-white border border-sky-100 rounded-xl p-8 text-center">
                            <svg class="w-12 h-12 text-sky-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/></svg>
                            <p class="text-sky-500">Belum ada narasi.</p>
                        </div>
                        @endforelse
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div id="content-foto" class="tab-content hidden">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-sky-900">Foto</h2>
                            <button onclick="toggleForm('foto')" class="text-sm font-semibold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                Upload Foto
                            </button>
                        </div>

                        <div id="form-foto" class="hidden bg-white border border-sky-200 rounded-xl p-6 mb-6">
                            <h3 class="text-sm font-bold text-sky-800 mb-4">Upload Foto Baru</h3>
                            <div class="space-y-4">
                                <input type="text" id="foto-title" placeholder="Judul foto..." class="w-full px-4 py-2.5 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                                <textarea id="foto-deskripsi" rows="2" placeholder="Deskripsi (opsional)..." class="w-full px-4 py-2.5 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none"></textarea>
                                <input type="file" id="foto-file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                                <div id="progress-foto" class="hidden w-full bg-sky-100 rounded-full h-2.5">
                                    <div id="progress-foto-bar" class="bg-sky-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <div id="preview-foto" class="hidden"><img id="preview-foto-img" class="w-full h-48 object-cover rounded-lg"></div>
                                <button onclick="submitFoto(this)" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">Upload</button>
                                <span id="msg-foto" class="text-sm text-green-600 hidden"></span>
                            </div>
                        </div>

                        @if ($galleries->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 text-sky-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                            <p class="text-sky-500">Belum ada foto.</p>
                        </div>
                        @else
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($galleries as $item)
                            <div class="rounded-xl overflow-hidden border border-sky-100 shadow-sm hover:shadow-md transition group">
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- Podcast/Spotify --}}
                    <div id="content-podcast" class="tab-content hidden">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-sky-900">Podcast / Spotify</h2>
                            <div class="flex gap-2">
                                <button onclick="toggleForm('podcast-add')" class="text-sm font-semibold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Episode
                                </button>
                                <button onclick="toggleForm('podcast-rss')" class="text-sm font-semibold text-sky-600 hover:text-sky-800 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0115 0m-12 0a4.5 4.5 0 019 0m-6 0a1.5 1.5 0 113 0 1.5 1 5 0 01-3 0z"/></svg>
                                    Import RSS
                                </button>
                            </div>
                        </div>

                        {{-- Tambah Episode --}}
                        <div id="form-podcast-add" class="hidden bg-white border border-sky-200 rounded-xl p-6 mb-6">
                            <h3 class="text-sm font-bold text-sky-800 mb-4">Tambah Episode</h3>
                            <div class="space-y-4">
                                <input type="text" id="podcast-title" placeholder="Judul episode..." class="w-full px-4 py-2.5 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                                <input type="file" id="podcast-file" accept="audio/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                                <p class="text-xs text-gray-400">Atau masukkan URL audio:</p>
                                <input type="url" id="podcast-url" placeholder="https://..." class="w-full px-4 py-2.5 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                                <button onclick="submitPodcast(this)" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">Simpan Episode</button>
                                <span id="msg-podcast" class="text-sm text-green-600 hidden"></span>
                            </div>
                        </div>

                        {{-- Import RSS --}}
                        <div id="form-podcast-rss" class="hidden bg-white border border-sky-200 rounded-xl p-6 mb-6">
                            <h3 class="text-sm font-bold text-sky-800 mb-4">Import dari RSS</h3>
                            <div class="space-y-4">
                                <input type="url" id="rss-url" placeholder="https://feed.example.com/podcast.xml" class="w-full px-4 py-2.5 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                                <button onclick="importRss(this)" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0115 0m-12 0a4.5 4.5 0 019 0m-6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"/></svg>
                                    Import RSS
                                </button>
                                <span id="msg-rss" class="text-sm text-green-600 hidden"></span>
                            </div>
                        </div>

                        @if ($studio->spotify_url)
                        <div class="mb-6">
                            <iframe src="https://open.spotify.com/embed/show/{{ $studio->spotify_url }}" width="100%" height="232" frameborder="0" allowtransparency="true" allow="encrypted-media" class="rounded-xl"></iframe>
                        </div>
                        @endif

                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Episode</h3>
                        @if ($episodes->isEmpty())
                        <div class="bg-white border border-sky-100 rounded-xl p-8 text-center">
                            <svg class="w-12 h-12 text-sky-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                            <p class="text-sky-500">Belum ada episode.</p>
                            <p class="text-xs text-gray-400 mt-2">Tambahkan episode atau import via RSS di menu admin.</p>
                        </div>
                        @else
                        <div class="space-y-4">
                            @foreach ($episodes as $episode)
                            <div class="bg-white border border-sky-100 rounded-xl p-5 hover:shadow-md transition flex items-start gap-4">
                                @if ($episode->thumbnail)
                                <img src="{{ asset('storage/' . $episode->thumbnail) }}" alt="{{ $episode->title }}" class="w-16 h-16 rounded-lg object-cover shrink-0">
                                @else
                                <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center shrink-0">
                                    <svg class="w-7 h-7 text-sky-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900">{{ $episode->title }}</h4>
                                    @if ($episode->description)
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $episode->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                                        @if ($episode->duration)
                                        <span>{{ gmdate('i:s', $episode->duration) }}</span>
                                        @endif
                                        @if ($episode->published_at)
                                        <span>{{ $episode->published_at->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                                @if ($episode->audio_file)
                                @php $audioUrl = str_starts_with($episode->audio_file, 'http') ? $episode->audio_file : asset('storage/' . $episode->audio_file); @endphp
                                <button onclick="playEpisode('{{ $audioUrl }}', '{{ addslashes($episode->title) }}')" class="w-10 h-10 rounded-full bg-sky-600 hover:bg-sky-700 text-white flex items-center justify-center shrink-0 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </button>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- YouTube --}}
                    <div id="content-youtube" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-sky-900 mb-6">YouTube</h2>
                        @if ($studio->youtube_url)
                        <div class="aspect-video rounded-xl overflow-hidden shadow-lg border border-sky-100">
                            <iframe src="{{ $studio->youtube_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                        </div>
                        @else
                        <div class="bg-white border border-sky-100 rounded-xl p-8 text-center">
                            <svg class="w-12 h-12 text-red-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 24 24"><path d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z"/></svg>
                            <p class="text-sky-500">Belum ada konten YouTube.</p>
                        </div>
                        @endif
                    </div>

                    {{-- Live Streaming --}}
                    <div id="content-live" class="tab-content hidden">
                        <h2 class="text-2xl font-bold text-sky-900 mb-6">Live Streaming</h2>
                        @if ($studio->stream_url)
                        <div class="bg-white border border-sky-100 rounded-xl overflow-hidden">
                            <audio controls class="w-full p-4" preload="none">
                                <source src="{{ $studio->stream_url }}" type="audio/mpeg">
                            </audio>
                            <div class="px-4 pb-4 text-center">
                                <span class="inline-flex items-center gap-1.5 text-xs text-green-600 font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    LIVE
                                </span>
                                <p class="text-xs text-gray-400 mt-1">Streaming langsung dari {{ $studio->name }}</p>
                            </div>
                        </div>
                        @else
                        <div class="bg-white border border-sky-100 rounded-xl p-8 text-center">
                            <svg class="w-12 h-12 text-sky-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75a.75.75 0 00-.75.75v9c0 .414.336.75.75.75h15a.75.75 0 00.75-.75v-9a.75.75 0 00-.75-.75h-15z"/></svg>
                            <p class="text-sky-500">Belum ada live streaming.</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Right: Category Tabs --}}
                <div class="md:w-1/4 order-1 md:order-2">
                    <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                        <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Kegiatan</h3>
                        <div class="space-y-2">
                            <button onclick="switchStudioTab('narasi')" class="tab-studio flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-left bg-sky-800 text-white" data-tab="narasi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/></svg>
                                Narasi
                            </button>
                            <button onclick="switchStudioTab('foto')" class="tab-studio flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-left bg-white text-sky-700 border border-sky-200" data-tab="foto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                                Foto
                            </button>
                            <button onclick="switchStudioTab('podcast')" class="tab-studio flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-left bg-white text-sky-700 border border-sky-200" data-tab="podcast">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z"/></svg>
                                Podcast / Spotify
                            </button>
                            <button onclick="switchStudioTab('youtube')" class="tab-studio flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-left bg-white text-sky-700 border border-sky-200" data-tab="youtube">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z"/></svg>
                                YouTube
                            </button>
                            <button onclick="switchStudioTab('live')" class="tab-studio flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-left bg-white text-sky-700 border border-sky-200" data-tab="live">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75a.75.75 0 00-.75.75v9c0 .414.336.75.75.75h15a.75.75 0 00.75-.75v-9a.75.75 0 00-.75-.75h-15z"/></svg>
                                Live Streaming
                            </button>
                        </div>
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
    function switchStudioTab(tab) {
        localStorage.setItem('studio-tab', tab);
        document.querySelectorAll('.tab-content').forEach(function(el) {
            el.classList.add('hidden');
        });
        var target = document.getElementById('content-' + tab);
        if (target) target.classList.remove('hidden');

        document.querySelectorAll('.tab-studio').forEach(function(btn) {
            var isActive = btn.dataset.tab === tab;
            btn.classList.toggle('bg-sky-800', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('text-sky-700', !isActive);
            btn.classList.toggle('bg-white', !isActive);
            btn.classList.toggle('border', !isActive);
            btn.classList.toggle('border-sky-200', !isActive);
            btn.classList.toggle('border-0', isActive);
        });
    }

    // Restore last active tab
    var savedTab = localStorage.getItem('studio-tab');
    if (savedTab && savedTab !== 'narasi') {
        switchStudioTab(savedTab);
    }

    function toggleForm(type) {
        var form = document.getElementById('form-' + type);
        form.classList.toggle('hidden');
    }

    function submitNarasi(btn) {
        btn.disabled = true;
        btn.textContent = 'Mengirim...';

        var formData = new FormData();
        formData.append('type', 'narasi');
        formData.append('studio_id', '{{ $studio->id }}');
        formData.append('title', document.getElementById('narasi-title').value);
        formData.append('body', document.getElementById('narasi-body').value);
        formData.append('author', document.getElementById('narasi-author').value || 'Kontributor');

        fetch('/studio/submit', {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
        })
        .then(function(r) { return r.json(); })
        .then(function(json) {
            btn.disabled = false;
            btn.textContent = 'Kirim Narasi';
            if (json.success) {
                document.getElementById('msg-narasi').textContent = 'Narasi terkirim!';
                document.getElementById('msg-narasi').classList.remove('hidden');
                document.getElementById('narasi-title').value = '';
                document.getElementById('narasi-body').value = '';
                setTimeout(function() { location.reload(); }, 1500);
            } else {
                alert('Gagal: ' + (json.message || 'Coba lagi'));
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.textContent = 'Kirim Narasi';
            alert('Gagal mengirim.');
        });
    }

    document.getElementById('foto-file')?.addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('preview-foto-img').src = ev.target.result;
                document.getElementById('preview-foto').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    function submitFoto(btn) {
        btn.disabled = true;
        btn.textContent = 'Mengupload...';
        document.getElementById('progress-foto').classList.remove('hidden');
        document.getElementById('progress-foto-bar').style.width = '0%';

        var formData = new FormData();
        formData.append('type', 'foto');
        formData.append('studio_id', '{{ $studio->id }}');
        formData.append('title', document.getElementById('foto-title').value);
        formData.append('description', document.getElementById('foto-deskripsi').value);
        formData.append('image', document.getElementById('foto-file').files[0]);

        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                var pct = Math.round((e.loaded / e.total) * 100);
                document.getElementById('progress-foto-bar').style.width = pct + '%';
            }
        });
        xhr.addEventListener('load', function() {
            btn.disabled = false;
            btn.textContent = 'Upload';
            if (xhr.status === 200) {
                var json = JSON.parse(xhr.responseText);
                if (json.success) {
                    document.getElementById('msg-foto').textContent = 'Foto terupload!';
                    document.getElementById('msg-foto').classList.remove('hidden');
                    document.getElementById('foto-title').value = '';
                    document.getElementById('foto-deskripsi').value = '';
                    document.getElementById('foto-file').value = '';
                    document.getElementById('preview-foto').classList.add('hidden');
                    localStorage.setItem('studio-tab', 'foto');
                    setTimeout(function() { location.reload(); }, 800);
                } else {
                    alert('Gagal: ' + (json.message || 'Coba lagi'));
                }
            } else {
                alert('Gagal mengupload (status ' + xhr.status + ').');
            }
            document.getElementById('progress-foto').classList.add('hidden');
        });
        xhr.addEventListener('error', function() {
            btn.disabled = false;
            btn.textContent = 'Upload';
            alert('Gagal mengupload.');
            document.getElementById('progress-foto').classList.add('hidden');
        });
        xhr.open('POST', '/api/studio/submit');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.send(formData);
    }

    function submitPodcast(btn) {
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';
        var formData = new FormData();
        formData.append('type', 'podcast');
        formData.append('studio_id', '{{ $studio->id }}');
        formData.append('title', document.getElementById('podcast-title').value);
        var audioFile = document.getElementById('podcast-file').files[0];
        if (audioFile) formData.append('audio', audioFile);
        formData.append('url', document.getElementById('podcast-url').value);
        fetch('/api/studio/submit', {
            method: 'POST', body: formData,
            headers: { 'Accept': 'application/json' }
        }).then(function(r) { return r.json(); }).then(function(json) {
            btn.disabled = false; btn.textContent = 'Simpan Episode';
            if (json.success) {
                document.getElementById('msg-podcast').textContent = 'Episode ditambahkan!';
                document.getElementById('msg-podcast').classList.remove('hidden');
                document.getElementById('podcast-title').value = '';
                document.getElementById('podcast-file').value = '';
                document.getElementById('podcast-url').value = '';
                setTimeout(function() { location.reload(); }, 1000);
            } else { alert('Gagal: ' + (json.message || '')); }
        }).catch(function() { btn.disabled = false; btn.textContent = 'Simpan Episode'; alert('Gagal.'); });
    }

    function importRss(btn) {
        btn.disabled = true; btn.textContent = 'Mengimpor...';
        var formData = new FormData();
        formData.append('rss_url', document.getElementById('rss-url').value);
        formData.append('studio_id', '{{ $studio->id }}');
        fetch('/api/studio/import-rss', {
            method: 'POST', body: formData,
            headers: { 'Accept': 'application/json' }
        }).then(function(r) { return r.json(); }).then(function(json) {
            btn.disabled = false; btn.textContent = 'Import RSS';
            if (json.success) {
                document.getElementById('msg-rss').textContent = json.message;
                document.getElementById('msg-rss').classList.remove('hidden');
                setTimeout(function() { location.reload(); }, 1500);
            } else { alert('Gagal: ' + (json.message || '')); }
        }).catch(function() { btn.disabled = false; btn.textContent = 'Import RSS'; alert('Gagal.'); });
    }
    </script>
</body>
</html>
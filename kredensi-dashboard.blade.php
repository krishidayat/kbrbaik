<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kredensi - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight">Kredensi Studio</span>
            </a>
            <div class="flex items-center gap-4 text-sm">
                <span class="text-sky-200">{{ auth()->user()->name }}</span>
                <a href="{{ route('kredensi.tulis') }}" class="hover:text-sky-200 transition">Tulis Narasi</a>
                <form method="POST" action="{{ route('kredensi.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-sky-200 transition">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-8">
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-bold text-sky-900">Dashboard</h1>
                <span class="text-xs font-semibold px-3 py-1 rounded-full 
                    @if(auth()->user()->role === 'administrator') bg-red-100 text-red-600
                    @elseif(auth()->user()->role === 'pengelola') bg-sky-100 text-sky-600
                    @elseif(auth()->user()->role === 'manajer') bg-amber-100 text-amber-600
                    @elseif(auth()->user()->role === 'anggota') bg-green-100 text-green-600
                    @else bg-gray-100 text-gray-500 @endif">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
            <p class="text-sky-600 mt-1">Selamat datang, {{ auth()->user()->name }}
                @if(auth()->user()->studio) · Studio {{ auth()->user()->studio->name }} @endif
            </p>
        </div>

        @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm mb-6">{{ session('success') }}</div>
        @endif

        {{-- Tulis Narasi --}}
        <div class="bg-white rounded-xl border border-sky-200 overflow-hidden shadow-sm">
            <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4">
                <h2 class="text-lg font-bold">Tulis Narasi Baru</h2>
            </div>
            <form method="POST" action="{{ route('kredensi.post.store') }}" class="p-6 space-y-5" enctype="multipart/form-data">
                @csrf
                <div class="grid md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul *</label>
                        <input type="text" name="title" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Studio</label>
                        <select name="studio_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            <option value="">Pilih studio</option>
                            @foreach ($studios as $s)
                            <option value="{{ $s->id }}" {{ auth()->user()->studio_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Lead (pembuka)</label>
                        <textarea name="lead" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Utama</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                        <p class="text-xs text-gray-400 mt-1">Format: JPG/PNG. Maks 5MB</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Narasi *</label>
                        <p class="text-xs text-gray-400 mb-2">Format Markdown. Gunakan **tebal**, *miring*, # heading</p>
                        <textarea name="body" rows="10" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-sky-500 outline-none"></textarea>
                    </div>
                </div>
                <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-2.5 rounded-lg font-semibold text-sm transition">Publikasikan Narasi</button>
            </form>
        </div>

        {{-- Riwayat Narasi --}}
        @if ($posts->count() > 0)
        <div class="mt-8">
            <h2 class="text-lg font-bold text-sky-900 mb-4">Riwayat Narasi</h2>
            <div class="space-y-3">
                @foreach ($posts as $post)
                <div class="bg-white rounded-xl border border-sky-100 p-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm">{{ $post->title }}</h3>
                        <p class="text-xs text-gray-400">{{ $post->created_at->format('d M Y') }} @if($post->category) · {{ $post->category->name }} @endif</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($post->is_published)
                        <span class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded">Published</span>
                        @else
                        <span class="text-xs bg-amber-50 text-amber-600 px-2 py-1 rounded">Draft</span>
                        @endif
                        <a href="{{ route('post', $post->slug) }}" class="text-xs text-sky-600 hover:underline">Lihat</a>
                        <a href="{{ url('/admin/posts/' . $post->id . '/edit') }}" class="text-xs text-amber-600 hover:underline">Edit</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</body>
</html>

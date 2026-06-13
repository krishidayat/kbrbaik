<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - {{ $station?->name ?? 'Radio Kabar Baik' }}</title>
    <meta name="description" content="{{ Str::limit($post->excerpt ?? strip_tags($post->body), 160) }}">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ Str::limit($post->excerpt ?? strip_tags($post->body), 160) }}">
    @if ($post->featured_image)
    <meta property="og:image" content="{{ asset('storage/' . $post->featured_image) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight">Radio KbrBaik</span>
            </a>
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
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        @if ($post->featured_image && $post->type !== 'video')
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 md:h-96 object-cover rounded-xl mb-6">
        @endif

        <div class="text-sm text-sky-600 mb-2">
            {{ $post->category?->name }} &middot; {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}
            @if ($post->type === 'podcast')
                &middot; <span class="text-sky-500">Podcast</span>
            @elseif ($post->type === 'video')
                &middot; <span class="text-sky-500">Video</span>
            @endif
        </div>

        <h1 class="text-3xl md:text-4xl font-bold mb-4 text-sky-900">{{ $post->title }}</h1>

        @if ($post->author)
        <p class="text-sky-500 mb-6">Oleh {{ $post->author }}</p>
        @endif

        @if ($post->type === 'video' && $post->video_url)
        <div class="mb-8 aspect-video rounded-xl overflow-hidden shadow-lg">
            <iframe src="{{ $post->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
        </div>
        @endif

        @if ($post->type === 'podcast' && $post->audio_url)
        <div class="mb-8 bg-white rounded-xl shadow-sm border border-sky-100 p-6">
            <audio controls class="w-full">
                <source src="{{ $post->audio_url }}" type="audio/mpeg">
            </audio>
        </div>
        @endif

        @if ($post->lead)
        <div class="text-lg md:text-xl text-gray-700 leading-relaxed font-medium border-l-4 border-sky-400 pl-5 mb-10 italic">
            {{ $post->lead }}
        </div>
        @endif

        <div class="prose prose-lg max-w-none leading-relaxed mb-10">
            @if (($post->body_format ?? 'markdown') === 'html')
                {!! $post->body !!}
            @else
                {!! Str::of($post->body)->markdown() !!}
            @endif
        </div>

        @if ($post->quote)
        <div class="bg-sky-50 border border-sky-100 rounded-xl p-6 md:p-8 text-center mb-10">
            <svg class="w-8 h-8 text-sky-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            <p class="text-lg md:text-xl text-gray-700 italic font-medium leading-relaxed">"{{ $post->quote }}"</p>
        </div>
        @endif

        @if ($post->resume)
        <div class="bg-gradient-to-r from-sky-50 to-white border border-sky-100 rounded-xl p-6">
            <div class="prose prose-sm max-w-none text-gray-600">
                {!! nl2br(e($post->resume)) !!}
            </div>
        </div>
        @endif

        @if ($post->source_url)
        <div class="mt-8 p-4 bg-sky-100 rounded-lg text-sm text-sky-700">
            Sumber: <a href="{{ $post->source_url }}" target="_blank" rel="noopener" class="text-blue-600 hover:underline">{{ $post->source_url }}</a>
        </div>
        @endif

        <a href="{{ route('kbrbaik.blog') }}" class="inline-block mt-8 text-sm font-semibold text-sky-600 hover:text-sky-800 transition">&larr; Kembali ke Blog</a>
    </div>

    <footer class="bg-sky-800 text-sky-200 py-8 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $station?->name ?? 'Radio Kabar Baik' }}. All rights reserved.</p>
        </div>
    </footer>
    @include('partials.player')
</body>
</html>

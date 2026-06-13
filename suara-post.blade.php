@extends('layouts.suara')

@section('title', $post->title . ' - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@push('head')
<meta name="description" content="{{ Str::limit($post->excerpt ?? strip_tags($post->body), 160) }}">
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ Str::limit($post->excerpt ?? strip_tags($post->body), 160) }}">
@if ($post->featured_image)
<meta property="og:image" content="{{ asset('storage/' . $post->featured_image) }}">
@endif
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <nav class="mb-6 text-sm text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-primary-600 transition">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('posts') }}" class="hover:text-primary-600 transition">Artikel</a>
        <span class="mx-2">/</span>
        @if ($post->category)
        <a href="{{ route('category', $post->category->slug) }}" class="hover:text-primary-600 transition">{{ $post->category->name }}</a>
        <span class="mx-2">/</span>
        @endif
        <span class="text-gray-600">{{ $post->title }}</span>
    </nav>

    <article class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
        @if ($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 md:h-96 object-cover">
        @endif

        <div class="p-6 md:p-10">
            <div class="flex items-center gap-3 mb-4">
                @if ($post->category)
                <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-3 py-1.5 rounded">{{ $post->category->name }}</span>
                @endif
                <span class="text-sm text-gray-400">{{ $post->published_at?->format('d F Y') ?? $post->created_at->format('d F Y') }}</span>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $post->title }}</h1>

            @if ($post->excerpt)
            <p class="text-lg text-gray-500 mb-6 leading-relaxed">{{ $post->excerpt }}</p>
            @endif

            <div class="prose max-w-none">
                {!! Str::markdown($post->body) !!}
        @if ($post->source_url)
        <div class="mt-6 pt-4 border-t border-gray-100">
            <p class="text-sm text-gray-500">
                Sumber: <a href="{{ $post->source_url }}" target="_blank" rel="noopener noreferrer" class="text-primary-600 hover:text-primary-700 underline">{{ $post->source_url }}</a>
            </p>
        </div>
        @endif
            </div>
        </div>
    </article>

    {{-- ARTIKEL TERKAIT --}}
    @php $related = $station?->posts()->where('is_published', true)->where('id', '!=', $post->id)->latest()->take(6)->get() @endphp
    @if ($related?->count())
    <section class="mt-12">
        <h3 class="text-2xl font-bold mb-6">Artikel Lainnya</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach ($related as $relatedPost)
            <a href="{{ route('post', $relatedPost->slug) }}" class="block bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition group aspect-square">
                <div class="w-full h-full relative">
                    @if ($relatedPost->featured_image)
                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" loading="lazy">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center text-3xl">📰</div>
                    @endif
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection

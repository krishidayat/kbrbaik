@extends('layouts.suara')

@section('title', 'Gereja - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Gereja</h1>
            <p class="text-gray-500 mt-1">Gereja Anggota PGIW Jawa Barat</p>
        </div>
        <a href="{{ route('struktur.gereja') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Struktur &amp; Personalia
        </a>
    </div>

    <form method="GET" action="{{ route('gereja') }}" class="mb-8">
        <select name="category" onchange="this.form.submit()" class="w-full sm:w-72 px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-sm text-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <option value="">Semua Gereja</option>
            @foreach ($categories as $cat)
            <option value="{{ $cat->slug }}" {{ ($selectedCategory && $selectedCategory->slug === $cat->slug) ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @forelse ($posts as $post)
        <article class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition">
            @if ($post->featured_image)
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-28 object-cover">
            @else
            <div class="w-full h-28 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            @endif
            <div class="p-3">
                @if ($post->category)
                <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-1 rounded">{{ $post->category->name }}</span>
                @endif
                <h4 class="font-semibold text-sm mt-1 mb-1">
                    <a href="{{ route('post', $post->slug) }}" class="hover:text-primary-600 transition">{{ $post->title }}</a>
                </h4>
                <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit($post->excerpt ?? strip_tags($post->body), 80) }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</p>
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-400 text-lg">Belum ada artikel</p>
        </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
    <div class="mt-8">
        {{ $posts->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
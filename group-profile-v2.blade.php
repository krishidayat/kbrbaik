@extends('layouts.suara')

@section('title', $item->name . ' - ' . ($station?->name ?? 'PGIW Jabar'))

@section('content')
@php
$photos = \App\Models\GalleryItem::where('album', $item->group . '-' . $item->slug)
    ->where('is_active', true)->latest()->take(6)->get();
@endphp

<div class="relative overflow-hidden bg-gradient-to-br from-primary-500 to-primary-700 text-white">
    <div class="max-w-6xl mx-auto px-4 py-12 md:py-16">
        <a href="{{ url('/' . $item->group) }}" class="inline-flex items-center gap-1 text-sm text-white/70 hover:text-white transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke {{ strtoupper($item->group) }}
        </a>
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold">{{ $item->name }}</h1>
                <p class="text-white/80 mt-2 max-w-xl">{{ strtoupper($item->group) }} — {{ $station?->name ?? 'PGIW Jabar' }}</p>
            </div>
            @auth
            <a href="{{ url('/admin/categories/' . $item->id . '/edit') }}" class="shrink-0 bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm font-semibold transition inline-flex items-center gap-1.5 backdrop-blur-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Profil
            </a>
            @endauth
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
    {{-- Struktur --}}
    <section class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-4">
            <h2 class="text-xl font-bold">🏛️ Kepengurusan</h2>
        </div>
        <div class="p-6">
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-primary-50 border border-primary-200 rounded-xl p-5 text-center">
                    <div class="w-14 h-14 rounded-full bg-primary-600 text-white flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Ketua</h3>
                    <p class="text-sm text-gray-500 mt-1">—</p>
                </div>
                <div class="bg-primary-50 border border-primary-200 rounded-xl p-5 text-center">
                    <div class="w-14 h-14 rounded-full bg-primary-600 text-white flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Sekretaris</h3>
                    <p class="text-sm text-gray-500 mt-1">—</p>
                </div>
                <div class="bg-primary-50 border border-primary-200 rounded-xl p-5 text-center">
                    <div class="w-14 h-14 rounded-full bg-primary-600 text-white flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Bendahara</h3>
                    <p class="text-sm text-gray-500 mt-1">—</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Galeri Foto --}}
    <section class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold">📸 Galeri Foto</h2>
                <p class="text-sm text-white/70 mt-0.5">Dokumentasi {{ $item->name }}</p>
            </div>
            <a href="{{ route('galeri') }}?album={{ $item->group }}-{{ $item->slug }}" class="text-sm text-white/70 hover:text-white transition">Lihat Semua →</a>
        </div>
        <div class="p-6">
            @if ($photos->isEmpty())
            <div class="text-center py-8 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                <p class="text-sm mt-2">Belum ada foto. Upload foto di galeri dengan album <strong>{{ $item->group }}-{{ $item->slug }}</strong></p>
            </div>
            @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($photos as $p)
                <a href="{{ asset('storage/' . $p->image_path) }}" target="_blank" class="block aspect-[4/3] rounded-xl overflow-hidden bg-gray-100 hover:opacity-90 transition group">
                    <img src="{{ asset('storage/' . ($p->thumbnail_path ?? $p->image_path)) }}" alt="{{ $p->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    {{-- Artikel Terkait --}}
    @if ($posts->count())
    <section class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-4">
            <h2 class="text-xl font-bold">📄 Artikel</h2>
            <p class="text-sm text-white/70 mt-0.5">Kegiatan dan berita {{ $item->name }}</p>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach ($posts as $post)
            <a href="{{ route('post', $post->slug) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition group">
                @if ($post->featured_image)
                <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-sm text-gray-900 group-hover:text-primary-700 transition">{{ $post->title }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-primary-500 transition shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection

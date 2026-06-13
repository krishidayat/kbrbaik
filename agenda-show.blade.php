@extends('layouts.suara')

@section('title', $event->title . ' - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('agenda') }}" class="text-sm text-primary-600 hover:text-primary-700 inline-flex items-center gap-1">&larr; Kembali ke Agenda</a>
        @auth
        <a href="{{ url('/admin/agenda/' . $event->id . '/edit') }}" class="text-sm bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
        @endauth
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if ($event->featured_image)
        <img src="{{ asset('storage/' . $event->featured_image) }}" alt="{{ $event->title }}" class="w-full h-64 md:h-80 object-cover">
        @endif
        <div class="p-6 md:p-8">
            <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-3 py-1 rounded">{{ ucfirst($event->type) }}</span>
            <h1 class="text-2xl md:text-3xl font-bold mt-3 mb-4">{{ $event->title }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $event->event_date->locale('id')->isoFormat('dddd, D MMMM YYYY') }} @if ($event->event_time) {{ $event->event_time->format('H:i') }} WIB @endif</span>
                </div>
                @if ($event->end_date)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Sampai {{ $event->end_date->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
                @endif
                @if ($event->location)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $event->location }}</span>
                </div>
                @endif
                @if ($event->organizer)
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $event->organizer }}</span>
                </div>
                @endif
            </div>

            @if ($event->description)
            <div class="prose prose-sm max-w-none text-gray-700 mb-8">
                {!! nl2br(e($event->description)) !!}
            </div>
            @endif
        </div>
    </div>

    {{-- Gallery Photos --}}
    @if ($event->galleryItems->count())
    <section class="mt-10">
        <h2 class="text-xl font-bold mb-6">Dokumentasi Kegiatan</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="gallery-grid">
            @foreach ($event->galleryItems as $item)
            <a href="{{ asset('storage/' . $item->image_path) }}" target="_blank"
               class="block aspect-square rounded-xl overflow-hidden bg-gray-100 hover:opacity-90 transition">
                <img src="{{ asset('storage/' . ($item->thumbnail_path ?? $item->image_path)) }}"
                     alt="{{ $item->title ?? 'Foto' }}"
                     class="w-full h-full object-cover">
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Report --}}
    @if ($event->report_content || $event->report_file)
    <section class="mt-10 bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h2 class="text-xl font-bold mb-4">Laporan Kegiatan</h2>
        @if ($event->report_content)
        <div class="prose prose-sm max-w-none text-gray-700">
            {!! $event->report_content !!}
        </div>
        @endif
        @if ($event->report_file)
        <a href="{{ asset('storage/' . $event->report_file) }}" target="_blank"
           class="inline-flex items-center gap-2 mt-4 text-primary-600 hover:text-primary-700 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Download Laporan (PDF)
        </a>
        @endif
    </section>
    @endif
</div>
@endsection

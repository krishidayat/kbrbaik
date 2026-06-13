@extends('layouts.suara')

@section('title', 'Agenda Tahunan ' . $year . ' - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Agenda Tahunan {{ $year }}</h1>
            <p class="text-gray-500 mt-1">Program kerja PGIW Jabar per bulan</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('agenda') }}" class="p-2 text-gray-400 hover:text-primary-600 transition rounded-lg hover:bg-primary-50" title="Lihat Agenda">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </a>
            <a href="{{ route('agenda.kalender') }}" class="p-2 text-gray-400 hover:text-primary-600 transition rounded-lg hover:bg-primary-50" title="Kalender">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </a>
        </div>
    </div>

    @php
    $bulan = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
              'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];
    @endphp

    <div class="space-y-6">
        @forelse ($events as $month => $monthEvents)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-5 py-3 flex items-center justify-between">
                <h2 class="font-bold text-lg">{{ $bulan[$month] ?? $month }} {{ $year }}</h2>
                <span class="text-xs bg-white/20 px-3 py-1 rounded-full">{{ $monthEvents->count() }} kegiatan</span>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach ($monthEvents as $event)
                <a href="/agenda/{{ $event->slug }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition group">
                    <div class="flex flex-col items-center w-12 shrink-0">
                        <span class="text-xs font-bold text-primary-600">{{ $event->event_date->format('d') }}</span>
                        <span class="text-[10px] text-gray-400">{{ $event->event_date->format('M') }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm text-gray-900 group-hover:text-primary-700 transition">{{ $event->title }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs {{ $event->type === 'Siaran' ? 'text-red-500' : 'text-primary-500' }} font-medium">{{ $event->type }}</span>
                            @if ($event->organizer)
                            <span class="text-xs text-gray-400">• {{ $event->organizer }}</span>
                            @endif
                        </div>
                    </div>
                    @if ($event->location && $event->location !== '-')
                    <span class="text-xs text-gray-400 hidden md:block">{{ $event->location }}</span>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-16 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p>Belum ada agenda untuk tahun {{ $year }}.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

@extends('layouts.suara')

@section('title', 'Kalender Agenda - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Kalender Agenda</h1>
            <p class="text-gray-500 mt-1">{{ $station?->name ?? 'PGIW Jabar' }}</p>
        </div>
        <a href="{{ route('agenda') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
            &larr; Kembali ke List
        </a>
    </div>

    @php
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $monthName = $months[(int)$month - 1];
        $daysInMonth = \Carbon\Carbon::create($year, $month, 1)->daysInMonth;
        $firstDayOfWeek = \Carbon\Carbon::create($year, $month, 1)->dayOfWeek; // 0=Sun, 6=Sat
        $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        $prevMonth = (int)$month - 1 < 1 ? 12 : (int)$month - 1;
        $prevYear = (int)$month - 1 < 1 ? (int)$year - 1 : (int)$year;
        $nextMonth = (int)$month + 1 > 12 ? 1 : (int)$month + 1;
        $nextYear = (int)$month + 1 > 12 ? (int)$year + 1 : (int)$year;

        $eventsByDay = [];
        foreach ($events as $e) {
            $d = (int)$e->event_date->format('d');
            if (!isset($eventsByDay[$d])) $eventsByDay[$d] = [];
            $eventsByDay[$d][] = $e;
        }
    @endphp

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between bg-primary-600 text-white px-6 py-4">
            <a href="{{ route('agenda.kalender', ['year' => $prevYear, 'month' => $prevMonth]) }}" class="hover:text-primary-200 transition p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold">{{ $monthName }} {{ $year }}</h2>
            <a href="{{ route('agenda.kalender', ['year' => $nextYear, 'month' => $nextMonth]) }}" class="hover:text-primary-200 transition p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-7">
            @foreach ($dayNames as $name)
            <div class="text-center text-xs font-semibold text-gray-500 uppercase py-3 bg-gray-50 border-b border-gray-100">{{ $name }}</div>
            @endforeach

            @for ($i = 0; $i < $firstDayOfWeek; $i++)
            <div class="min-h-24 bg-gray-50/50 p-2 border-b border-r border-gray-100"></div>
            @endfor

            @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $today = $day === (int)date('j') && (int)$month === (int)date('m') && (int)$year === (int)date('Y');
                $dayEvents = $eventsByDay[$day] ?? [];
            @endphp
            <div class="min-h-24 p-1.5 border-b border-r border-gray-100 {{ $today ? 'bg-primary-50' : 'bg-white' }}">
                <span class="text-xs font-semibold {{ $today ? 'bg-primary-600 text-white w-6 h-6 flex items-center justify-center rounded-full' : 'text-gray-700' }}">{{ $day }}</span>
                <div class="mt-1 space-y-1">
                    @foreach ($dayEvents as $event)
                    <a href="{{ route('agenda.show', $event->slug) }}" class="block text-xs px-1.5 py-0.5 rounded truncate bg-primary-100 text-primary-700 hover:bg-primary-200 transition">
                        {{ $event->title }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection

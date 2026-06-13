@extends('pojok.layout')

@section('title', 'Rundown Siaran')
@section('page_title', '📋 Rundown Siaran')

@section('content')
<div class="mb-4">
    <p class="text-sm text-gray-500">{{ $now->translatedFormat('l, d F Y H:i') }} WIB</p>
</div>

<div class="space-y-4">
    @php
    $colors = ['subuh' => 'indigo', 'pagi' => 'amber', 'siang' => 'orange', 'sore' => 'purple', 'malam' => 'blue'];
    $times = ['subuh' => '03:00-06:00', 'pagi' => '06:00-11:00', 'siang' => '11:00-15:00', 'sore' => '15:00-18:00', 'malam' => '18:00-03:00'];
    @endphp

    @foreach ($playlists as $pl)
    @php
    $c = $colors[$pl->period] ?? 'gray';
    $isActive = $pl->period === $currentPeriod;
    $totalDur = 0;
    foreach ($pl->activeItems as $item) {
        if ($item->duration) $totalDur += $item->duration;
    }
    @endphp

    <div class="rounded-xl border-2 overflow-hidden transition {{ $isActive ? 'border-'.$c.'-400 shadow-md' : 'border-gray-200' }}">
        {{-- Header --}}
        <div class="px-5 py-3 flex items-center justify-between {{ $isActive ? 'bg-'.$c.'-50' : 'bg-gray-50' }}">
            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ $icons[$pl->period] ?? '🎵' }}</span>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-gray-900">{{ $pl->name }}</span>
                        @if ($isActive)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-100 text-green-700">SEKARANG</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400">{{ $times[$pl->period] ?? '' }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-gray-700">{{ $pl->activeItems->count() }} item</p>
                @if ($totalDur > 0)
                <p class="text-[10px] text-gray-400">{{ gmdate('H:i:s', $totalDur) }}</p>
                @endif
            </div>
        </div>

        {{-- Items --}}
        @if ($pl->activeItems->isEmpty())
        <div class="px-5 py-4 text-center text-sm text-gray-400">
            <p>Belum ada item</p>
            <a href="{{ route('pojok.playlist', $pl->period) }}" class="text-sky-600 hover:underline text-xs">Kelola playlist</a>
        </div>
        @else
        <div class="divide-y divide-gray-100">
            @foreach ($pl->activeItems as $i => $item)
            <div class="flex items-center gap-3 px-5 py-2.5 {{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50/50' }}">
                <span class="text-xs font-mono text-gray-400 w-6 shrink-0">{{ $i + 1 }}.</span>
                <span class="text-xs px-1.5 py-0.5 rounded font-mono shrink-0
                    @if($item->item_type === 'audio') bg-blue-50 text-blue-600
                    @elseif($item->item_type === 'webstream') bg-purple-50 text-purple-600
                    @else bg-green-50 text-green-600 @endif">
                    {{ $item->item_type }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item->title }}</p>
                    @if ($item->artist)
                    <p class="text-xs text-gray-400 truncate">{{ $item->artist }}</p>
                    @endif
                </div>
                @if ($item->duration_display)
                <span class="text-xs font-mono text-gray-400 shrink-0">{{ $item->duration_display }}</span>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Footer --}}
        <div class="px-5 py-2 {{ $isActive ? 'bg-'.$c.'-50/50' : 'bg-gray-50/50' }} text-right">
            <a href="{{ route('pojok.playlist', $pl->period) }}" class="text-xs text-sky-600 hover:underline">Kelola playlist {{ $pl->name }} →</a>
        </div>
    </div>
    @endforeach
</div>
@endsection

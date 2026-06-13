@extends('pojok.layout')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
@if (!auth()->check() || !$station)
<div class="max-w-md mx-auto mt-12 text-center">
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Terdaftar</h3>
    <p class="text-sm text-gray-400">Anda belum terdaftar di studio/komunitas mana pun.</p>
    <a href="{{ route('kredensi.tulis') }}" class="inline-block mt-4 bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
        Dashboard Utama
    </a>
</div>
@else
{{-- Station Info Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Stasiun</p>
        <p class="text-lg font-bold text-sky-900 mt-1">{{ $station->name }}</p>
        <p class="text-xs text-gray-400">{{ $station->description ?? '-' }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Studio</p>
        <p class="text-lg font-bold text-sky-900 mt-1">{{ $userStudio->name ?? auth()->user()->name }}</p>
        <p class="text-xs text-gray-400">{{ $userStudio->description ?? '' }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Stream</p>
        <a href="https://radio.kbrbaik.live{{ $station->stream_mount }}" target="_blank"
           class="text-sm font-bold text-sky-600 hover:underline mt-1 block truncate">
            radio.kbrbaik.live{{ $station->stream_mount }}
        </a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Status</p>
        @if ($nowPlaying['online'] ?? false)
        <p class="text-lg font-bold text-green-600 mt-1">Online</p>
        <p class="text-xs text-gray-400">{{ $nowPlaying['listeners'] ?? 0 }} pendengar</p>
        @else
        <p class="text-lg font-bold text-gray-400 mt-1">Offline</p>
        <p class="text-xs text-gray-400">Siaran belum aktif</p>
        @endif
    </div>
</div>

{{-- AutoDJ Toggle + Now Playing --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    {{-- AutoDJ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">AutoDJ</p>
                <div class="flex items-center gap-2 mt-1">
                    <span id="autodj-dot" class="w-3 h-3 rounded-full bg-gray-300 shrink-0"></span>
                    <span id="autodj-label" class="text-sm font-semibold text-gray-500">Memeriksa...</span>
                </div>
            </div>
            <button id="autodj-toggle"
                    class="relative w-14 h-7 rounded-full transition disabled:opacity-50"
                    onclick="toggleAutoDj()">
                <span class="absolute inset-0 rounded-full bg-gray-300 transition"></span>
                <span class="absolute top-0.5 left-0.5 w-6 h-6 rounded-full bg-white shadow transition transform"></span>
            </button>
        </div>
    </div>

    {{-- Now Playing --}}
    @if ($nowPlaying['online'] ?? false)
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-green-500 animate-pulse shrink-0"></span>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">{{ $nowPlaying['title'] }}</p>
                @if (!empty($nowPlaying['artist']))
                <p class="text-xs text-gray-400 truncate">{{ $nowPlaying['artist'] }}</p>
                @endif
            </div>
            <span class="text-xs text-gray-400 shrink-0">Peak: {{ $nowPlaying['listener_peak'] ?? 0 }}</span>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function checkAutoDj() {
        fetch('{{ route("pojok.autodj.status") }}')
            .then(function(r) { return r.json(); })
            .then(function(d) {
                var dot = document.getElementById('autodj-dot');
                var label = document.getElementById('autodj-label');
                var toggle = document.getElementById('autodj-toggle');
                var thumb = toggle.querySelector('span:last-child');
                var bg = toggle.querySelector('span:first-child');

                if (d.active) {
                    dot.className = 'w-3 h-3 rounded-full bg-green-500 shrink-0';
                    label.textContent = 'Menyala';
                    label.className = 'text-sm font-semibold text-green-700';
                    bg.className = 'absolute inset-0 rounded-full bg-green-500 transition';
                    thumb.className = 'absolute top-0.5 right-0.5 w-6 h-6 rounded-full bg-white shadow transition';
                } else {
                    dot.className = 'w-3 h-3 rounded-full bg-gray-300 shrink-0';
                    label.textContent = 'Mati';
                    label.className = 'text-sm font-semibold text-gray-500';
                    bg.className = 'absolute inset-0 rounded-full bg-gray-300 transition';
                    thumb.className = 'absolute top-0.5 left-0.5 w-6 h-6 rounded-full bg-white shadow transition';
                }
            });
    }

    function toggleAutoDj() {
        var btn = document.getElementById('autodj-toggle');
        btn.disabled = true;
        fetch('{{ route("pojok.autodj.toggle") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
        })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            checkAutoDj();
            btn.disabled = false;
        })
        .catch(function() { btn.disabled = false; });
    }

    checkAutoDj();
</script>
@endpush

{{-- 5 Playlist Cards --}}
<div class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-6">
    @php
    $pcolors = ['subuh' => 'indigo', 'pagi' => 'amber', 'siang' => 'orange', 'sore' => 'purple', 'malam' => 'blue'];
    $picons = ['subuh' => '🌅', 'pagi' => '☀️', 'siang' => '🌤️', 'sore' => '🌆', 'malam' => '🌙'];
    @endphp
    @foreach ($playlists as $pl)
    @php $c = $pcolors[$pl->period] ?? 'sky'; @endphp
    <a href="{{ route('pojok.playlist', $pl->period) }}"
       class="block bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md hover:border-{{ $c }}-300 transition">
        <div class="flex items-center gap-2 mb-2">
            <span class="text-xl">{{ $picons[$pl->period] ?? '🎵' }}</span>
            <span class="font-bold text-sm text-gray-800">{{ $pl->name }}</span>
        </div>
        <p class="text-2xl font-bold text-{{ $c }}-600">{{ $pl->active_items_count }}</p>
        <p class="text-xs text-gray-400">item aktif</p>
    </a>
    @endforeach
</div>

{{-- Quick Actions --}}
<div class="bg-white rounded-xl border border-gray-200 p-5">
    <h3 class="font-semibold text-gray-700 mb-4">Fitur</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <a href="{{ route('pojok.playlist', 'subuh') }}"
           class="bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg p-4 text-center transition">
            <p class="text-2xl">🎵</p>
            <p class="text-sm font-semibold text-sky-700 mt-2">Playlist</p>
            <p class="text-xs text-sky-500">Kelola 5 waktu</p>
        </a>
        <a href="{{ route('pojok.webcast') }}"
           class="bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg p-4 text-center transition">
            <p class="text-2xl">🔗</p>
            <p class="text-sm font-semibold text-sky-700 mt-2">Webcast</p>
            <p class="text-xs text-sky-500">Relay stream</p>
        </a>
        <a href="{{ route('pojok.liquidsoap') }}"
           class="bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg p-4 text-center transition">
            <p class="text-2xl">⚙️</p>
            <p class="text-sm font-semibold text-sky-700 mt-2">Auto-DJ</p>
            <p class="text-xs text-sky-500">Konfigurasi</p>
        </a>
        <a href="https://radio.kbrbaik.live{{ $station->stream_mount }}" target="_blank"
           class="bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg p-4 text-center transition">
            <p class="text-2xl">🔊</p>
            <p class="text-sm font-semibold text-sky-700 mt-2">Stream</p>
            <p class="text-xs text-sky-500">Dengar langsung</p>
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $totalItems }}</p>
            <p class="text-xs text-gray-500">Total Item</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $activeItems }}</p>
            <p class="text-xs text-gray-500">Item Aktif</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.41-.083.83-.128 1.25-.128h9.5c.42 0 .84.045 1.25.128m-12 0A2.25 2.25 0 004.5 9v.75m4.5-4.5v-1.5A1.5 1.5 0 0110.5 3h3a1.5 1.5 0 011.5 1.5v1.5"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $playlists->count() }}</p>
            <p class="text-xs text-gray-500">Playlist</p>
        </div>
    </div>
</div>
@endif
@endsection

@section('guest_content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center max-w-sm">
        <div class="text-5xl mb-4">📻</div>
        <h1 class="text-2xl font-bold text-sky-900 mb-2">Pojok KBRBaik</h1>
        <p class="text-sm text-gray-500 mb-6">Dashboard manajemen radio komunitas</p>
        <a href="{{ route('kredensi') }}"
           class="inline-block bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            Login / Daftar
        </a>
    </div>
</div>
@endsection

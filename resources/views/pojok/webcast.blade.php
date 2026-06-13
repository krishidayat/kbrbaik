@extends('pojok.layout')

@section('title', 'Webcast Relay')
@section('page_title', '🔗 Webcast Relay')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-sky-900">Webcast Relay</h2>
            <p class="text-xs text-gray-400">Daftar webstream dari stasiun radio lain</p>
        </div>
        @if ($webstreams->isEmpty())
        <div class="p-10 text-center">
            <div class="text-4xl mb-3">🔗</div>
            <p class="text-gray-400 text-sm">Belum ada webstream</p>
            <p class="text-xs text-gray-300 mt-1">Tambahkan dari halaman playlist</p>
        </div>
        @else
        <div class="divide-y divide-gray-100">
            @foreach ($webstreams as $ws)
            <div class="flex items-center gap-4 px-5 py-4">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m9.86-2.5a4.5 4.5 0 00-6.364-6.365l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 text-sm">{{ $ws->title }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $ws->webstream_url }}</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ $ws->webstream_url }}" target="_blank"
                       class="px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 text-xs font-semibold hover:bg-purple-100 transition">Buka</a>
                    <span class="text-xs font-mono text-gray-400">{{ $ws->playlist?->name }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    <div class="space-y-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-bold text-sm text-sky-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                Semua Stream Icecast
            </h3>
            <div id="icecast-streams" class="space-y-2"><p class="text-sm text-gray-400">Memuat...</p></div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-bold text-sm text-sky-900 mb-3">Cara Relay</h3>
            <div class="text-xs text-gray-500 space-y-2">
                <p>1. Tambahkan webstream URL di halaman playlist</p>
                <p>2. Webstream akan muncul di daftar ini</p>
                <p>3. Gunakan Liquidsoap untuk auto-relay</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    fetch('https://radio.kbrbaik.live/status-json.xsl')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var sources = data.icestats.source || [];
            var html = '';
            if (!Array.isArray(sources)) sources = [sources];
            sources.forEach(function(src) {
                var name = src.server_name || 'Unknown';
                var url = src.listenurl || '';
                var listeners = src.listeners || 0;
                var title = src.title || 'No track';
                var peak = src.listener_peak || 0;
                var dot = listeners > 0 ? 'bg-green-500' : 'bg-gray-300';
                html += '<div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50">';
                html += '<span class="w-2 h-2 rounded-full ' + dot + ' shrink-0"></span>';
                html += '<div class="flex-1 min-w-0"><p class="text-sm font-medium text-gray-900 truncate">' + name + '</p><p class="text-xs text-gray-400 truncate">' + title + '</p></div>';
                html += '<div class="text-right shrink-0"><p class="text-sm font-bold text-gray-700">' + listeners + '</p><p class="text-[10px] text-gray-400">peak ' + peak + '</p></div>';
                html += '<a href="' + url.replace('localhost', 'radio.kbrbaik.live') + '" target="_blank" class="text-xs text-purple-600 hover:underline shrink-0">Buka</a>';
                html += '</div>';
            });
            document.getElementById('icecast-streams').innerHTML = html;
        })
        .catch(function() {
            document.getElementById('icecast-streams').innerHTML = '<p class="text-sm text-red-400">Gagal memuat</p>';
        });
</script>
@endpush

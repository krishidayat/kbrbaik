@extends('pojok.layout')

@section('title', 'Liquidsoap Config')
@section('page_title', '⚙️ Liquidsoap Config')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="font-bold text-sky-900">Auto-DJ Configuration</h2>
            <p class="text-xs text-gray-400">Konfigurasi Liquidsoap untuk rotasi playlist</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pojok.liquidsoap.download') }}"
               class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold rounded-lg transition">Download .liq</a>
        </div>
    </div>
    <div class="p-5">
        @php
        $periods = ['subuh' => ['name' => 'Subuh', 'time' => '03:00-06:00', 'icon' => '🌅'],
                     'pagi' => ['name' => 'Pagi', 'time' => '06:00-11:00', 'icon' => '☀️'],
                     'siang' => ['name' => 'Siang', 'time' => '11:00-15:00', 'icon' => '🌤️'],
                     'sore' => ['name' => 'Sore', 'time' => '15:00-18:00', 'icon' => '🌆'],
                     'malam' => ['name' => 'Malam', 'time' => '18:00-03:00', 'icon' => '🌙']];
        $pcolors = ['subuh'=>'indigo','pagi'=>'amber','siang'=>'orange','sore'=>'purple','malam'=>'blue'];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-6">
            @foreach ($periods as $key => $p)
            @php $c = $pcolors[$key]; @endphp
            <div class="bg-{{ $c }}-50 rounded-xl border border-{{ $c }}-200 p-3 text-center">
                <span class="text-2xl">{{ $p['icon'] }}</span>
                <p class="font-bold text-sm text-{{ $c }}-800 mt-1">{{ $p['name'] }}</p>
                <p class="text-xs text-{{ $c }}-600">{{ $p['time'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-gray-900 rounded-xl p-5 overflow-x-auto">
            <pre class="text-emerald-300 text-xs font-mono leading-relaxed whitespace-pre-wrap" id="config-preview">Memuat...</pre>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    fetch('{{ route("pojok.liquidsoap.json") }}')
        .then(function(r) { return r.json(); })
        .then(function(data) { document.getElementById('config-preview').textContent = data.config; })
        .catch(function() { document.getElementById('config-preview').textContent = '# Gagal memuat'; });
</script>
@endpush

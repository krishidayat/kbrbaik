@extends('layouts.suara')

@section('title', 'Program Kerja - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
@php
$rows = \App\Models\RencanaKerja::where('is_active', true)->where('station_id', $station?->id ?? 2)->orderBy('bidang_no')->get();
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Program Kerja PGIW Jabar 2026</h1>
        <p class="text-gray-500 mt-1">Rencana program dan anggaran — Sidang MPL 13-14 Februari 2026</p>
    </div>

    <div class="mb-8">
        <div class="flex flex-wrap gap-1 border-b border-gray-200" id="bidang-tabs">
            <button class="px-4 py-2.5 text-sm font-semibold rounded-t-lg transition-all duration-200 active border-b-2 border-primary-600 text-primary-600" data-bidang="1" onclick="showBidang('1')">
                Umum & Organisasi
            </button>
            <button class="px-4 py-2.5 text-sm font-semibold rounded-t-lg transition-all duration-200 text-gray-500 hover:text-gray-700" data-bidang="2" onclick="showBidang('2')">
                Koinonia
            </button>
            <button class="px-4 py-2.5 text-sm font-semibold rounded-t-lg transition-all duration-200 text-gray-500 hover:text-gray-700" data-bidang="3" onclick="showBidang('3')">
                Marturia
            </button>
            <button class="px-4 py-2.5 text-sm font-semibold rounded-t-lg transition-all duration-200 text-gray-500 hover:text-gray-700" data-bidang="4" onclick="showBidang('4')">
                Diakonia
            </button>
            <button class="px-4 py-2.5 text-sm font-semibold rounded-t-lg transition-all duration-200 text-gray-500 hover:text-gray-700" data-bidang="5" onclick="showBidang('5')">
                Sarpras & Keuangan
            </button>
            <button class="px-4 py-2.5 text-sm font-semibold rounded-t-lg transition-all duration-200 text-gray-500 hover:text-gray-700" data-bidang="6" onclick="showBidang('6')">
                Kesekretariatan
            </button>
            <div class="ml-auto">
                <button class="px-4 py-2.5 text-sm font-semibold rounded-t-lg transition-all duration-200 text-gray-500 hover:text-gray-700 flex items-center gap-1.5" data-bidang="semua" onclick="showBidang('semua')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Semua
                </button>
            </div>
        </div>
    </div>

    <div id="bidang-content" class="space-y-6"></div>
</div>

<script>
var data = {!! json_encode($rows) !!};

function showBidang(id) {
    // Update tabs
    document.querySelectorAll('#bidang-tabs button').forEach(function(b) {
        b.classList.remove('active', 'border-b-2', 'border-primary-600', 'text-primary-600', 'font-bold');
        b.classList.add('text-gray-500');
        if (b.dataset.bidang === id) {
            b.classList.add('active', 'border-b-2', 'border-primary-600', 'text-primary-600', 'font-bold');
            b.classList.remove('text-gray-500');
        }
    });

    var container = document.getElementById('bidang-content');
    var items = id === 'semua' ? data : data.filter(function(d) { return d.bidang_no == id; });
    if (items.length === 0) { container.innerHTML = '<p class="text-gray-400">Belum ada data.</p>'; return; }

    var groups = {};
    items.forEach(function(d) {
        if (!groups[d.entitas]) groups[d.entitas] = [];
        groups[d.entitas].push(d);
    });

    var order = Object.keys(groups);
    order.sort(function(a, b) {
        if (a.indexOf('Bidang') !== -1 && b.indexOf('Bidang') === -1) return -1;
        if (a.indexOf('Bidang') === -1 && b.indexOf('Bidang') !== -1) return 1;
        return a.localeCompare(b);
    });

    var html = '';
    order.forEach(function(entitas) {
        var isBidang = entitas.indexOf('Bidang') !== -1;
        var label = isBidang || entitas.indexOf('Bidang') !== -1 ? 'PROGRAM BIDANG' : entitas.toUpperCase();
        var bg = isBidang ? 'bg-sky-700' : 'bg-sky-500';

        html += '<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">';
        html += '<div class="' + bg + ' text-white px-5 py-3"><span class="text-xs font-mono font-bold tracking-widest">' + label + '</span></div>';
        html += '<div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="bg-gray-50 border-b border-gray-200">';
        html += '<th class="px-4 py-2.5 text-left font-semibold text-gray-600 w-[25%]">PROGRAM / KEGIATAN</th>';
        html += '<th class="px-4 py-2.5 text-left font-semibold text-gray-600 w-[20%]">TUJUAN / SASARAN</th>';
        html += '<th class="px-4 py-2.5 text-left font-semibold text-gray-600 w-[30%]">WAKTU / TEMPAT / ANGGARAN</th>';
        html += '<th class="px-4 py-2.5 text-left font-semibold text-gray-600 w-[20%]">KETERANGAN</th></tr></thead><tbody>';

        groups[entitas].forEach(function(d) {
            var wt = '';
            if (d.waktu !== '-') wt += '<span class="block"><span class="font-semibold">Waktu:</span> ' + d.waktu + '</span>';
            if (d.tempat !== '-') wt += '<span class="block"><span class="font-semibold">Tempat:</span> ' + d.tempat + '</span>';
            if (d.anggaran !== '-') wt += '<span class="block"><span class="font-semibold">Anggaran:</span> ' + d.anggaran + '</span>';
            if (!wt) wt = '-';
            html += '<tr class="border-t border-gray-100 hover:bg-sky-50/50 transition">';
            html += '<td class="px-4 py-3 font-medium text-gray-900">' + d.program + '</td>';
            html += '<td class="px-4 py-3 text-gray-600">' + d.tujuan + '</td>';
            html += '<td class="px-4 py-3 text-gray-600 text-xs">' + wt + '</td>';
            html += '<td class="px-4 py-3 text-gray-500 text-xs">' + d.keterangan + '</td></tr>';
        });
        html += '</tbody></table></div></div>';
    });
    container.innerHTML = html;
}
</script>
<script>
showBidang('1');
</script>
@endsection

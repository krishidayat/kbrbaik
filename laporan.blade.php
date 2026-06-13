@extends('layouts.suara')

@section('title', 'Laporan - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Laporan & Evaluasi Program 2025</h1>
        <p class="text-gray-500 mt-1">Laporan kerja komisi dan desk PGIW Jabar yang disahkan Sidang MPL 2026</p>
    </div>

    @php
    $laporan = [
        ['bidang' => 'Litbang', 'icon' => '🔬', 'laporan' => ['FGD pemetaan masalah lintas komisi', 'Database anggota PGIW Jabar']],
        ['bidang' => 'Anak & Remaja', 'icon' => '🧒', 'laporan' => ['Roadshow Hak Anak', 'Konvensi Hak Anak']],
        ['bidang' => 'Pemuda', 'icon' => '🔥', 'laporan' => ['Youth Camp Batch 1 (30 dari 100 target)']],
        ['bidang' => 'Perempuan', 'icon' => '👩', 'laporan' => ['Training Konseling (21 dari 25 target = 84%)']],
        ['bidang' => 'Desk GRA', 'icon' => '🏠', 'laporan' => ['Sosialisasi Gereja Ramah Anak online + offline']],
        ['bidang' => 'Desk KBB', 'icon' => '🕊️', 'laporan' => ['Seminar Moderasi Beragama']],
        ['bidang' => 'Lingkungan Hidup & Bencana', 'icon' => '🌿', 'laporan' => ['Pelatihan pengelolaan sampah Karawang', 'Sosialisasi edukasi lingkungan']],
        ['bidang' => 'Pendidikan', 'icon' => '📚', 'laporan' => ['Kunjungan ke Pembimas Kristen Jabar']],
        ['bidang' => 'Desk PEJ', 'icon' => '💼', 'laporan' => ['Survei potensi ekonomi jemaat via gform']],
        ['bidang' => 'Media & Informasi', 'icon' => '📱', 'laporan' => ['Inventarisir akun medsos PGIW Jabar']],
        ['bidang' => 'Hukum & HAM', 'icon' => '⚖️', 'laporan' => ['Penyuluhan via Radio Maestro', 'Seminar Hukum Online']],
    ];
    @endphp

    <div class="space-y-4">
        @foreach ($laporan as $l)
        <details class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm group open:shadow-md transition">
            <summary class="px-5 py-4 bg-gradient-to-r from-sky-600 to-sky-700 text-white cursor-pointer list-none flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xl">{{ $l['icon'] }}</span>
                    <h3 class="font-bold">{{ $l['bidang'] }}</h3>
                </div>
                <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </summary>
            <div class="p-5 space-y-2">
                @foreach ($l['laporan'] as $item)
                <div class="flex items-start gap-2 text-sm text-gray-700">
                    <svg class="w-4 h-4 text-sky-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </details>
        @endforeach
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="font-bold text-lg mb-2">Laporan Keuangan 2025</h3>
        <p class="text-sm text-gray-600">Saldo Awal (1 Januari 2025): <strong class="text-gray-900">Rp 551.966.223</strong></p>
        <p class="text-xs text-gray-400 mt-2">Laporan keuangan tahunan 1 Jan - 31 Des 2025 disahkan dalam Sidang MPL 2026.</p>
    </div>
</div>
@endsection

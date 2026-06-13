@extends('layouts.suara')

@section('title', 'Kategori Kegiatan - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Kategori Kegiatan</h1>
        <p class="text-gray-500 mt-1">5 jenis kegiatan utama — ekstraksi dari Program Kerja PGIW Jabar 2026</p>
    </div>

    @php
    $kategori = [
        (object)[
            'no' => 1, 'nama' => 'Sosialisasi & Edukasi',
            'icon' => '📢', 'warna' => 'from-sky-500 to-sky-600',
            'deskripsi' => 'Seminar, kampanye, FGD, sosialisasi',
            'program' => [
                'Sosialisasi Profiling Data Jemaat (Litbang)',
                'Kampanye 16 Hari Anti Kekerasan (Anak & Remaja)',
                'Seminar Moderasi Beragama (Marturia)',
                'Sosialisasi Gereja Ramah Anak (Desk GRA)',
                'Edukasi Lingkungan (LH & Bencana)',
            ]
        ],
        (object)[
            'no' => 2, 'nama' => 'Pelatihan & Pengembangan',
            'icon' => '🎓', 'warna' => 'from-indigo-500 to-indigo-600',
            'deskripsi' => 'Training, workshop, camp, bimbingan',
            'program' => [
                'Youth Leadership Camp Batch 2 (Pemuda)',
                'Pelatihan Konselor Tahap 2 & 3 (Perempuan)',
                'Pelatihan Penanganan Intoleransi (Desk KBB)',
                'Festival Seni & Olahraga (Pemuda)',
                'Penyuluhan Hukum (Hukum & HAM)',
            ]
        ],
        (object)[
            'no' => 3, 'nama' => 'Rapat & Sidang',
            'icon' => '📋', 'warna' => 'from-amber-500 to-amber-600',
            'deskripsi' => 'Koordinasi, sidang, pertemuan, FGD',
            'program' => [
                'FGD Pemetaan Masalah Lintas Komisi (Litbang)',
                'Bina Oikoumene (Koinonia)',
                'Pertukaran Pelayanan HUT PGI (Koinonia)',
                'Koordinasi Program Diakonia (Diakonia)',
                'Pengelolaan Administrasi (Kesekretariatan)',
            ]
        ],
        (object)[
            'no' => 4, 'nama' => 'Pelayanan & Pendampingan',
            'icon' => '🤝', 'warna' => 'from-emerald-500 to-emerald-600',
            'deskripsi' => 'Bantuan hukum, konseling, diakonia',
            'program' => [
                'Pendampingan Hukum Gereja (Hukum & HAM)',
                'Pendampingan Izin Rumah Ibadah (Hukum & HAM)',
                'Program Diakonia Berkelanjutan (Diakonia)',
                'Pemberdayaan Ekonomi Jemaat (Desk PEJ)',
                'Pengumpulan Data Anggota (Litbang)',
            ]
        ],
        (object)[
            'no' => 5, 'nama' => 'Media & Informasi',
            'icon' => '📡', 'warna' => 'from-purple-500 to-purple-600',
            'deskripsi' => 'Publikasi, medsos, dokumentasi',
            'program' => [
                'Penguatan Media Sosial (Media & Informasi)',
                'Inventarisir Akun Medsos (Media & Informasi)',
                'Sosialisasi via Link & Barcode (Litbang)',
                'Bulan PRB Nasional 2026 — Publikasi (LH)',
                'Data Guru & Siswa Kristen (Pendidikan)',
            ]
        ],
    ];
    @endphp

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($kategori as $k)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition group">
            <div class="bg-gradient-to-r {{ $k->warna }} text-white px-5 py-4 flex items-center gap-3">
                <span class="text-2xl">{{ $k->icon }}</span>
                <div>
                    <span class="text-xs font-mono font-bold tracking-widest opacity-80">KATEGORI {{ $k->no }}</span>
                    <h3 class="font-bold text-lg">{{ $k->nama }}</h3>
                </div>
            </div>
            <div class="p-5">
                <p class="text-xs text-gray-500 mb-3">{{ $k->deskripsi }}</p>
                <ul class="space-y-2">
                    @foreach ($k->program as $p)
                    <li class="flex items-start gap-2 text-sm text-gray-700">
                        <svg class="w-4 h-4 text-{{ explode('-', explode('from-', $k->warna)[1])[0] }}-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $p }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8 bg-amber-50 border border-amber-200 rounded-xl p-5">
        <h3 class="font-bold text-sm text-amber-800 mb-2">📌 Rencana Penggunaan</h3>
        <p class="text-sm text-amber-700">5 kategori ini akan digunakan sebagai <strong>filter agenda/kegiatan</strong> di halaman agenda PGIW Jabar. Setiap kegiatan yang dimasukkan akan dikategorikan ke salah satu dari 5 jenis ini.</p>
    </div>
</div>
@endsection

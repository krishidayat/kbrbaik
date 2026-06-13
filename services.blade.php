@extends('layouts.suara')
@section('title', 'Layanan - ' . ($station->name ?? 'KbrBaik'))
@section('content')
<div class="min-h-screen bg-sky-50">
    <div class="relative overflow-hidden bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(255,255,255,0.08),transparent_60%)]"></div>
        <div class="absolute top-1/4 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-20">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-[10px] font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white">
                    Platform AI Otonom v1.2
                </span>
                <span class="text-[10px] font-mono px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white/80">
                    #AktivitasKbrBaik
                </span>
            </div>

            <h1 class="text-3xl md:text-5xl font-display font-extrabold tracking-tight leading-[1.1] text-white">
                Aktivitas <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-sky-200">Kabar Baik</span>
            </h1>
            <p class="text-sm md:text-base text-white/80 leading-relaxed max-w-2xl mt-3">
                Empat area pencapaian besar yang menaungi seluruh aktivitas KbrBaik.live
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-6 pb-12 -mt-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-sky-200 rounded-xl p-5 hover:border-sky-400 hover:shadow-lg transition-all group">
                <div class="w-full h-32 rounded-lg bg-gradient-to-br from-sky-100 to-sky-50 mb-4 flex items-center justify-center border border-sky-100 group-hover:border-sky-200 transition-all">
                    <svg class="w-16 h-16 text-sky-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 0 2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128m0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                    </svg>
                </div>
                <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-sky-500">Aktivitas 01</span>
                <h3 class="text-lg font-display font-bold text-gray-900 mt-1">Kabar Media & AI</h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Otomatisasi konten berbasis AI generatif untuk publikasi ganda secara otonom.</p>
            </div>

            <div class="bg-white border border-sky-200 rounded-xl p-5 hover:border-indigo-300 hover:shadow-lg transition-all group">
                <div class="w-full h-32 rounded-lg bg-gradient-to-br from-indigo-100 to-indigo-50 mb-4 flex items-center justify-center border border-indigo-100 group-hover:border-indigo-200 transition-all">
                    <svg class="w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                    </svg>
                </div>
                <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-indigo-500">Aktivitas 02</span>
                <h3 class="text-lg font-display font-bold text-gray-900 mt-1">Kabar Intergenerasi</h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Kolaborasi lintas generasi dalam pelayanan, pelatihan, dan kreativitas bersama.</p>
            </div>

            <div class="bg-white border border-sky-200 rounded-xl p-5 hover:border-amber-300 hover:shadow-lg transition-all group">
                <div class="w-full h-32 rounded-lg bg-gradient-to-br from-amber-100 to-amber-50 mb-4 flex items-center justify-center border border-amber-100 group-hover:border-amber-200 transition-all">
                    <svg class="w-16 h-16 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                    </svg>
                </div>
                <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-amber-500">Aktivitas 03</span>
                <h3 class="text-lg font-display font-bold text-gray-900 mt-1">Kabar Pojok Muda</h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Wadah kreatif pemuda — podcast, diskusi, dan konten digital kekinian.</p>
            </div>

            <div class="bg-white border border-sky-200 rounded-xl p-5 hover:border-purple-300 hover:shadow-lg transition-all group">
                <div class="w-full h-32 rounded-lg bg-gradient-to-br from-purple-100 to-purple-50 mb-4 flex items-center justify-center border border-purple-100 group-hover:border-purple-200 transition-all">
                    <svg class="w-16 h-16 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
                <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-purple-500">Aktivitas 04</span>
                <h3 class="text-lg font-display font-bold text-gray-900 mt-1">Kabar Kolaborasi</h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Sinergi lintas gereja dan mitra strategis untuk jejaring ekumenis.</p>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6 mt-12">
            <div>
                <span class="text-[10px] font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-600">
                    JELAJAHI
                </span>
                <h2 class="text-2xl md:text-3xl font-display font-extrabold text-gray-900 mt-3">Kabar Baik Untuk Semua</h2>
            </div>
            <a href="#" class="hidden sm:inline-flex items-center gap-1.5 text-xs text-sky-500 hover:text-sky-700 transition-colors font-medium">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>

        <div class="flex flex-wrap gap-3 mb-14">
            <a href="#" class="bg-sky-500/20 border border-sky-500/30 text-sky-600 hover:bg-sky-500/30 hover:text-sky-800 transition-all px-4 py-2 rounded-full text-sm font-medium">
                Lihat Semua →
            </a>
            <a href="#" class="bg-white border border-sky-200 text-gray-600 hover:border-sky-400 hover:text-gray-900 transition-all px-4 py-2 rounded-full text-sm">Kabar</a>
            <a href="#" class="bg-white border border-sky-200 text-gray-600 hover:border-sky-400 hover:text-gray-900 transition-all px-4 py-2 rounded-full text-sm">Inspirasi</a>
            <a href="#" class="bg-white border border-sky-200 text-gray-600 hover:border-sky-400 hover:text-gray-900 transition-all px-4 py-2 rounded-full text-sm">Opini</a>
            <a href="#" class="bg-white border border-sky-200 text-gray-600 hover:border-sky-400 hover:text-gray-900 transition-all px-4 py-2 rounded-full text-sm">Cerita</a>
            <a href="#" class="bg-white border border-sky-200 text-gray-600 hover:border-sky-400 hover:text-gray-900 transition-all px-4 py-2 rounded-full text-sm">Puisi</a>
            <a href="#" class="bg-white border border-sky-200 text-gray-600 hover:border-sky-400 hover:text-gray-900 transition-all px-4 py-2 rounded-full text-sm">Lagu</a>
            <a href="#" class="bg-white border border-sky-200 text-gray-600 hover:border-sky-400 hover:text-gray-900 transition-all px-4 py-2 rounded-full text-sm">Buku</a>
        </div>

        <div class="space-y-6">
            <div class="bg-white border border-sky-200 rounded-xl p-6 md:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-5/12">
                        <div class="w-full h-56 rounded-xl bg-gradient-to-br from-sky-100 to-sky-50 border border-sky-100 flex items-center justify-center">
                            <svg class="w-28 h-28 text-sky-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 0 2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128m0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                            </svg>
                        </div>
                    </div>
                    <div class="w-full md:w-7/12">
                        <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-sky-500">Aktivitas 01</span>
                        <h2 class="text-2xl font-display font-bold text-gray-900 mt-2">Kabar Media & AI</h2>
                        <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                            Mengintegrasikan kecerdasan buatan generatif ke dalam alur produksi konten multimedia. Transkripsi otomatis, publikasi ke wiki.pgiwjabar.org dan blog kbrbaik.live, serta distribusi konten berbasis AI secara otonom dan terjadwal.
                        </p>
                        <div class="grid grid-cols-2 gap-3 mt-5">
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Transkripsi AI Hermes
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Publikasi ganda otomatis
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                WikiAI PGIW Jabar
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                OpenCode automation
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-sky-200 rounded-xl p-6 md:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-5/12">
                        <div class="w-full h-56 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-50 border border-indigo-100 flex items-center justify-center">
                            <svg class="w-28 h-28 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="w-full md:w-7/12">
                        <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-indigo-500">Aktivitas 02</span>
                        <h2 class="text-2xl font-display font-bold text-gray-900 mt-2">Kabar Intergenerasi</h2>
                        <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                            Menjembatani kesenjangan generasi dalam gereja melalui program pelatihan, mentoring, dan produksi konten bersama.
                        </p>
                        <div class="grid grid-cols-2 gap-3 mt-5">
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Mentoring lintas usia
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Pelatihan media digital
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Konten kolaboratif
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Pendampingan pelayanan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-sky-200 rounded-xl p-6 md:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-5/12">
                        <div class="w-full h-56 rounded-xl bg-gradient-to-br from-amber-100 to-amber-50 border border-amber-100 flex items-center justify-center">
                            <svg class="w-28 h-28 text-amber-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="w-full md:w-7/12">
                        <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-amber-500">Aktivitas 03</span>
                        <h2 class="text-2xl font-display font-bold text-gray-900 mt-2">Kabar Pojok Muda</h2>
                        <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                            Wadah kreatif yang digerakkan oleh dan untuk pemuda Kristen Jawa Barat. Produksi podcast, konten media sosial, dan diskusi tematik.
                        </p>
                        <div class="grid grid-cols-2 gap-3 mt-5">
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Podcast & radio streaming
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Konten media sosial
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Diskusi tematik
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Pengembangan bakat
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-sky-200 rounded-xl p-6 md:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-5/12">
                        <div class="w-full h-56 rounded-xl bg-gradient-to-br from-purple-100 to-purple-50 border border-purple-100 flex items-center justify-center">
                            <svg class="w-28 h-28 text-purple-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="w-full md:w-7/12">
                        <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-purple-500">Aktivitas 04</span>
                        <h2 class="text-2xl font-display font-bold text-gray-900 mt-2">Kabar Kolaborasi</h2>
                        <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                            Membangun dan memperkuat jejaring ekumenis antar gereja anggota PGIW Jawa Barat dan mitra strategis.
                        </p>
                        <div class="grid grid-cols-2 gap-3 mt-5">
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Jejaring ekumenis
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Berbagi sumber daya
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Program kolaborasi
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Gerakan bersama
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

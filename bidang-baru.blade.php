@extends('layouts.suara')

@section('title', 'Bidang - ' . ($station->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Bidang PGIW Jawa Barat</h1>
        <p class="text-gray-500 mt-1">Matriks Struktur & Sub-Bidang (Komisi/Desk)</p>
    </div>

    {{-- MPH Header --}}
    <div class="text-center mb-8">
        <div class="inline-block bg-gradient-to-r from-sky-700 to-sky-800 text-white rounded-xl px-10 py-5 shadow-md">
            <div class="flex items-center gap-3 justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                <div>
                    <h2 class="text-lg font-bold">MPH PGIW Jawa Barat</h2>
                    <p class="text-sm text-sky-200">Majelis Pekerja Harian</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Matrix Table --}}
    <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gradient-to-r from-sky-700 to-sky-800 text-white">
                    <th class="px-5 py-4 text-left font-semibold w-40">BIDANG</th>
                    <th class="px-5 py-4 text-left font-semibold">KOMISI / DESK</th>
                </tr>
            </thead>
            <tbody>
                @php
                $matrix = [
                    ['no' => 1, 'name' => 'Umum & Organisasi', 'icon' => '📋', 'subs' => ['Litbang']],
                    ['no' => 2, 'name' => 'Koinonia', 'icon' => '🤝', 'subs' => ['Komisi Anak & Remaja', 'Komisi Pemuda', 'Komisi Perempuan', 'Desk GRA']],
                    ['no' => 3, 'name' => 'Marturia', 'icon' => '📖', 'subs' => ['Desk KBB']],
                    ['no' => 4, 'name' => 'Diakonia', 'icon' => '❤️', 'subs' => ['Lingkungan Hidup & Bencana', 'Pendidikan', 'Desk PEJ']],
                    ['no' => 5, 'name' => 'Sarpras & Keuangan', 'icon' => '💰', 'subs' => ['Hukum & HAM']],
                    ['no' => 6, 'name' => 'Kesekretariatan', 'icon' => '📡', 'subs' => ['Media & Informasi']],
                ];
                @endphp
                @foreach ($matrix as $i => $b)
                <tr class="border-t border-gray-100 hover:bg-sky-50/50 transition">
                    <td class="px-5 py-4 align-top">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">{{ $b['icon'] }}</span>
                            <div>
                                <span class="text-xs font-mono font-bold text-sky-500 uppercase tracking-widest">Bidang {{ $b['no'] }}</span>
                                <h3 class="font-bold text-gray-900">{{ $b['name'] }}</h3>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        @if (count($b['subs']) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach ($b['subs'] as $sub)
                            @php
                            $slug = \Illuminate\Support\Str::slug($sub);
                            $cat = \App\Models\Category::where('slug', $slug)->first();
                            @endphp
                            @if ($cat)
                            <a href="{{ route('bidang') }}?category={{ $cat->slug }}" class="bg-sky-50 border border-sky-200 hover:bg-sky-100 hover:border-sky-300 text-sky-700 px-4 py-2 rounded-lg text-sm font-medium transition inline-flex items-center gap-1.5">
                                <span>{{ $sub }}</span>
                                <svg class="w-3 h-3 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            @else
                            <span class="bg-gray-50 border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm inline-flex items-center">{{ $sub }}</span>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <span class="text-gray-400 italic">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-xs text-gray-400 text-right">
        Sumber: Keputusan Sidang MPL PGIW Jabar 13-14 Februari 2026
    </div>
</div>
@endsection

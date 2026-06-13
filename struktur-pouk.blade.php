@extends('layouts.suara')

@section('title', 'Struktur POUK - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">STRUKTUR DAN PERSONALIA</h1>
        <h2 class="text-xl md:text-2xl font-semibold text-primary-600">POUK SE-JAWA BARAT</h2>
        <p class="text-gray-500 mt-1">Pelayanan Orang Umat Kristen</p>
    </div>

    @php
    $poukList = [
        ['nama' => 'POUK Husein Sastranegara', 'ketua' => 'Pdt. Andrew Batara', 'alamat' => 'Jl. Pajajaran No. 189A Bandung'],
        ['nama' => 'POUK Kemang Pratama', 'ketua' => 'Pdt. Dimas Arjuna Gulo', 'alamat' => 'Jl. Kemang Wijaya Kusuma Raya Blok BY, Kemang Pratama 5, Bekasi'],
        ['nama' => 'POUK GPI Imanuel IPDN', 'ketua' => 'Pdt. Judistian Hutahuruk', 'alamat' => 'Jl. Raya Bandung Sumedang KM 20 Jatinangor'],
        ['nama' => 'POUK GKPO Lanud Sulaiman', 'ketua' => 'Pdt. Guntur Harimukti', 'alamat' => 'Jl. Herkules IV no.2 Lanud Sulaiman Bandung'],
        ['nama' => 'POUK Depok 2 Timur', 'ketua' => 'Pdt. Kemmy Noya', 'alamat' => 'Perumnas Depok 2 Timur Jl. Merapi Raya Ujung, Abadi Jaya Depok'],
        ['nama' => 'POUK Pelita', 'ketua' => 'Pdt. Kornelius Rama', 'alamat' => 'Jl. Wijaya Kusuma No. 22 Komplek BTN Kopassus, Sukatani Depok'],
        ['nama' => 'POUK Dian Kasih', 'ketua' => 'Pdt. Samuel Adi Perdana', 'alamat' => 'Jl. Bunga III Blok B 4 No. 27 Komplek Deppen, Sukatani Cimanggis, Depok'],
        ['nama' => 'POUK PELNI', 'ketua' => '-', 'alamat' => 'Komplek PELNI Blok G, Bakti Jaya Cimanggis, Depok'],
        ['nama' => 'POUK Bumi Dirgantara Permai', 'ketua' => 'Pdt. Eko Pujo Santoso', 'alamat' => 'Perum Bumi Dirgantara Permai Jl. Dirgantara Raya, Jati Sari Bekasi'],
        ['nama' => 'POU PUKris Kota Wisata', 'ketua' => '-', 'alamat' => 'Ruko Sentra Eropa Blok D No. 46-48, Kota Wisata, Bogor'],
        ['nama' => 'POUK Citra Grand', 'ketua' => 'Pdt. Donal Viktor Ruy', 'alamat' => 'Jl. Alternatif KM 4 Perum Citra Grand Cibubur Bekasi'],
        ['nama' => 'POUK TNI AL Ciangsana', 'ketua' => 'Pdt. PH. Soukotta', 'alamat' => 'Komplek Rumdis Banpres TNI AL Ciangsana, Gunung Putri Bogor'],
        ['nama' => 'POUK Yon Pomad', 'ketua' => 'Pdt. John Aritonang', 'alamat' => 'Komplek YON POMAD Jonggol'],
        ['nama' => 'POUK Graha Prima', 'ketua' => 'Pdt. Renny Purba', 'alamat' => 'Perum Graha Prima Blok M, Mangunjaya Tambun Selatan Bekasi'],
        ['nama' => 'POUK Legenda Wisata', 'ketua' => '-', 'alamat' => 'Komplek Legenda Wisata'],
        ['nama' => 'POUK Anugerah Taman Galaxi', 'ketua' => 'Pdt. Hermon Siregar', 'alamat' => 'Perum Taman Galaksi Indah Bekasi Selatan'],
        ['nama' => 'POUK Atang Sanjaya', 'ketua' => 'Pdt. Hendri', 'alamat' => 'Jl. Rumah Sakit TNI AU Lanud Atang Sanjaya Bogor'],
        ['nama' => 'POUK Surya Darma', 'ketua' => 'Pdt. Nofita R. Matoneng', 'alamat' => 'Perum Lanud Suryadarma Kalijati Subang'],
        ['nama' => 'POUK Ekklesia Batujajar', 'ketua' => 'Pdt. Sanjaya Sihombing', 'alamat' => 'Komplek Pusdiklatssus Kopassus, Batujajar, Kab. Bandung Barat'],
        ['nama' => 'POUK Maranatha Yonkav 1', 'ketua' => 'Pdt. Helly Rahel Legi (Konsulen)', 'alamat' => 'Komplek Yonkav 1 Depok'],
    ];
    @endphp

    <section class="mb-16">
        <div class="bg-primary-600 text-white px-6 py-4 rounded-t-xl">
            <h2 class="text-xl font-bold">DAFTAR POUK & KETUA MAJELIS</h2>
        </div>
        <div class="bg-white border border-t-0 border-gray-200 rounded-b-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 w-12">No</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">POUK</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Ketua Majelis</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden md:table-cell">Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($poukList as $i => $p)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $p['nama'] }}</td>
                        <td class="px-4 py-3">
                            @if ($p['ketua'] !== '-')
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($p['ketua']) }}&background=4f46e5&color=fff&size=32&bold=true" class="w-8 h-8 rounded-full flex-shrink-0">
                                <span class="text-gray-800">{{ $p['ketua'] }}</span>
                            </div>
                            @else
                            <span class="text-gray-400 italic">&mdash;</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs hidden md:table-cell">{{ $p['alamat'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

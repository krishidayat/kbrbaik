@extends('layouts.suara')

@section('title', 'Struktur PGIS - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">STRUKTUR DAN PERSONALIA</h1>
        <h2 class="text-xl md:text-2xl font-semibold text-primary-600">PGIS SE-JAWA BARAT</h2>
        <p class="text-gray-500 mt-1">Persekutuan Gereja Indonesia Setempat</p>
    </div>

    @php
    $pgisList = [
        ['nama' => 'PGIS Kota Bandung', 'ketua' => 'Pdt. Yosafat Simatupang', 'alamat' => 'GKJ Merdeka : Jl. Merdeka No. 28 Bandung'],
        ['nama' => 'PGIS Kota Cimahi', 'ketua' => 'Pdt. Albert Naibaho', 'alamat' => 'GKP Cimahi : Jl. Gatot Subroto No. 24 Cimahi'],
        ['nama' => 'PGIS Kabupaten Bandung', 'ketua' => 'Pdt. Budi Kaedun', 'alamat' => 'GKPO Sulaiman : Jl. Herkules IV no.2 Lanud Sulaiman Bandung'],
        ['nama' => 'PGIS Kabupaten Bandung Barat', 'ketua' => 'Pdt. Andrian Mamahit', 'alamat' => 'GKPI Padalarang : Jl. Padalarang no.69 Kab. Bandung Barat'],
        ['nama' => 'PGIS Kabupaten Karawang', 'ketua' => 'Pdt. Agus Paulus Husen', 'alamat' => 'GKP Karawang : Jl. Kertabumi no. 39 Kota Karawang'],
        ['nama' => 'PGIS Kota Bekasi', 'ketua' => 'Pdt. Uli Saut Nainggolan', 'alamat' => 'Jl. Komodo Raya No. 03, Kayuringin Jaya, Bekasi Selatan'],
        ['nama' => 'PGIS Kabupaten Bekasi', 'ketua' => 'Pdt. Abdon Amtiran', 'alamat' => 'Jl. Mawar X No. 100, Sasak Tiga, Tambun Selatan, Kab. Bekasi'],
        ['nama' => 'PGIS Kota Depok', 'ketua' => 'Pdt. Rommy Palit', 'alamat' => 'Graha Imanuel Jl. Pemuda No. 51 Kota Depok'],
        ['nama' => 'PGIS Kota Bogor', 'ketua' => 'Pdt. MT Ruben Hutagalung', 'alamat' => 'Jl. Jendral Ahmad Yani No. 2 Tanah Sreal kota Bogor'],
        ['nama' => 'PGIS Kabupaten Bogor', 'ketua' => 'Pdt. Sulistio', 'alamat' => 'Gereja Kristus Ciampea Jl. Pasar Ciampea No. 3 Kab. Bogor'],
        ['nama' => 'PGIS Kota/Kabupaten Sukabumi', 'ketua' => 'Pdt. Lukman Sitorus', 'alamat' => 'Wisma Oikoumene Jl. Bhayangkara No. 232, Selabatu, Kota Sukabumi'],
        ['nama' => 'PGIS Kota/Kabupaten Cirebon', 'ketua' => 'Pdt. Sakriso Ladiana Saragih', 'alamat' => 'Ruko Vila Kecapi No.16 Jl. By Pass Kota Cirebon'],
        ['nama' => 'PGIS Cianjur', 'ketua' => 'Pdt. Oferlin Hia', 'alamat' => 'Gereja GKPB Cianjur, Jl. Yos Sudarso No. 1 Kota Cianjur'],
        ['nama' => 'PGIS Subang', 'ketua' => 'Pdt. Hendrik M. Tambunan', 'alamat' => 'HKBP Subang Jl. Gelanggang Olah Raga No.5 Kota Subang'],
        ['nama' => 'PGIS Purwakarta', 'ketua' => 'Pdt. Hariman Pattianakota', 'alamat' => 'Jl. Raya Sadang-Subang No. 9 Ciwangi, Kec. Bungursari, Kab. Purwakarta'],
    ];
    @endphp

    <section class="mb-16">
        <div class="bg-primary-600 text-white px-6 py-4 rounded-t-xl">
            <h2 class="text-xl font-bold">DAFTAR PGIS & KETUA UMUM</h2>
        </div>
        <div class="bg-white border border-t-0 border-gray-200 rounded-b-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 w-12">No</th>
                         <th class="text-left px-4 py-3 font-semibold text-gray-600">PGIS</th>
                         <th class="text-left px-4 py-3 font-semibold text-gray-600">Ketua Umum</th>
                         <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden md:table-cell">Alamat</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($pgisList as $i => $p)
                     <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                         <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                         <td class="px-4 py-3 font-medium text-gray-900">
                             <a href="{{ route('pgis.profile', \Illuminate\Support\Str::slug(str_replace(['Kota/Kabupaten ', 'Kabupaten ', 'Kota '], '', $p['nama']))) }}" class="hover:text-primary-700 transition">{{ $p['nama'] }}</a>
                             @auth
                             @php $slug = \Illuminate\Support\Str::slug(str_replace(['Kota/Kabupaten ', 'Kabupaten ', 'Kota '], '', $p['nama'])); $cat = \App\Models\Category::where('slug', $slug)->where('group', 'pgis')->first(); @endphp
                             @if ($cat)
                             <a href="{{ url('/admin/categories/' . $cat->id . '/edit') }}" class="inline-flex items-center ml-1.5 text-primary-400 hover:text-primary-600 transition align-middle" title="Edit Profil">
                                 <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                             </a>
                             @endif
                             @endauth
                         </td>
                         <td class="px-4 py-3">
                             <div class="flex items-center gap-2">
                                 <img src="https://ui-avatars.com/api/?name={{ urlencode($p['ketua']) }}&background=4f46e5&color=fff&size=32&bold=true" class="w-8 h-8 rounded-full flex-shrink-0">
                                 <span class="text-gray-800">{{ $p['ketua'] }}</span>
                             </div>
                         </td>
                         <td class="px-4 py-3 text-gray-500 text-xs hidden md:table-cell">{{ $p['alamat'] }}</td>
                         </td>
                         <td class="px-4 py-3">
                             <div class="flex items-center gap-2">
                                 <img src="https://ui-avatars.com/api/?name={{ urlencode($p['ketua']) }}&background=4f46e5&color=fff&size=32&bold=true" class="w-8 h-8 rounded-full flex-shrink-0">
                                 <span class="text-gray-800">{{ $p['ketua'] }}</span>
                             </div>
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

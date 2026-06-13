@extends('layouts.suara')

@section('title', 'Struktur Gereja Anggota - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
@php
$gerejaList = [
        ['nama' => 'Huria Kristen Batak Protestan (HKBP) JABARTENG DIY', 'sistem' => 'Distrik', 'pemimpin' => 'Pdt. Nikson M. Simanjuntak'],
        ['nama' => 'Huria Kristen Batak Protestan (HKBP) Bekasi', 'sistem' => 'Distrik', 'pemimpin' => 'Pdt. Hendri Napitupulu'],
        ['nama' => 'Huria Kristen Batak Protestan (HKBP) JABARTENG DIY', 'sistem' => 'Distrik', 'pemimpin' => 'Pdt. Ridoi Batubara'],
        ['nama' => 'Gereja Protestan Indonesia Barat (GPIB) JABAR 1 Bandung Raya', 'sistem' => 'Mupel', 'pemimpin' => 'Pdt. Maureen T.'],
        ['nama' => 'Gereja Protestan Indonesia Barat (GPIB) JABAR Bekasi', 'sistem' => 'Mupel', 'pemimpin' => 'Pdt. Daniel Lumentut'],
        ['nama' => 'Gereja Protestan Indonesia Barat (GPIB) JABAR 2 Bogor', 'sistem' => 'Mupel', 'pemimpin' => 'Pdt. Margie Ririhena de Wanna'],
        ['nama' => 'Gereja Kristen Indonesia (GKI) BPMK Bandung', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Hadijamto (Sekum)'],
        ['nama' => 'Gereja Kristen Indonesia (GKI) BPMK Cirebon', 'sistem' => 'Klasis', 'pemimpin' => ''],
        ['nama' => 'Gereja Kristen Indonesia (GKI) BPMK Jakarta 1', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Untari Setyowati'],
        ['nama' => 'Gereja Kristen Pasundan (GKP) PRIANGAN', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Kristian'],
        ['nama' => 'Gereja Kristen Pasundan (GKP) PURWAKARTA', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Suluh Sutia, S.Si'],
        ['nama' => 'Gereja Kristen Pasundan (GKP) CIREBON', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Elfrida'],
        ['nama' => 'Gereja Kristen Pasundan (GKP) BEKASI', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Duta Dewa Egne'],
        ['nama' => 'Gereja Kristen Pasundan (GKP) BOGOR', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Willian Aleksander'],
        ['nama' => 'Banua Niha Keriso Protestan (BNKP) BNKP 45', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Elkarya Telaumbanua'],
        ['nama' => 'Gereja Batak Karo Protestan (GBKP) JABAR BALI', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Elba Barus (Sekum)'],
        ['nama' => 'Gereja Kristen Protestan Indonesia (GKPI) Bandung Raya', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Hansintongan Gurning'],
        ['nama' => 'Gereja Kristen Protestan Indonesia (GKPI) BANDUNG RAYA', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Baha Pasaribu'],
        ['nama' => 'Gereja Kristen Protestan Indonesia (GKPI) CIKARANG BEKASI', 'sistem' => 'Resort', 'pemimpin' => ''],
        ['nama' => 'Gereja Kristen Protestan Indonesia (GKPI) DEPOK BOGOR', 'sistem' => 'Resort', 'pemimpin' => ''],
        ['nama' => 'Huria Kristen Indonesia (HKI) BEKASI', 'sistem' => 'Distrik', 'pemimpin' => 'Pdt. Happy Pakpahan / Pdt. Suan Dame Siahaan'],
        ['nama' => 'Huria Kristen Indonesia (HKI) Bandung raya', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Rio Nababan'],
        ['nama' => 'Gereja Kristen Jawa (GKJ) Citanduy', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Yohan Purwanto'],
        ['nama' => 'Gereja Kristen Jawa (GKJ) Jakarta Bagian Barat', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Fransiska Natalia Handayani'],
        ['nama' => 'Gereja Kristen Jawa (GKJ) Jakarta Bagian Timur', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Pinto'],
        ['nama' => 'Gereja Kristen Protestan Simalungun (GKPS) Bandung', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Jhon Hendrikson Haloho'],
        ['nama' => 'Gereja Kristen Protestan Simalungun (GKPS) Bogor', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Darwita Purba'],
        ['nama' => 'Gereja Kristen Protestan Simalungun (GKPS) Bekasi', 'sistem' => 'Resort', 'pemimpin' => ''],
        ['nama' => 'Gereja Kristen Protestan Simalungun (GKPS) Depok', 'sistem' => 'Resort', 'pemimpin' => ''],
        ['nama' => 'Gereja Toraja (GT) Pulau Jawa', 'sistem' => 'Klasis', 'pemimpin' => 'Pdt. Yunus Lambe'],
        ['nama' => 'Gereja Methodist Indonesia (GMI) Wilayah 2 Dejabotabek', 'sistem' => 'Distrik', 'pemimpin' => 'Pdt. Yohanes Samosir'],
        ['nama' => 'Gereja Masehi Injili Sangihe Talaud (GMIST) Jakarta', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Tinieke Tansil'],
        ['nama' => 'Gereja Kristen Kalam Kudus (GKKK)', 'sistem' => 'Sinode', 'pemimpin' => 'Pdt. Maria Sulistio'],
        ['nama' => 'Gereja Isa Almasih (GIA) Daerah VI Jabar', 'sistem' => 'Majelis Daerah', 'pemimpin' => 'Pdt. Elia Setiawan'],
        ['nama' => 'Gereja Gerakan Pentakosta (GGP) Jabar', 'sistem' => 'Majelis Daerah', 'pemimpin' => 'Pdt. Hendra (Sekum)'],
        ['nama' => 'Gereja Kristen Muria Indonesia (GKMI) Wilayah 1', 'sistem' => 'Wilayah', 'pemimpin' => 'Pdt. Iwan suhartono'],
        ['nama' => 'Gereja Kristen Protestan Angkola (GKPA) Jabar', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Novalina Batubara'],
        ['nama' => 'Gereja Kristen Protestan Angkola (GKPA) Bekasi Raya', 'sistem' => 'Resort', 'pemimpin' => ''],
        ['nama' => 'Gereja Kristen Perjanjian Baru (GKPB) Regional 2', 'sistem' => 'Regional', 'pemimpin' => 'Pdt. Toni Suwandi'],
        ['nama' => 'Gereja Kristen Perjanjian Baru (GKPB) Regional 3', 'sistem' => 'Regional', 'pemimpin' => 'Pdt. Munanda Marpaung'],
        ['nama' => 'Gereja Rehoboth', 'sistem' => 'Sinode', 'pemimpin' => 'Pdt. Jhon Simanjuntak (Sekretariat sinode)'],
        ['nama' => 'Gereja Kristus (GK) Wilayah Jabar', 'sistem' => 'Wilayah', 'pemimpin' => 'Pdt. Taryono sukamto'],
        ['nama' => 'Gereja Kristen Oikoumene (GKO) Bandung', 'sistem' => 'Wilayah', 'pemimpin' => 'Pdt. Rehardyan Dessialla'],
        ['nama' => 'Gereja Kristen Oikoumene (GKO) Depok Bekasi', 'sistem' => 'Wilayah', 'pemimpin' => 'Pdt. Dian AS'],
        ['nama' => 'Gereja Anglikan', 'sistem' => 'Wilayah', 'pemimpin' => 'Pdt. Daniel Sihombing'],
        ['nama' => 'Gereja Kristen Pengabar Injil (GKPI)', 'sistem' => 'Sinode', 'pemimpin' => 'Pdt. M. Asri'],
        ['nama' => 'Gereja Kristus Rahmani Indonesia (GKRI)', 'sistem' => 'Majelis Daerah', 'pemimpin' => 'Pdt. Darius Marao'],
        ['nama' => 'Gereja Bethel Indonesia (GBI)', 'sistem' => 'Majelis Daerah', 'pemimpin' => 'Ibu Elisabeth / Pdt. Isak Gunawan'],
        ['nama' => 'Gereja Sidang Jemaat Allah (GSJA) Bandung Raya', 'sistem' => 'Badan Pengurus Wilayah (BPW)', 'pemimpin' => 'Pdt. Aris Budianto'],
        ['nama' => 'Gereja Sidang Jemaat Allah (GSJA) Depok-Bekasi', 'sistem' => 'BPW', 'pemimpin' => ''],
        ['nama' => 'Gereja Sidang Jemaat Allah (GSJA) Bogor', 'sistem' => 'BPW', 'pemimpin' => 'Pdt. Daniel Yosafat'],
        ['nama' => 'Gereja Kristen Oikoumene Indonesia (GKOI)', 'sistem' => 'Sinode', 'pemimpin' => 'Pdt. David Tobing'],
        ['nama' => 'Gereja Bethel Injil Sepenuh (GBIS)', 'sistem' => 'Wilayah', 'pemimpin' => ''],
        ['nama' => 'Gereja Kristen Protestan Jawa Barat (GKP Jabar)', 'sistem' => 'Sinode', 'pemimpin' => 'Pdt. Frengky Tampubolon'],
        ['nama' => 'Gereja Kristen Protestan Jawa Barat (GKP Jabar)', 'sistem' => '', 'pemimpin' => 'Pdt. Suroso (sekum)'],
        ['nama' => 'Kerapatan Gereja Protestan Minahasa (KGPM)', 'sistem' => 'Wilayah', 'pemimpin' => ''],
        ['nama' => 'Gereja Kemah Injil Indonesia (GKII)', 'sistem' => 'Badan Pengurus Daerah (BPD)', 'pemimpin' => 'Pdt. Taru / Pdt. Waluyo'],
        ['nama' => 'Gereja Protestan Nusantara (GPN)', 'sistem' => 'Wilayah', 'pemimpin' => 'Pdt. Agus Besan'],
        ['nama' => 'Gereja Misi Injili Indonesia (GMII) Jawa Barat', 'sistem' => 'Pengurus Daerah', 'pemimpin' => 'Pdt. Joel Paranga'],
        ['nama' => 'Orahua Niha Keriso Protestan (ONKP) Jawa Barat', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Afolo Daeli / Pdt. Roslina'],
        ['nama' => 'Gereja Methodist Injili (GMI) Jabar', 'sistem' => 'Sinode', 'pemimpin' => 'Pdt. Joppy Rattu / Pnt. Togu Hutagalung'],
        ['nama' => 'Gereja Niha Keriso Protestan Indonesia (GNKPI) Jawa', 'sistem' => 'Resort', 'pemimpin' => 'Pdt. Fosawato Zalukhu'],
        ['nama' => 'Gereja Kristen Setia Indonesia (GKSI) Jawa Barat', 'sistem' => 'Pengurus Daerah', 'pemimpin' => 'Pdt. Berlinson Situmorang'],
        ['nama' => 'HKIP (Calon Anggota, 2025 ditunda)', 'sistem' => 'Sinode', 'pemimpin' => 'Pdt. Sianturi'],
        ['nama' => 'Gereja Allah Peduli Indonesia (GAPI) Calon Anggota', 'sistem' => 'Pengurus Daerah', 'pemimpin' => 'Pdt. Yonas'],
    ];
    @endphp

    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-200">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left px-4 py-3 font-semibold text-gray-600 w-12">No</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Nama Gereja</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Sistem</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Pemimpin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gerejaList as $i => $g)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400 align-top">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900 align-top">{{ $g['nama'] }}</td>
                    <td class="px-4 py-3 align-top">
                        <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-1 rounded">{{ $g['sistem'] ?: '-' }}</span>
                    </td>
                    <td class="px-4 py-3 align-top">
                        @if ($g['pemimpin'])
                        <div class="flex items-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($g['pemimpin']) }}&background=4f46e5&color=fff&size=32&bold=true" class="w-7 h-7 rounded-full flex-shrink-0">
                            <span class="text-gray-800">{{ $g['pemimpin'] }}</span>
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
</div>
@endsection

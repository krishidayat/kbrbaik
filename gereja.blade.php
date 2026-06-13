@extends('layouts.suara')
@section('title', 'Gereja - ' . ($station->name ?? 'Suara PGIW Jabar'))
@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Gereja</h1>
        <p class="text-gray-500 mt-1">Gereja Anggota PGIW Jawa Barat</p>
    </div>
    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-100">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-6 py-4 font-semibold text-gray-600 w-16">No</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Nama Gereja</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $i => $cat)
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-6 py-4 font-medium">{{ $cat->name }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('gereja.profile', $cat->slug) }}" class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-800 font-medium text-xs">Lihat Profil &rarr;</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.suara')

@section('title', 'Agenda - ' . ($station?->name ?? 'Suara PGIW Jabar'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Agenda</h1>
        <p class="text-gray-500 mt-1">Kegiatan {{ $station?->name ?? 'PGIW Jabar' }}</p>
    </div>

    @php $allTypes = $types ?? collect() @endphp
    <div class="flex items-center gap-1 mb-8 border-b border-gray-200 pb-2 overflow-x-auto" id="agenda-tabs">
        <button class="tab-btn px-4 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200 active flex items-center gap-1.5"
                data-type="semua"
                onclick="filterAgenda(this, 'semua')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            Semua
         </button>
         @foreach ($allTypes as $type)
         <button class="tab-btn px-3 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200 text-gray-500"
                 data-type="{{ $type }}"
                 onclick="filterAgenda(this, '{{ $type }}')">
             {{ $type }}
         </button>
         @endforeach
        <div class="ml-auto flex items-center gap-1">
            <a href="{{ route('agenda.kalender') }}" class="p-2 text-gray-400 hover:text-primary-600 transition rounded-lg hover:bg-primary-50" title="Kalender Bulanan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </a>
            <a href="{{ route('agenda.tahunan') }}" class="p-2 text-gray-400 hover:text-primary-600 transition rounded-lg hover:bg-primary-50" title="Agenda Tahunan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </a>
        </div>
    </div>

    <div id="agenda-loading" class="text-center py-12 hidden">
        <svg class="animate-spin h-8 w-8 text-primary-600 mx-auto" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="agenda-list">
        @forelse ($events as $event)
        @include('suara.agenda-card', ['event' => $event])
        @empty
        <div class="text-center py-12">
        <p class="text-gray-400 text-lg">Belum ada agenda</p>
        </div>
        @endforelse
    </div>

    {{-- Catatan Program Tak Terkategorisasi --}}
    <div class="mt-8 bg-amber-50 border border-amber-200 rounded-xl p-5">
        <h3 class="font-bold text-sm text-amber-800 mb-2">📌 Catatan Program</h3>
        <p class="text-sm text-amber-700">
            Program-program yang belum memiliki kategori dan waktu pelaksanaan tertentu akan dicatat dan dijadwalkan setelah koordinasi lebih lanjut dengan masing-masing bidang/komisi/desk.
        </p>
    </div>
</div>

    <div id="agenda-empty" class="text-center py-12 text-gray-400 hidden">
        Belum ada agenda di kategori ini.
    </div>
</div>

<script>
function filterAgenda(btn, type) {
    document.querySelectorAll('#agenda-tabs .tab-btn').forEach(function(b) {
        b.classList.remove('active', 'text-primary-600', 'font-bold', 'text-red-600');
        b.classList.add('text-gray-500');
    });
    btn.classList.remove('text-gray-500');
    btn.classList.add('active', 'text-primary-600', 'font-bold');

    var list = document.getElementById('agenda-list');
    var loading = document.getElementById('agenda-loading');
    var empty = document.getElementById('agenda-empty');

    list.classList.add('hidden');
    empty.classList.add('hidden');
    loading.classList.remove('hidden');

    var url = type === 'semua' ? '/api/agenda' : '/api/agenda/type/' + type;
    fetch(url)
        .then(function(r) { return r.json(); })
        .then(function(json) {
            var data = json.data || [];
            loading.classList.add('hidden');
            if (data.length === 0) {
                empty.classList.remove('hidden');
            } else {
                list.innerHTML = data.map(renderAgendaCard).join('');
                list.classList.remove('hidden');
            }
        })
        .catch(function() {
            loading.classList.add('hidden');
            empty.classList.remove('hidden');
            empty.textContent = 'Gagal memuat agenda.';
        });
}

function renderAgendaCard(event) {
    var d = new Date(event.event_date);
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    var day = d.getDate();
    var month = months[d.getMonth()];

    return '<a href="/agenda/' + event.slug + '" class="block bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition group">'
        + (event.featured_image ? '<div class="w-full h-32 overflow-hidden"><img src="' + event.featured_image + '" alt="' + event.title + '" class="w-full h-full object-cover group-hover:scale-105 transition duration-300"></div>' : '')
        + '<div class="flex">'
        + '<div class="flex flex-col items-center justify-center w-20 bg-gradient-to-b from-primary-500 to-primary-700 text-white py-3 px-2 flex-shrink-0">'
        + '<span class="text-xs font-semibold uppercase tracking-wider">' + month + '</span>'
        + '<span class="text-2xl font-bold leading-tight">' + day + '</span>'
        + '</div>'
        + '<div class="p-4 flex-1 flex flex-col justify-center">'
        + '<span class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-0.5 rounded self-start">' + event.type + '</span>'
        + '<h3 class="font-semibold text-sm mt-1.5">' + event.title + '</h3>'
        + (event.location ? '<p class="text-xs text-gray-400 mt-1">' + event.location + '</p>' : '')
        + '</div>'
        + '</div>'
        + '</a>';
}
</script>
@endsection

@php
$date = $event->event_date;
$day = $date->format('d');
$month = $date->locale('id')->isoFormat('MMM');
$fullDate = $date->locale('id')->isoFormat('dddd, D MMMM YYYY');
@endphp
<a href="{{ route('agenda.show', $event->slug) }}" class="block bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition group">
    @if ($event->featured_image)
    <div class="w-full h-32 overflow-hidden">
        <img src="{{ asset('storage/' . $event->featured_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
    </div>
    @endif
    <div class="flex">
        <div class="flex flex-col items-center justify-center w-20 bg-gradient-to-b from-primary-500 to-primary-700 text-white py-3 px-2 flex-shrink-0">
            <span class="text-xs font-semibold uppercase tracking-wider">{{ $month }}</span>
            <span class="text-2xl font-bold leading-tight">{{ $day }}</span>
        </div>
        <div class="p-4 flex-1 flex flex-col justify-center">
            <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-0.5 rounded self-start">{{ $event->type }}</span>
            <h3 class="font-semibold text-sm mt-1.5">{{ $event->title }}</h3>
            @if ($event->location)
            <p class="text-xs text-gray-400 mt-1">{{ $event->location }}</p>
            @endif
        </div>
    </div>
</a>

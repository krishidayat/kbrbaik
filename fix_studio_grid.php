<?php
$f = '/var/www/radio/resources/views/kbrbaik-komunitas.blade.php';
$c = file_get_contents($f);

$oldSection = '    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            @php $allKom = \App\Models\Community::where(\'station_id\', $station?->id ?? 1)->where(\'is_active\', true)->get(); @endphp

            <div id="kom-content" class="flex flex-col md:flex-row gap-8">
                <div class="md:w-3/4 order-2 md:order-1 space-y-6">
                    @if ($allKom->isEmpty())
                    <div class="text-center py-16"><p class="text-sky-500">Belum ada komunitas.</p></div>
                    @else
                    @foreach ($allKom as $kom)
                    @php $studios = $kom->studios()->where(\'is_active\', true)->get(); @endphp
                    <div class="kom-card bg-white rounded-xl border border-sky-100 overflow-hidden shadow-sm" data-id="{{ $kom->id }}">
                        <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <a href="{{ route(\'komunitas.show\', $kom->slug) }}" class="text-xl font-bold hover:text-white/80 transition">{{ $kom->name }}</a>
                                    @if ($kom->city)
                                    <p class="text-sm text-sky-200 mt-0.5">{{ $kom->city }}{{ $kom->region ? \' \\u2014 \' . $kom->region : \'\' }}</p>
                                    @endif
                                    <p class="text-xs text-sky-300 mt-0.5">{{ $studios->count() }} studio</p>
                                </div>
                                @auth
                                <a href="{{ url(\'/admin/communities/\' . $kom->id . \'/edit\') }}" class="text-white/70 hover:text-white transition" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                @endauth
                            </div>
                        </div>
                        @if ($studios->isEmpty())
                        <div class="p-6 text-center text-gray-400 text-sm">Belum ada studio.</div>
                        @else
                        <div class="p-6 grid md:grid-cols-2 gap-4">
                            @foreach ($studios as $s)
                            <div class="border border-sky-100 rounded-xl p-4 hover:shadow-md transition">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-lg">&#x1f399;</div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $s->name }}</h3>
                                        <span class="text-xs text-gray-400">Studio</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-400 mt-2">
                                    @if ($s->youtube_url) <span>&#x25b6;&#xfe0f; YouTube</span> @endif
                                    @if ($s->spotify_url) <span>&#x1f3b5; Spotify</span> @endif
                                    @if ($s->stream_url) <span>&#x1f534; Live</span> @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                    @endif
                </div>

                <div class="md:w-1/4 order-1 md:order-2">
                    <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                        <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Komunitas</h3>
                        <div class="space-y-2" id="kom-list">
                            @foreach ($allKom as $kom)
                            @php $nama = preg_replace(\'/^Kabar /\', \'\', $kom->name); @endphp
                            <button onclick="scrollToKom({{ $kom->id }})" class="tab-kom flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-white text-sky-700 border border-sky-200 hover:bg-sky-100">
                                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                                {{ $nama }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    function scrollToKom(id) {
        var el = document.querySelector(\'.kom-card[data-id="\' + id + \'"]\');
        if (el) {
            el.scrollIntoView({behavior: \'smooth\', block: \'start\'});
            el.classList.add(\'ring-2\', \'ring-sky-400\');
            setTimeout(function() { el.classList.remove(\'ring-2\', \'ring-sky-400\'); }, 2000);
        }
    }
    </script>';

$newSection = '    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            @php
            $allStudios = \App\Models\Studio::where(\'station_id\', $station?->id ?? 1)->where(\'is_active\', true)->with(\'community\')->get();
            $allKom = \App\Models\Community::where(\'station_id\', $station?->id ?? 1)->where(\'is_active\', true)->get();
            @endphp

            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-3/4 order-2 md:order-1">
                    <h1 class="text-4xl font-bold mb-8 text-sky-900">Studio</h1>
                    @if ($allStudios->isEmpty())
                    <div class="text-center py-16"><p class="text-sky-500">Belum ada studio.</p></div>
                    @else
                    <div id="studio-grid" class="grid md:grid-cols-2 gap-6">
                        @foreach ($allStudios as $s)
                        <div class="studio-card bg-white border border-sky-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition" data-kom="{{ $s->community_id }}">
                            <div class="p-5">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-xl shrink-0">&#x1f399;</div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $s->name }}</h3>
                                        <span class="text-xs text-sky-500">{{ $s->community->name ?? \'\' }}</span>
                                    </div>
                                    @auth
                                    <a href="{{ url(\'/admin/studios/\' . $s->id . \'/edit\') }}" class="ml-auto text-gray-300 hover:text-sky-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                    @endauth
                                </div>
                                @if ($s->description)
                                <p class="text-sm text-gray-500 mb-3">{{ Str::limit($s->description, 80) }}</p>
                                @endif
                                <div class="flex flex-wrap gap-2">
                                    @if ($s->youtube_url) <a href="{{ $s->youtube_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-full hover:bg-red-100 transition">&#x25b6;&#xfe0f; YouTube</a> @endif
                                    @if ($s->spotify_url) <a href="{{ $s->spotify_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-green-50 text-green-600 px-3 py-1.5 rounded-full hover:bg-green-100 transition">&#x1f3b5; Spotify</a> @endif
                                    @if ($s->stream_url) <a href="{{ $s->stream_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-purple-50 text-purple-600 px-3 py-1.5 rounded-full hover:bg-purple-100 transition">&#x1f534; Live</a> @endif
                                    <a href="{{ route(\'komunitas.show\', $s->community->slug) }}" class="inline-flex items-center gap-1 text-xs bg-sky-50 text-sky-600 px-3 py-1.5 rounded-full hover:bg-sky-100 transition">&#x1f3e0; Profil</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="md:w-1/4 order-1 md:order-2">
                    <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                        <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Komunitas</h3>
                        <div class="space-y-2" id="kom-list">
                            <button onclick="filterKom(0)" class="tab-kom flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-sky-800 text-white" data-id="0">&#x25c9; Semua</button>
                            @foreach ($allKom as $kom)
                            @php $nama = preg_replace(\'/^Kabar /\', \'\', $kom->name); @endphp
                            <button onclick="filterKom({{ $kom->id }})" class="tab-kom flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-white text-sky-700 border border-sky-200 hover:bg-sky-100" data-id="{{ $kom->id }}">
                                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                                {{ $nama }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    var currentKom = 0;
    function filterKom(id) {
        currentKom = id;
        document.querySelectorAll(\'.tab-kom\').forEach(function(btn) {
            var isActive = parseInt(btn.dataset.id) === id;
            btn.classList.toggle(\'bg-sky-800\', isActive);
            btn.classList.toggle(\'text-white\', isActive);
            btn.classList.toggle(\'text-sky-700\', !isActive);
            btn.classList.toggle(\'bg-white\', !isActive);
            btn.classList.toggle(\'border\', !isActive);
            btn.classList.toggle(\'border-sky-200\', !isActive);
        });
        document.querySelectorAll(\'.studio-card\').forEach(function(card) {
            var match = id === 0 || parseInt(card.dataset.kom) === id;
            card.style.display = match ? \'\' : \'none\';
        });
        var title = id === 0 ? \'Semua Studio\' : document.querySelector(\'.tab-kom[data-id="\' + id + \'"]\').textContent.trim();
        document.querySelector(\'#studio-grid\').parentNode.querySelector(\'h1\').textContent = title;
    }
    </script>';

$c = str_replace($oldSection, $newSection, $c);
file_put_contents($f, $c);
echo "OK\n";

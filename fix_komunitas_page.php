<?php
$f = '/var/www/radio/resources/views/kbrbaik-komunitas.blade.php';
$c = file_get_contents($f);

$oldSection = '    <section class="bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
        <div class="max-w-6xl mx-auto px-4 py-16 md:py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Komunitas Klasikal</h1>
            <p class="text-lg text-sky-100 max-w-2xl mx-auto">Stasiun satelit per wilayah Klasikal — wadah kreatif dan pelayanan bersama.</p>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Filter Sinode --}}
            <div class="flex flex-wrap gap-2 mb-8 border-b border-sky-200 pb-3">
                <button onclick="filterSinode(\'semua\')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-sky-800 text-white transition sinode-filter" data-sinode="semua">Semua</button>
                <button onclick="filterSinode(\'gkj\')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-white text-sky-700 border border-sky-200 hover:bg-sky-50 transition sinode-filter" data-sinode="gkj">GKJ</button>
                <button onclick="filterSinode(\'gki\')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-white text-sky-700 border border-sky-200 hover:bg-sky-50 transition sinode-filter" data-sinode="gki">GKI</button>
                <button onclick="filterSinode(\'gerejawi\')" class="px-4 py-2 rounded-lg text-sm font-semibold bg-white text-sky-700 border border-sky-200 hover:bg-sky-50 transition sinode-filter" data-sinode="gerejawi">Gerejawi</button>
            </div>

            @php
            $komunitas = \App\Models\Community::where(\'station_id\', $station?->id ?? 1)->where(\'is_active\', true)->get();
            @endphp

            @if ($komunitas->isEmpty())
            <div class="text-center py-16">
                <p class="text-sky-500">Belum ada komunitas.</p>
            </div>
            @else
            @foreach ($komunitas as $kom)
            @php $studios = $kom->studios()->where(\'is_active\', true)->get(); @endphp
            <div class="sinode-group bg-white rounded-xl border border-sky-100 overflow-hidden shadow-sm mb-6" data-sinode="{{ $kom->slug }}">
                <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold">{{ $kom->name }}</h2>
                            <p class="text-sm text-sky-200 mt-0.5">{{ $studios->count() }} studio \\u2022 {{ $kom->description ?? \'Klasis\' }}</p>
                        </div>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-semibold">{{ $kom->slug }}</span>
                    </div>
                </div>
                @if ($studios->isEmpty())
                <div class="p-6 text-center text-gray-400 text-sm">Belum ada studio.</div>
                @else
                <div class="p-6 grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($studios as $s)
                    <div class="border border-sky-100 rounded-xl p-4 hover:shadow-md transition group">
                        <a href="{{ route(\'komunitas.show\', $kom->slug) }}?studio={{ $s->id }}" class="block">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-lg">\\ud83c\\udf99</div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm group-hover:text-sky-700">{{ $s->name }}</h3>
                                    <span class="text-xs text-gray-400">Studio</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-400 mt-2">
                                @if ($s->youtube_url) <span>\\u25b6\\ufe0f YouTube</span> @endif
                                @if ($s->spotify_url) <span>\\ud83c\\udfb5 Spotify</span> @endif
                                @if ($s->stream_url) <span>\\ud83d\\udd34 Live</span> @endif
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
            @endif
        </div>
    </section>

    <script>
    function filterSinode(slug) {
        document.querySelectorAll(\'.sinode-filter\').forEach(function(btn) {
            var isActive = btn.dataset.sinode === slug;
            btn.classList.toggle(\'bg-sky-800\', isActive);
            btn.classList.toggle(\'text-white\', isActive);
            btn.classList.toggle(\'bg-white\', !isActive);
            btn.classList.toggle(\'text-sky-700\', !isActive);
            btn.classList.toggle(\'border\', !isActive);
            btn.classList.toggle(\'border-sky-200\', !isActive);
        });
        document.querySelectorAll(\'.sinode-group\').forEach(function(g) {
            g.style.display = (slug === \'semua\' || g.dataset.sinode === slug || g.dataset.sinode.includes(slug)) ? \'\' : \'none\';
        });
    }
    </script>
        </div>
    </section>';

$newSection = '    <section class="bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
        <div class="max-w-6xl mx-auto px-4 py-12 md:py-16 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Komunitas Stasiun Lokal</h1>
            <p class="text-lg text-sky-100 max-w-2xl mx-auto">Stasiun komunitas per wilayah — wadah kreatif dan pelayanan bersama.</p>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            @php
            $allKom = \App\Models\Community::where(\'station_id\', $station?->id ?? 1)->where(\'is_active\', true)->get();
            @endphp

            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-3/4 order-2 md:order-1">

                    @if ($allKom->isEmpty())
                    <div class="text-center py-16">
                        <p class="text-sky-500">Belum ada komunitas.</p>
                    </div>
                    @else
                    <div id="komunitas-container">
                        @foreach ($allKom as $kom)
                        @php $studios = $kom->studios()->where(\'is_active\', true)->get(); @endphp
                        <div class="kom-card bg-white rounded-xl border border-sky-100 overflow-hidden shadow-sm mb-6" data-id="{{ $kom->id }}">
                            <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <a href="{{ route(\'komunitas.show\', $kom->slug) }}" class="text-xl font-bold hover:text-white/80 transition">{{ $kom->name }}</a>
                                        @if ($kom->city || $kom->region)
                                        <p class="text-sm text-sky-200 mt-0.5">{{ $kom->city }}{{ $kom->city && $kom->region ? \' — \' : \'\' }}{{ $kom->region }}</p>
                                        @endif
                                        <p class="text-xs text-sky-200 mt-0.5">{{ $studios->count() }} studio</p>
                                    </div>
                                    @auth
                                    <a href="{{ url(\'/admin/communities/\' . $kom->id . \'/edit\') }}" class="text-white/70 hover:text-white transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
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
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-lg">🎙</div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-sm">{{ $s->name }}</h3>
                                            <span class="text-xs text-gray-400">Studio</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-gray-400 mt-2">
                                        @if ($s->youtube_url) <span>▶️ YouTube</span> @endif
                                        @if ($s->spotify_url) <span>🎵 Spotify</span> @endif
                                        @if ($s->stream_url) <span>🔴 Live</span> @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="md:w-1/4 order-1 md:order-2">
                    <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                        <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Komunitas</h3>
                        <div class="space-y-2">
                            @foreach ($allKom as $kom)
                            <button onclick="scrollToKom({{ $kom->id }})" class="flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition text-left bg-white text-sky-700 border border-sky-200 hover:bg-sky-100" data-kom="{{ $kom->id }}">
                                <span class="w-2 h-2 rounded-full bg-sky-400 shrink-0"></span>
                                {{ $kom->name }}
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

$c = str_replace($oldSection, $newSection, $c);
file_put_contents($f, $c);
echo "OK\n";

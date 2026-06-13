<?php
$f = '/var/www/radio/resources/views/kbrbaik-komunitas.blade.php';
$c = file_get_contents($f);

$oldSection = '    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4">
            @php $communities = \App\Models\Community::where(\'station_id\', $station?->id ?? 1)->where(\'is_active\', true)->get(); @endphp
            @forelse ($communities as $kom)
            @php $studios = $kom->studios()->where(\'is_active\', true)->get(); @endphp
                <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <a href="{{ route(\'komunitas.show\', $kom->slug) }}" class="text-xl font-bold hover:text-white/80 transition">{{ $kom->name }}</a>
                            <p class="text-sm text-sky-200 mt-0.5">{{ $studios->count() }} studio &bull; {{ $kom->description ?? \'Klasis\' }}</p>
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
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-lg">&#x1f399;</div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm group-hover:text-sky-700">{{ $s->name }}</h3>
                                    <span class="text-xs text-gray-400">Studio</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-400 mt-2">
                                @if ($s->youtube_url) <span>&#x25b6;&#xfe0f; YouTube</span> @endif
                                @if ($s->spotify_url) <span>&#x1f3b5; Spotify</span> @endif
                                @if ($s->stream_url) <span>&#x1f534; Live</span> @endif
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </section>';

$newSection = '    <section class="py-12">
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

$c = str_replace($oldSection, $newSection, $c);

// Remove old filterSinode JS
$c = preg_replace('/<script>\s*function filterSinode.*?<\/script>\s*/s', '', $c);
// Remove orphan </div> before footer
$c = preg_replace('/\s*<\/div>\s*\n\s*<\/section>\s*$/m', '', $c, 1);

file_put_contents($f, $c);
echo "OK\n";

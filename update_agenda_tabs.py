import re

# ============================================================
# 1. UPDATE API ROUTES
# ============================================================
with open('/var/www/radio/routes/api.php', 'r') as f:
    api_content = f.read()

# Find position of last agenda route and add new source endpoints
api_new_routes = """
Route::get('/agenda/source/{source}', function ($source) {
    $station = Station::where('domain', request()->getHost())->where('is_active', true)->first();
    if (!$station) return response()->json(['data' => []]);

    $sources = ['komunitas', 'studio', 'blog', 'pelatihan', 'live', 'siaran_langsung'];

    $all = [];

    if (in_array($source, ['semua', 'komunitas'])) {
        $events = Event::where('station_id', $station->id)->where('is_published', true)
            ->where(function ($q) {
                $q->where('organizer', 'like', '%Komunitas%')
                  ->orWhere('organizer', 'like', '%komunitas%');
            })
            ->orderBy('event_date', 'desc')->get()->map(function ($e) {
                return [
                    'id' => $e->id, 'title' => $e->title, 'slug' => $e->slug,
                    'type' => 'Komunitas', 'event_date' => $e->event_date->format('Y-m-d'),
                    'location' => $e->location, 'featured_image' => $e->featured_image ? asset('storage/'.$e->featured_image) : null,
                    'url' => '/agenda/'.$e->slug,
                ];
            });
        $all = array_merge($all, $events->toArray());
    }

    if (in_array($source, ['semua', 'studio'])) {
        $episodes = Episode::whereHas('studio', function ($q) use ($station) {
                $q->where('station_id', $station->id)->where('is_active', true);
            })->where('is_published', true)->orderBy('published_at', 'desc')->get()->map(function ($e) {
                return [
                    'id' => $e->id, 'title' => $e->title, 'slug' => $e->slug,
                    'type' => 'Studio', 'event_date' => $e->published_at ? $e->published_at->format('Y-m-d') : now()->format('Y-m-d'),
                    'location' => $e->studio?->name ?? 'Studio', 'featured_image' => $e->thumbnail ? asset('storage/'.$e->thumbnail) : null,
                    'url' => '/komunitas/'.$e->studio?->community?->slug.'/studio/'.$e->studio?->slug,
                ];
            });
        $all = array_merge($all, $episodes->toArray());
    }

    if (in_array($source, ['semua', 'blog'])) {
        $posts = Post::where('station_id', $station->id)->where('is_published', true)
            ->orderBy('published_at', 'desc')->get()->map(function ($p) {
                return [
                    'id' => $p->id, 'title' => $p->title, 'slug' => $p->slug,
                    'type' => 'Blog', 'event_date' => $p->published_at ? $p->published_at->format('Y-m-d') : $p->created_at->format('Y-m-d'),
                    'location' => null, 'featured_image' => $p->featured_image ? asset('storage/'.$p->featured_image) : null,
                    'url' => '/'.$p->slug,
                ];
            });
        $all = array_merge($all, $posts->toArray());
    }

    if (in_array($source, ['semua', 'pelatihan'])) {
        $pelatihan = Event::where('station_id', $station->id)->where('is_published', true)
            ->where('type', 'pelatihan')->orderBy('event_date', 'desc')->get()->map(function ($e) {
                return [
                    'id' => $e->id, 'title' => $e->title, 'slug' => $e->slug,
                    'type' => 'Pelatihan', 'event_date' => $e->event_date->format('Y-m-d'),
                    'location' => $e->location, 'featured_image' => $e->featured_image ? asset('storage/'.$e->featured_image) : null,
                    'url' => '/agenda/'.$e->slug,
                ];
            });
        $all = array_merge($all, $pelatihan->toArray());
    }

    if (in_array($source, ['semua', 'live', 'siaran_langsung'])) {
        $live = Event::where('station_id', $station->id)->where('is_published', true)
            ->where(function ($q) {
                $q->where('type', 'live')->orWhere('type', 'siaran_langsung');
            })->orderBy('event_date', 'desc')->get()->map(function ($e) {
                return [
                    'id' => $e->id, 'title' => $e->title, 'slug' => $e->slug,
                    'type' => 'Siaran Live', 'event_date' => $e->event_date->format('Y-m-d'),
                    'location' => $e->location, 'featured_image' => $e->featured_image ? asset('storage/'.$e->featured_image) : null,
                    'url' => '/agenda/'.$e->slug,
                ];
            });
        $all = array_merge($all, $live->toArray());
    }

    usort($all, function ($a, $b) {
        return strcmp($b['event_date'], $a['event_date']);
    });

    return response()->json(['data' => array_values($all)]);
})->name('api.agenda.source');
"""

# Insert after the existing agenda.type route
insert_pos = api_content.rfind("})->name('api.agenda.type');")
if insert_pos != -1:
    # Find the end of that statement
    end_of_stmt = api_content.find("\n", insert_pos)
    api_content = api_content[:end_of_stmt+1] + api_new_routes + api_content[end_of_stmt+1:]

with open('/var/www/radio/routes/api.php', 'w') as f:
    f.write(api_content)

# ============================================================
# 2. UPDATE AGENDA VIEW
# ============================================================
with open('/var/www/radio/resources/views/kbrbaik-agenda.blade.php', 'r') as f:
    view = f.read()

# Replace the tabs section - remove old type loop, add new static tabs
old_tabs = '''        @php $allTypes = $types ?? collect() @endphp
        <div class="flex flex-wrap gap-2 mb-8 border-b border-sky-200 pb-2" id="agenda-tabs">
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200 active"
                    data-type="semua"
                    onclick="filterAgenda(this, 'semua')">
                Semua
            </button>
            @foreach ($allTypes as $type)
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200"
                    data-type="{{ $type }}"
                    onclick="filterAgenda(this, '{{ $type }}')">
                {{ ucfirst($type) }}
            </button>
            @endforeach
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200 ml-auto"
                    data-type="kalender"
                    onclick="showKalender(this)">
                📅 Kalender
            </button>
        </div>'''

new_tabs = '''        <div class="flex flex-wrap gap-2 mb-8 border-b border-sky-200 pb-2" id="agenda-tabs">
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200 active"
                    data-source="semua"
                    onclick="filterAgenda(this, 'semua')">
                Semua
            </button>
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200"
                    data-source="komunitas"
                    onclick="filterAgenda(this, 'komunitas')">
                Komunitas
            </button>
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200"
                    data-source="studio"
                    onclick="filterAgenda(this, 'studio')">
                Studio
            </button>
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200"
                    data-source="blog"
                    onclick="filterAgenda(this, 'blog')">
                Blog
            </button>
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200"
                    data-source="pelatihan"
                    onclick="filterAgenda(this, 'pelatihan')">
                Pelatihan
            </button>
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200"
                    data-source="live"
                    onclick="filterAgenda(this, 'live')">
                Siaran Live
            </button>
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200 ml-auto"
                    data-source="kalender"
                    onclick="showKalender(this)">
                📅 Kalender
            </button>
        </div>'''

view = view.replace(old_tabs, new_tabs, 1)

# Update filterAgenda JS function
old_filter = '''    function filterAgenda(btn, type) {
        document.querySelectorAll('#agenda-tabs .tab-btn').forEach(function(b) {
            b.classList.remove('active', 'bg-sky-600', 'text-white', 'shadow-md');
            b.classList.add('bg-sky-100', 'text-gray-600', 'hover:bg-sky-200');
        });
        btn.classList.add('active', 'bg-sky-600', 'text-white', 'shadow-md');
        btn.classList.remove('bg-sky-100', 'text-gray-600', 'hover:bg-sky-200');

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
    }'''

new_filter = '''    function filterAgenda(btn, source) {
        document.querySelectorAll('#agenda-tabs .tab-btn').forEach(function(b) {
            b.classList.remove('active', 'bg-sky-600', 'text-white', 'shadow-md');
            b.classList.add('bg-sky-100', 'text-gray-600', 'hover:bg-sky-200');
        });
        btn.classList.add('active', 'bg-sky-600', 'text-white', 'shadow-md');
        btn.classList.remove('bg-sky-100', 'text-gray-600', 'hover:bg-sky-200');

        document.getElementById('agenda-kalender').classList.add('hidden');

        var list = document.getElementById('agenda-list');
        var loading = document.getElementById('agenda-loading');
        var empty = document.getElementById('agenda-empty');

        list.classList.add('hidden');
        empty.classList.add('hidden');
        loading.classList.remove('hidden');

        fetch('/api/agenda/source/' + source)
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
    }'''

view = view.replace(old_filter, new_filter, 1)

# Update renderAgendaCard to use the url field from API
old_render = '''    function renderAgendaCard(event) {
        var date = new Date(event.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
        var img = event.featured_image
            ? '<img src="' + event.featured_image + '" alt="' + event.title + '" class="w-full h-40 object-cover">'
            : '<div class="w-full h-40 bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-4xl">📅</div>';
        return '<a href="/agenda/' + event.slug + '" class="block bg-white rounded-xl overflow-hidden shadow-sm border border-sky-100 hover:shadow-md transition">'
            + '<div class="flex flex-col md:flex-row">'
            + '<div class="md:w-56 flex-shrink-0">' + img + '</div>'
            + '<div class="p-5 flex-1">'
            + '<span class="text-xs font-semibold text-sky-600 bg-sky-50 px-2 py-1 rounded">' + event.type + '</span>'
            + '<h3 class="font-semibold text-lg mt-2 mb-1">' + event.title + '</h3>'
            + '<p class="text-sm text-gray-500"><svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>' + date + '</p>'
            + (event.location ? '<p class="text-sm text-gray-500 mt-1"><svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' + event.location + '</p>' : '')
            + '</div>'
            + '</div>'
            + '</a>';
    }'''

new_render = '''    function renderAgendaCard(event) {
        var date = new Date(event.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
        var img = event.featured_image
            ? '<img src="' + event.featured_image + '" alt="' + event.title + '" class="w-full h-40 object-cover">'
            : '<div class="w-full h-40 bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-4xl">📅</div>';
        var loc = event.location ? '<p class="text-sm text-gray-500 mt-1"><svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' + event.location + '</p>' : '';
        return '<a href="' + event.url + '" class="block bg-white rounded-xl overflow-hidden shadow-sm border border-sky-100 hover:shadow-md transition">'
            + '<div class="flex flex-col md:flex-row">'
            + '<div class="md:w-56 flex-shrink-0">' + img + '</div>'
            + '<div class="p-5 flex-1">'
            + '<span class="text-xs font-semibold text-sky-600 bg-sky-50 px-2 py-1 rounded">' + event.type + '</span>'
            + '<h3 class="font-semibold text-lg mt-2 mb-1">' + event.title + '</h3>'
            + '<p class="text-sm text-gray-500"><svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>' + date + '</p>'
            + loc
            + '</div>'
            + '</div>'
            + '</a>';
    }'''

view = view.replace(old_render, new_render, 1)

# Update showKalender to also hide list
old_showkalender = '''    function showKalender(btn) {
        document.querySelectorAll('#agenda-tabs .tab-btn').forEach(function(b) {
            b.classList.remove('active', 'bg-sky-600', 'text-white', 'shadow-md');
            b.classList.add('bg-sky-100', 'text-gray-600', 'hover:bg-sky-200');
        });
        btn.classList.add('active', 'bg-sky-600', 'text-white', 'shadow-md');
        btn.classList.remove('bg-sky-100', 'text-gray-600', 'hover:bg-sky-200');

        document.getElementById('agenda-list').classList.add('hidden');
        document.getElementById('agenda-loading').classList.add('hidden');
        document.getElementById('agenda-empty').classList.add('hidden');
        document.getElementById('agenda-kalender').classList.remove('hidden');

        fetch('/api/agenda')
            .then(function(r) { return r.json(); })
            .then(function(json) {
                allEvents = json.data || [];
                renderKalender();
            });
    }'''

new_showkalender = '''    function showKalender(btn) {
        document.querySelectorAll('#agenda-tabs .tab-btn').forEach(function(b) {
            b.classList.remove('active', 'bg-sky-600', 'text-white', 'shadow-md');
            b.classList.add('bg-sky-100', 'text-gray-600', 'hover:bg-sky-200');
        });
        btn.classList.add('active', 'bg-sky-600', 'text-white', 'shadow-md');
        btn.classList.remove('bg-sky-100', 'text-gray-600', 'hover:bg-sky-200');

        document.getElementById('agenda-list').classList.add('hidden');
        document.getElementById('agenda-loading').classList.add('hidden');
        document.getElementById('agenda-empty').classList.add('hidden');
        document.getElementById('agenda-kalender').classList.remove('hidden');

        fetch('/api/agenda/source/semua')
            .then(function(r) { return r.json(); })
            .then(function(json) {
                allEvents = json.data || [];
                renderKalender();
            });
    }'''

view = view.replace(old_showkalender, new_showkalender, 1)

with open('/var/www/radio/resources/views/kbrbaik-agenda.blade.php', 'w') as f:
    f.write(view)

print("Done - API and view updated")

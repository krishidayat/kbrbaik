import re

with open('/var/www/radio/resources/views/kbrbaik-agenda.blade.php', 'r') as f:
    content = f.read()

# 1. Add Kalender tab at the end of the tab buttons
old_tabs_end = '''            @endforeach
        </div>'''

new_tabs_end = '''            @endforeach
            <button class="tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200 ml-auto"
                    data-type="kalender"
                    onclick="showKalender(this)">
                \U0001f4c5 Kalender
            </button>
        </div>'''

content = content.replace(old_tabs_end, new_tabs_end, 1)

# 2. Add calendar view after the empty state div
old_empty_end = '''    <div id="agenda-empty" class="text-center py-12 text-gray-400 hidden">
            Belum ada agenda di kategori ini.
        </div>
    </div>'''

new_empty_cal = '''    <div id="agenda-empty" class="text-center py-12 text-gray-400 hidden">
            Belum ada agenda di kategori ini.
        </div>
    </div>

    <div id="agenda-kalender" class="hidden max-w-6xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-sky-100 p-4 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <button onclick="prevMonth()" class="px-3 py-1 rounded-lg bg-sky-100 hover:bg-sky-200 text-sky-700 transition text-sm">&larr;</button>
                <h2 id="kalender-bulan" class="text-lg font-bold text-sky-900"></h2>
                <button onclick="nextMonth()" class="px-3 py-1 rounded-lg bg-sky-100 hover:bg-sky-200 text-sky-700 transition text-sm">&rarr;</button>
            </div>
            <div class="grid grid-cols-7 gap-px bg-sky-200 rounded-lg overflow-hidden text-center">
                <div class="bg-sky-50 p-2 text-xs font-semibold text-sky-700">Min</div>
                <div class="bg-sky-50 p-2 text-xs font-semibold text-sky-700">Sen</div>
                <div class="bg-sky-50 p-2 text-xs font-semibold text-sky-700">Sel</div>
                <div class="bg-sky-50 p-2 text-xs font-semibold text-sky-700">Rab</div>
                <div class="bg-sky-50 p-2 text-xs font-semibold text-sky-700">Kam</div>
                <div class="bg-sky-50 p-2 text-xs font-semibold text-sky-700">Jum</div>
                <div class="bg-sky-50 p-2 text-xs font-semibold text-sky-700">Sab</div>
            </div>
            <div id="kalender-grid" class="grid grid-cols-7 gap-px bg-sky-200"></div>
            <div id="kalender-events" class="mt-4 space-y-2"></div>
        </div>
    </div>'''

content = content.replace(old_empty_end, new_empty_cal, 1)

# 3. Update the script section - add calendar JS
old_script_end = '''    function renderAgendaCard(event) {
        var date = new Date(event.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
        var img = event.featured_image
            ? '<img src="' + event.featured_image + '" alt="' + event.title + '" class="w-full h-40 object-cover">'
            : '<div class="w-full h-40 bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-4xl">\U0001f4c5</div>';
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
    }
    </script>'''

new_script = '''    function renderAgendaCard(event) {
        var date = new Date(event.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
        var img = event.featured_image
            ? '<img src="' + event.featured_image + '" alt="' + event.title + '" class="w-full h-40 object-cover">'
            : '<div class="w-full h-40 bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-4xl">\U0001f4c5</div>';
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
    }

    var allEvents = [];
    var kalenderDate = new Date();
    kalenderDate.setDate(1);

    function showKalender(btn) {
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
    }

    function renderKalender() {
        var year = kalenderDate.getFullYear();
        var month = kalenderDate.getMonth();
        var bulan = document.getElementById('kalender-bulan');
        bulan.textContent = new Date(year, month).toLocaleDateString('id-ID', {month: 'long', year: 'numeric'});

        var firstDay = new Date(year, month, 1).getDay();
        var daysInMonth = new Date(year, month + 1, 0).getDate();

        var grid = document.getElementById('kalender-grid');
        grid.innerHTML = '';

        for (var i = 0; i < firstDay; i++) {
            var empty = document.createElement('div');
            empty.className = 'bg-white p-2 min-h-[60px] md:min-h-[80px]';
            grid.appendChild(empty);
        }

        for (var d = 1; d <= daysInMonth; d++) {
            var cell = document.createElement('div');
            cell.className = 'bg-white p-1 md:p-2 min-h-[60px] md:min-h-[80px] text-sm cursor-pointer hover:bg-sky-50 transition';
            var dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
            var dayEvents = allEvents.filter(function(e) {
                return e.event_date && e.event_date.startsWith(dateStr);
            });

            var num = document.createElement('div');
            num.className = 'font-semibold text-gray-700 text-xs md:text-sm';
            if (dayEvents.length > 0) num.className += ' text-sky-600';
            num.textContent = d;
            cell.appendChild(num);

            dayEvents.slice(0, 2).forEach(function(e) {
                var dot = document.createElement('div');
                dot.className = 'text-[10px] md:text-xs truncate text-sky-700 mt-0.5';
                dot.textContent = '\u2022 ' + e.title;
                cell.appendChild(dot);
            });

            if (dayEvents.length > 2) {
                var more = document.createElement('div');
                more.className = 'text-[10px] text-gray-400 mt-0.5';
                more.textContent = '+' + (dayEvents.length - 2) + ' lagi';
                cell.appendChild(more);
            }

            cell.onclick = function(evts) {
                return function() { showDayEvents(evts); };
            }(dayEvents);

            grid.appendChild(cell);
        }
    }

    function showDayEvents(events) {
        var container = document.getElementById('kalender-events');
        if (events.length === 0) {
            container.innerHTML = '<p class="text-gray-400 text-sm text-center py-4">Tidak ada agenda di tanggal ini.</p>';
            return;
        }
        var html = '<h3 class="font-semibold text-sky-900 mb-2">Agenda Hari Ini:</h3>';
        events.forEach(function(e) {
            var date = new Date(e.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
            html += '<a href="/agenda/' + e.slug + '" class="block bg-sky-50 rounded-lg p-3 hover:bg-sky-100 transition">'
                + '<span class="text-xs font-semibold text-sky-600">' + e.type + '</span>'
                + '<p class="font-medium text-sm text-gray-800">' + e.title + '</p>'
                + '<p class="text-xs text-gray-500">' + date + '</p>'
                + '</a>';
        });
        container.innerHTML = html;
    }

    function prevMonth() {
        kalenderDate.setMonth(kalenderDate.getMonth() - 1);
        renderKalender();
    }

    function nextMonth() {
        kalenderDate.setMonth(kalenderDate.getMonth() + 1);
        renderKalender();
    }
    </script>'''

content = content.replace(old_script_end, new_script, 1)

with open('/var/www/radio/resources/views/kbrbaik-agenda.blade.php', 'w') as f:
    f.write(content)

print("done")

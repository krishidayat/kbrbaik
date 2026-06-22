path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

old = """    <span class="panel-title">Scheduled Shows</span>
    <div style="display:flex;align-items:center;gap:6px">
      <span id="show-onair-badge" style="display:none" class="show-badge badge-live">ON AIR</span>
      <button class="btn" onclick="loadShows()">&#8634;</button>
    </div>"""

new = """    <span class="panel-title">Scheduled Shows</span>
    <div style="display:flex;align-items:center;gap:6px">
      <span id="show-onair-badge" style="display:none" class="show-badge badge-live">ON AIR</span>
      <a href="/manage/schedules/calendar" class="btn" title="Lihat semua jadwal harian">&#9776; Kalender</a>
      <button class="btn" onclick="loadShows()">&#8634;</button>
    </div>"""

content = content.replace(old, new)
open(path, 'w', encoding='utf-8').write(content)
print('Done')

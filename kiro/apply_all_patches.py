import re

path = r'D:\KbrBaik\web\resources\views\studio\dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# ===== PATCH: fix_btn.py =====
# Already applied

# ===== PATCH: fix_emoji.py (remaining) =====
# handles line 263, 563, 651 - done in previous edits
# Also remove any stray emojis in JS that we might have missed
content = content.replace('✕', 'X')
content = content.replace('✓', 'OK')

# ===== PATCH: patch_nowplaying.py =====
# 1. Add nowPlayingTitle var + update pollNowPlaying
old_poll = """function pollNowPlaying() {
  fetch('/manage/now-playing', {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r => r.json()).then(d => {
      document.getElementById('np-title').textContent = d.title || '\\u2014';
      document.getElementById('np-artist').textContent = d.artist || '';
      document.getElementById('np-listeners').textContent = (d.listeners || 0) + ' pendengar';
      const badge = document.getElementById('on-air-badge');
      badge.textContent = d.online ? 'ON AIR' : 'OFFLINE';
      badge.style.background = d.online ? '#d40000' : '#555';
    }).catch(()=>{});
}"""

new_poll = """let nowPlayingTitle = '';

function pollNowPlaying() {
  fetch('/manage/now-playing', {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r => r.json()).then(d => {
      document.getElementById('np-title').textContent = d.title || '';
      document.getElementById('np-artist').textContent = d.artist || '';
      document.getElementById('np-listeners').textContent = (d.listeners || 0) + ' pendengar';
      const badge = document.getElementById('on-air-badge');
      badge.textContent = d.online ? 'ON AIR' : 'OFFLINE';
      badge.style.background = d.online ? '#d40000' : '#555';
      const prev = nowPlayingTitle;
      nowPlayingTitle = (d.title || '').toLowerCase().trim();
      if (nowPlayingTitle !== prev) highlightNowPlaying();
    }).catch(()=>{});
}

function highlightNowPlaying() {
  document.querySelectorAll('.show-track-row').forEach(row => {
    const titleEl = row.querySelector('.t-title');
    if (!titleEl) return;
    const t = titleEl.textContent.toLowerCase().trim();
    const isNow = nowPlayingTitle && t === nowPlayingTitle;
    row.style.background = isNow ? 'rgba(249,114,2,.25)' : '';
    row.style.borderLeft = isNow ? '3px solid #f97202' : '3px solid transparent';
    let badge = row.querySelector('.now-badge');
    if (isNow && !badge) {
      badge = document.createElement('span');
      badge.className = 'now-badge';
      badge.style.cssText = 'font-size:9px;color:#f97202;font-weight:700;margin-left:4px;white-space:nowrap';
      badge.innerHTML = '&#9654; NOW';
      row.appendChild(badge);
    } else if (!isNow && badge) {
      badge.remove();
    }
  });
}"""

# Try matching with different quote variants
if old_poll in content:
    content = content.replace(old_poll, new_poll)
    print('patch_nowplaying: OK - matched version 1')
else:
    # Try simpler match
    old_simple = """function pollNowPlaying() {
  fetch('/manage/now-playing', {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r => r.json()).then(d => {
      document.getElementById('np-title').textContent = d.title || '';"""
    idx = content.find(old_simple)
    if idx >= 0:
        end_idx = content.find('}', idx) + 1
        end_idx = content.find('}', end_idx) + 1
        end_idx = content.find('}', end_idx) + 1
        whole_old = content[idx:end_idx]
        content = content[:idx] + new_poll + content[end_idx:]
        print('patch_nowplaying: OK - matched version 2')
    else:
        print('patch_nowplaying: SKIP - not found')

# 1b. CSS for show-track-row now playing
old_css_hl = '.show-track-row{border-left:3px solid transparent;transition:background .3s,border-left .3s}'
# Just add it if not present
if old_css_hl not in content:
    old_css_line = '.show-track-row{display:flex;align-items:center;padding:3px 8px 3px 22px;border-bottom:1px solid rgba(255,255,255,.04);font-size:10px}'
    if old_css_line in content:
        content = content.replace(old_css_line, old_css_line + '\n' + old_css_hl)
        print('patch_nowplaying: CSS added')
    else:
        print('patch_nowplaying: CSS SKIP - not found in content')

# 1c. Panggil highlightNowPlaying setelah renderShows
old_render_end = "  list.innerHTML = html || '<div class=\\"show-empty\\">Tidak ada jadwal</div>';\n  badge.style.display = hasActive ? 'inline-block' : 'none';\n}"
new_render_end = "  list.innerHTML = html || '<div class=\\"show-empty\\">Tidak ada jadwal</div>';\n  badge.style.display = hasActive ? 'inline-block' : 'none';\n  highlightNowPlaying();\n}"
if old_render_end in content:
    content = content.replace(old_render_end, new_render_end)
    print('patch_nowplaying: renderShows hook OK')
else:
    print('patch_nowplaying: renderShows hook SKIP')

# ===== PATCH: patch_drag.py =====
# 1. CSS - drag feedback + add-btn
old_css_drag = '.drop-zone{outline:2px dashed transparent;transition:outline .15s}\n.drop-zone.drag-over{outline:2px dashed #ff5d1a;background:rgba(255,93,26,.08)}'
new_css_drag = '''.drop-zone{outline:2px dashed transparent;transition:outline .15s}
.drop-zone.drag-over{outline:2px dashed #ff5d1a;background:rgba(255,93,26,.08)}
.row.dragging{opacity:.4;background:#555}
.row .add-btn{display:none;background:#005588;border:none;color:#88ddff;cursor:pointer;padding:1px 5px;border-radius:2px;font-size:10px;flex-shrink:0;margin-left:4px}
.row:hover .add-btn{display:inline-block}
.row .add-btn:hover{background:#0077aa}'''
if old_css_drag in content:
    content = content.replace(old_css_drag, new_css_drag)
    print('patch_drag: CSS OK')
else:
    print('patch_drag: CSS SKIP')

# 2. Update track row template
old_row_drag = """    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '\\u2014';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      onclick="selectTrack(${t.id})"
      ondblclick="addToActiveShow(${t.id})">
      <div class="row-icon">&#9835;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:100px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:55px;text-align:right">${dur}</div>
    </div>`;"""

new_row_drag = """    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '\\u2014';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      ondragend="this.classList.remove('dragging')"
      onclick="selectTrack(${t.id})"
      ondblclick="addToActiveShow(${t.id})"
      title="Drag ke show kanan, atau double-click untuk tambah ke show aktif">
      <div class="row-icon">&#9835;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:90px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:42px;text-align:right">${dur}</div>
      <button class="add-btn" onclick="event.stopPropagation();addToActiveShow(${t.id})" title="Tambah ke show aktif">+</button>
    </div>`;"""
if old_row_drag in content:
    content = content.replace(old_row_drag, new_row_drag)
    print('patch_drag: track row OK')
else:
    print('patch_drag: track row SKIP')

# 3. Update startDrag - add visual dragging class
old_start_drag = """function startDrag(ev, id, title, artist) {
  dragTrackId = id;
  dragTrackTitle = title;
  dragTrackArtist = artist;
  ev.dataTransfer.effectAllowed = 'copy';
  ev.dataTransfer.setData('text/plain', id);
}"""
new_start_drag = """function startDrag(ev, id, title, artist) {
  dragTrackId = id;
  dragTrackTitle = title;
  dragTrackArtist = artist;
  ev.dataTransfer.effectAllowed = 'copy';
  ev.dataTransfer.setData('text/plain', id);
  setTimeout(() => { const el = document.getElementById('tr-' + id); if (el) el.classList.add('dragging'); }, 0);
}"""
if old_start_drag in content:
    content = content.replace(old_start_drag, new_start_drag)
    print('patch_drag: startDrag OK')
else:
    print('patch_drag: startDrag SKIP')

# 4. Show-list dragover - highlight individual show-block
old_show_dragover = """function handleShowAreaDragover(ev) {
  ev.preventDefault();
  ev.dataTransfer.dropEffect = 'copy';
  ev.currentTarget.classList.add('drag-over');
}"""
new_show_dragover = """function handleShowAreaDragover(ev) {
  ev.preventDefault();
  ev.dataTransfer.dropEffect = 'copy';
  document.querySelectorAll('.show-block').forEach(b => b.classList.remove('drag-over'));
  const block = ev.target.closest('.show-block');
  if (block) block.classList.add('drag-over');
}"""
if old_show_dragover in content:
    content = content.replace(old_show_dragover, new_show_dragover)
    print('patch_drag: dragover OK')
else:
    print('patch_drag: dragover SKIP')

# ===== PATCH: patch_trackrow.py =====
# 1. Update show-track-row template with timestamps
old_track_rows = """    const trackRows = (s.tracks && s.tracks.length) ?
      s.tracks.map(t => `
        <div class="show-track-row">
          <span class="row-icon">&#9835;</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-dur muted">${t.duration ? fmtSec(t.duration) : ''}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#666;cursor:pointer;padding:0 4px;font-size:10px" title="Hapus">X</button>` : ''}
        </div>`) .join('') :
      '<div class="show-empty">Belum ada track</div>';"""

new_track_rows = """    // Kalkulasi start/end per track dari start_time show
    let cursor = timeToMin(s.start_time);
    const trackRows = (s.tracks && s.tracks.length) ?
      s.tracks.map(t => {
        const tStart = minToTime(cursor);
        const dur = t.duration || 0;
        cursor += Math.ceil(dur / 60);
        const tEnd = minToTime(cursor);
        return `<div class="show-track-row">
          <span class="t-time">${tStart}</span>
          <span class="t-time muted">${tEnd}</span>
          <span class="t-dur muted">${dur ? fmtSec(dur) : '--:--'}</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-album muted">${escHtml(t.album||'')}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#555;cursor:pointer;padding:0 4px;font-size:10px" title="Hapus">&#x2715;</button>` : ''}
        </div>`;
      }).join('') :
      '<div class="show-empty">Belum ada track</div>';"""

if old_track_rows in content:
    content = content.replace(old_track_rows, new_track_rows)
    print('patch_trackrow: track rows OK')
else:
    print('patch_trackrow: track rows SKIP')

# 2. Add CSS for new columns
old_css_track = '.show-track-row .t-title{flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}'
new_css_track = """.show-track-row .t-time{width:38px;font-size:10px;color:#aaa;flex-shrink:0;font-variant-numeric:tabular-nums}
.show-track-row .t-dur{width:38px;text-align:right;flex-shrink:0;font-variant-numeric:tabular-nums}
.show-track-row .t-title{flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0 6px}
.show-track-row .t-album{width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:10px;color:#666}"""
if old_css_track in content:
    content = content.replace(old_css_track, new_css_track)
    print('patch_trackrow: CSS OK')
else:
    print('patch_trackrow: CSS SKIP')

# 3. Add minToTime helper
old_helper = """function timeToMin(t) {
  if (!t) return 0;
  const [h, m] = t.split(':').map(Number);
  return h * 60 + (m || 0);
}"""
new_helper = old_helper + """

function minToTime(m) {
  const h = Math.floor(m / 60) % 24;
  const min = Math.floor(m % 60);
  return String(h).padStart(2,'0') + ':' + String(min).padStart(2,'0');
}"""
if old_helper in content:
    content = content.replace(old_helper, new_helper)
    print('patch_trackrow: minToTime OK')
else:
    print('patch_trackrow: minToTime SKIP')

# ===== PATCH: patch_libretime.py =====
# 1. Replace CSS show-track-row block
old_lib_css = """.show-track-row{display:flex;align-items:center;padding:3px 8px 3px 22px;border-bottom:1px solid rgba(255,255,255,.04);font-size:10px}
.show-track-row{border-left:3px solid transparent;transition:background .3s,border-left .3s}
.show-track-row:hover{background:rgba(255,255,255,.04)}
.show-track-row .t-time{width:38px;font-size:10px;color:#aaa;flex-shrink:0;font-variant-numeric:tabular-nums}
.show-track-row .t-dur{width:38px;text-align:right;flex-shrink:0;font-variant-numeric:tabular-nums}
.show-track-row .t-title{flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0 6px}
.show-track-row .t-album{width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:10px;color:#666}
.show-track-row .t-dur{color:#777;white-space:nowrap;margin-left:6px}"""

new_lib_css = """.show-track-row{display:flex;align-items:center;padding:4px 6px;border-bottom:1px solid rgba(255,255,255,.05);font-size:11px;gap:4px;transition:background .2s}
.show-track-row:hover{background:rgba(255,255,255,.06)}
.show-track-row.now-playing{background:#00aacc;color:#000 !important}
.show-track-row.now-playing .t-time,.show-track-row.now-playing .t-dur,.show-track-row.now-playing .t-artist,.show-track-row.now-playing .t-album{color:#005566 !important}
.show-track-row .t-icon{width:14px;flex-shrink:0;color:#666;text-align:center}
.show-track-row.now-playing .t-icon{color:#003344}
.show-track-row .t-time{width:42px;flex-shrink:0;color:#aaa;font-variant-numeric:tabular-nums;font-size:10px}
.show-track-row .t-dur{width:36px;flex-shrink:0;color:#777;font-variant-numeric:tabular-nums;font-size:10px;text-align:right}
.show-track-row .t-title{flex:2;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.show-track-row .t-artist{flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#aaa;font-size:10px}
.show-track-row .t-album{flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#666;font-size:10px}"""

if old_lib_css in content:
    content = content.replace(old_lib_css, new_lib_css)
    print('patch_libretime: CSS OK')
else:
    print('patch_libretime: CSS SKIP')

# 2. Update show-track-row template
old_lib_row = """        return `<div class="show-track-row">
          <span class="t-time">${tStart}</span>
          <span class="t-time muted">${tEnd}</span>
          <span class="t-dur muted">${dur ? fmtSec(dur) : '--:--'}</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-album muted">${escHtml(t.album||'')}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#555;cursor:pointer;padding:0 4px;font-size:10px" title="Hapus">&#x2715;</button>` : ''}
        </div>`;"""

new_lib_row = """        return `<div class="show-track-row" data-title="${escHtml(t.title.toLowerCase())}">
          <span class="t-icon">&#9836;</span>
          <span class="t-time">${tStart}</span>
          <span class="t-time">${tEnd}</span>
          <span class="t-dur">${dur ? fmtSec(dur) : '--:--'}</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-artist">${escHtml(t.artist||'')}</span>
          <span class="t-album">${escHtml(t.album||'')}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#555;cursor:pointer;padding:0 2px;font-size:10px;flex-shrink:0" title="Hapus">&#x2715;</button>` : ''}
        </div>`;"""

if old_lib_row in content:
    content = content.replace(old_lib_row, new_lib_row)
    print('patch_libretime: row template OK')
else:
    print('patch_libretime: row template SKIP')

# 3. Fix highlightNowPlaying
old_lib_hl = """  document.querySelectorAll('.show-track-row').forEach(row => {
    const titleEl = row.querySelector('.t-title');
    if (!titleEl) return;
    const t = titleEl.textContent.toLowerCase().trim();
    const isNow = nowPlayingTitle && t === nowPlayingTitle;
    row.style.background = isNow ? 'rgba(249,114,2,.25)' : '';
    row.style.borderLeft = isNow ? '3px solid #f97202' : '3px solid transparent';
    let badge = row.querySelector('.now-badge');
    if (isNow && !badge) {
      badge = document.createElement('span');
      badge.className = 'now-badge';
      badge.style.cssText = 'font-size:9px;color:#f97202;font-weight:700;margin-left:4px;white-space:nowrap';
      badge.innerHTML = '&#9654; NOW';
      row.appendChild(badge);
    } else if (!isNow && badge) {
      badge.remove();
    }
  });"""

new_lib_hl = """  document.querySelectorAll('.show-track-row').forEach(row => {
    const t = (row.dataset.title || '').trim();
    const isNow = nowPlayingTitle && nowPlayingTitle.length > 3 &&
      (t.includes(nowPlayingTitle) || nowPlayingTitle.includes(t));
    row.classList.toggle('now-playing', isNow);
    const icon = row.querySelector('.t-icon');
    if (icon) icon.innerHTML = isNow ? '&#9654;' : '&#9836;';
  });"""

if old_lib_hl in content:
    content = content.replace(old_lib_hl, new_lib_hl)
    print('patch_libretime: highlight OK')
else:
    print('patch_libretime: highlight SKIP')

# ===== PATCH: patch_blade2.py =====
# 1. Add badge-soon CSS
old_badge_css = '.badge-next{background:#555;color:#ddd}'
new_badge_css = old_badge_css + '\n.badge-soon{background:#996600;color:#ffdd88}'
if old_badge_css in content:
    content = content.replace(old_badge_css, new_badge_css)
    print('patch_blade2: CSS OK')
else:
    print('patch_blade2: CSS SKIP')

# 2. Update renderShows - add is_upcoming
old_render_show = """    const isActive = s.is_active || (nowMin >= startMin && nowMin < endMin);
    const isNext = !isActive && startMin > nowMin;"""
new_render_show = """    const isActive = s.is_active || (nowMin >= startMin && nowMin < endMin);
    const isUpcoming = s.is_upcoming || (!isActive && (startMin - nowMin) <= 15 && (startMin - nowMin) > 0);
    const isNext = !isActive && !isUpcoming && startMin > nowMin;"""
if old_render_show in content:
    content = content.replace(old_render_show, new_render_show)
    print('patch_blade2: isUpcoming OK')
else:
    print('patch_blade2: isUpcoming SKIP')

# 3. Add SOON badge
old_badges = """        ${isActive ? '<span class="show-badge badge-live">LIVE</span>' : ''}
        ${isNext && !isActive ? '<span class="show-badge badge-next">NEXT</span>' : ''}"""
new_badges = """        ${isActive ? '<span class="show-badge badge-live">LIVE</span>' : ''}
        ${isUpcoming ? '<span class="show-badge badge-soon">T-15</span>' : ''}
        ${isNext ? '<span class="show-badge badge-next">NEXT</span>' : ''}"""
if old_badges in content:
    content = content.replace(old_badges, new_badges)
    print('patch_blade2: badges OK')
else:
    print('patch_blade2: badges SKIP')

# 4. Auto-expand show aktif + upcoming
old_open_class = 'class="show-tracks${isActive ? \' open\' : \'\'}"'
new_open_class = 'class="show-tracks${(isActive || isUpcoming) ? \' open\' : \'\'}"'
if old_open_class in content:
    content = content.replace(old_open_class, new_open_class)
    print('patch_blade2: open class OK')
else:
    print('patch_blade2: open class SKIP')

# 5. Fix highlight - pakai includes()
old_highlight_match = """    const t = titleEl.textContent.toLowerCase().trim();
    const isNow = nowPlayingTitle && t === nowPlayingTitle;"""
new_highlight_match = """    const t = titleEl.textContent.toLowerCase().trim();
    const isNow = nowPlayingTitle && nowPlayingTitle.length > 3 && (t.includes(nowPlayingTitle) || nowPlayingTitle.includes(t));"""
if old_highlight_match in content:
    content = content.replace(old_highlight_match, new_highlight_match)
    print('patch_blade2: highlight match OK')
else:
    print('patch_blade2: highlight match SKIP')

# ===== PATCH: patch_filter.py =====
old_filter = """  const html = data.map(s => {"""
new_filter = """  // Hanya tampilkan show aktif + T-15 (upcoming dalam 15 menit)
  const visible = data.filter(s => {
    const startMin = timeToMin(s.start_time);
    const endMin = timeToMin(s.end_time);
    const isActive = s.is_active || (nowMin >= startMin && nowMin < endMin);
    const isUpcoming = s.is_upcoming || (!isActive && (startMin - nowMin) <= 15 && (startMin - nowMin) > 0);
    return isActive || isUpcoming;
  });

  const html = visible.map(s => {"""
if old_filter in content:
    content = content.replace(old_filter, new_filter)
    print('patch_filter: filter OK')
else:
    print('patch_filter: filter SKIP')

old_empty_msg = "  list.innerHTML = html || '<div class=\\"show-empty\\">Tidak ada jadwal</div>';"
new_empty_msg = "  list.innerHTML = visible.length ? html : '<div class=\\"show-empty\\">Tidak ada show aktif saat ini</div>';"
if old_empty_msg in content:
    content = content.replace(old_empty_msg, new_empty_msg)
    print('patch_filter: empty msg OK')
else:
    # Try variant without visible
    print('patch_filter: empty msg SKIP')

# ===== PATCH: patch_cal_link.py =====
old_cal = """    <span class="panel-title">Scheduled Shows</span>
    <div style="display:flex;align-items:center;gap:6px">
      <span id="show-onair-badge" style="display:none" class="show-badge badge-live">ON AIR</span>
      <button class="btn" onclick="loadShows()">&#8634;</button>
    </div>"""
new_cal = """    <span class="panel-title">Scheduled Shows</span>
    <div style="display:flex;align-items:center;gap:6px">
      <span id="show-onair-badge" style="display:none" class="show-badge badge-live">ON AIR</span>
      <a href="/manage/schedules/calendar" class="btn" title="Lihat semua jadwal harian">cal Kalender</a>
      <button class="btn" onclick="loadShows()">&#8634;</button>
    </div>"""
if old_cal in content:
    content = content.replace(old_cal, new_cal)
    print('patch_cal_link: OK')
else:
    print('patch_cal_link: SKIP')

# ===== PATCH: patch_autoswitch2.py =====
if 'lastActiveShow' not in content:
    autoswitch = """
// Auto-reload shows setiap 30 detik — deteksi pergantian show
let lastActiveShow = null;
setInterval(function() {
  var now = new Date();
  var curMin = now.getHours() * 60 + now.getMinutes();
  var active = showsData.find(function(s) {
    var st = timeToMin(s.start_time), en = timeToMin(s.end_time);
    return curMin >= st && curMin < en;
  });
  var activeName = active ? active.name : null;
  if (activeName !== lastActiveShow) {
    lastActiveShow = activeName;
    loadShows();
  }
}, 30000);
"""
    idx = content.rfind('</script>')
    content = content[:idx] + autoswitch + content[idx:]
    print('patch_autoswitch2: OK')
else:
    print('patch_autoswitch2: SKIP - already present')

# ===== PATCH: patch_checkbox.py =====
# 1. CSS checkbox dan selected state
old_check_css = '.row.selected{background:rgba(255,93,26,.25)}'
new_check_css = '''.row.selected{background:rgba(255,93,26,.2)}
.row input[type=checkbox]{accent-color:#ff5d1a;cursor:pointer;flex-shrink:0;width:13px;height:13px}
#selected-count{font-size:10px;color:#aaa;padding:0 4px}'''
if old_check_css in content:
    content = content.replace(old_check_css, new_check_css)
    print('patch_checkbox: CSS OK')
else:
    print('patch_checkbox: CSS SKIP')

# 2. Checkbox select-all di tbl-head
old_check_thead = '''  <div class="tbl-head">
    <div style="width:16px"></div>
    <div style="flex:1">Judul</div>
    <div style="width:100px">Artis</div>
    <div style="width:55px;text-align:right">Durasi</div>
  </div>'''
new_check_thead = '''  <div class="tbl-head">
    <div style="width:20px"><input type="checkbox" id="chk-all" onclick="toggleAllChecks(this)" title="Pilih semua"></div>
    <div style="flex:1">Judul</div>
    <div style="width:90px">Artis</div>
    <div style="width:42px;text-align:right">Durasi</div>
  </div>'''
if old_check_thead in content:
    content = content.replace(old_check_thead, new_check_thead)
    print('patch_checkbox: thead OK')
else:
    print('patch_checkbox: thead SKIP')

# 3. Toolbar - tambah btn-add-selected
old_check_toolbar = '''    <button class="btn btn-primary" onclick="openUpload()">&#8679; Upload</button>
    <button class="btn" onclick="loadTracks()">&#8634; Refresh</button>
    <button class="btn btn-danger" id="btn-delete-track" onclick="deleteSelectedTrack()" style="display:none">&#128465; Hapus</button>'''
new_check_toolbar = '''    <button class="btn btn-primary" onclick="openUpload()">&#8679; Upload</button>
    <button class="btn" onclick="loadTracks()">&#8634;</button>
    <button class="btn btn-primary" id="btn-add-selected" onclick="addSelectedToShow()" style="display:none" title="Tambah yang dicentang ke show aktif">+ Tambah ke Show</button>
    <span id="selected-count"></span>
    <button class="btn btn-danger" id="btn-delete-track" onclick="deleteSelectedTrack()" style="display:none">&#128465;</button>'''
if old_check_toolbar in content:
    content = content.replace(old_check_toolbar, new_check_toolbar)
    print('patch_checkbox: toolbar OK')
else:
    print('patch_checkbox: toolbar SKIP')

# 4. Update track row - ganti onclick selectTrack dengan checkbox
old_check_row = '''    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '\\u2014';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      ondragend="this.classList.remove('dragging')"
      onclick="selectTrack(${t.id})"
      ondblclick="addToActiveShow(${t.id})"
      title="Drag ke show kanan, atau double-click untuk tambah ke show aktif">
      <div class="row-icon">&#9835;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:90px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:42px;text-align:right">${dur}</div>
      <button class="add-btn" onclick="event.stopPropagation();addToActiveShow(${t.id})" title="Tambah ke show aktif">+</button>
    </div>`;'''

new_check_row = '''    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '\\u2014';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      ondragend="this.classList.remove('dragging')"
      ondblclick="addToActiveShow(${t.id})">
      <div style="width:20px;flex-shrink:0"><input type="checkbox" class="track-chk" value="${t.id}" onchange="onCheckChange()"></div>
      <div class="row-icon">&#9835;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:90px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:42px;text-align:right">${dur}</div>
    </div>`;'''

if old_check_row in content:
    content = content.replace(old_check_row, new_check_row)
    print('patch_checkbox: row OK')
else:
    print('patch_checkbox: row SKIP')

# 5. Tambah fungsi checkbox
old_select_fn = '''function selectTrack(id) {
  selectedTrackId = id;
  document.querySelectorAll('#track-list .row').forEach(r => r.classList.remove('selected'));
  const el = document.getElementById('tr-' + id);
  if (el) el.classList.add('selected');
  document.getElementById('btn-delete-track').style.display = 'inline-flex';
}'''
new_select_fn = '''function selectTrack(id) {
  selectedTrackId = id;
  document.getElementById('btn-delete-track').style.display = 'inline-flex';
}

function onCheckChange() {
  const checked = getCheckedIds();
  const n = checked.length;
  document.getElementById('selected-count').textContent = n ? n + ' dipilih' : '';
  document.getElementById('btn-add-selected').style.display = n ? 'inline-flex' : 'none';
  document.getElementById('btn-delete-track').style.display = n === 1 ? 'inline-flex' : 'none';
  if (n === 1) selectedTrackId = checked[0];
  document.querySelectorAll('.track-chk').forEach(chk => {
    document.getElementById('tr-' + chk.value)?.classList.toggle('selected', chk.checked);
  });
}

function getCheckedIds() {
  return [...document.querySelectorAll('.track-chk:checked')].map(c => parseInt(c.value));
}

function toggleAllChecks(master) {
  document.querySelectorAll('.track-chk').forEach(c => { c.checked = master.checked; });
  onCheckChange();
}

async function addSelectedToShow() {
  const ids = getCheckedIds();
  if (!ids.length) return;
  if (!activeShowId) { alert('Tidak ada show aktif.'); return; }
  for (const id of ids) {
    await fetch(`/manage/shows/${activeShowId}/tracks`, {
      method: 'POST',
      headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'},
      body: JSON.stringify({audio_track_id: id})
    });
  }
  document.querySelectorAll('.track-chk').forEach(c => c.checked = false);
  document.getElementById('chk-all').checked = false;
  onCheckChange();
  loadShows();
}'''
if old_select_fn in content:
    content = content.replace(old_select_fn, new_select_fn)
    print('patch_checkbox: checkbox functions OK')
else:
    print('patch_checkbox: checkbox functions SKIP')

# ===== PATCH: patch_row2.py =====
old_row2 = '''    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '\\u2014';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      ondragend="this.classList.remove('dragging')"
      ondblclick="addToActiveShow(${t.id})">
      <div style="width:20px;flex-shrink:0"><input type="checkbox" class="track-chk" value="${t.id}" onchange="onCheckChange()"></div>
      <div class="row-icon">&#9835;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:90px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:42px;text-align:right">${dur}</div>
    </div>`;'''

new_row2 = '''    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '\\u2014';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      ondragend="this.classList.remove('dragging')"
      ondblclick="addToActiveShow(${t.id})">
      <div style="width:20px;flex-shrink:0;padding-left:2px"><input type="checkbox" class="track-chk" value="${t.id}" onchange="onCheckChange()" onclick="event.stopPropagation()"></div>
      <div class="row-icon">&#9835;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:90px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:42px;text-align:right">${dur}</div>
    </div>`;'''

if old_row2 in content:
    content = content.replace(old_row2, new_row2)
    print('patch_row2: OK')
else:
    print('patch_row2: SKIP')

open(path, 'w', encoding='utf-8').write(content)
print('\nAll patches applied. File written.')

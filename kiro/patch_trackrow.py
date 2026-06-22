path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# 1. Update tracksJson API agar return album
# Patch renderShows - ganti template show-track-row
old_track_rows = """    const trackRows = (s.tracks && s.tracks.length) ?
      s.tracks.map(t => `
        <div class="show-track-row">
          <span class="row-icon">&#9654;</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-dur muted">${t.duration ? fmtSec(t.duration) : ''}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#666;cursor:pointer;padding:0 4px;font-size:10px" title="Hapus"></button>` : ''}
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

content = content.replace(old_track_rows, new_track_rows)

# 2. Tambah CSS untuk kolom baru
old_css = '.show-track-row .t-title{flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}'
new_css = """.show-track-row .t-time{width:38px;font-size:10px;color:#aaa;flex-shrink:0;font-variant-numeric:tabular-nums}
.show-track-row .t-dur{width:38px;text-align:right;flex-shrink:0;font-variant-numeric:tabular-nums}
.show-track-row .t-title{flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0 6px}
.show-track-row .t-album{width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:10px;color:#666}"""
content = content.replace(old_css, new_css)

# 3. Tambah helper minToTime
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
content = content.replace(old_helper, new_helper)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert 'minToTime' in content and 't-time' in content and 't-album' in content
print('OK')

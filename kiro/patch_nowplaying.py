path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# 1. Tambah variabel nowPlayingTitle dan update di pollNowPlaying
old_poll = """function pollNowPlaying() {
  fetch('/manage/now-playing', {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r => r.json()).then(d => {
      document.getElementById('np-title').textContent = d.title || '';
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
      // Update now playing highlight di show tracks
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
    // Tanda NOW PLAYING
    let badge = row.querySelector('.now-badge');
    if (isNow && !badge) {
      badge = document.createElement('span');
      badge.className = 'now-badge';
      badge.textContent = '&#9654; NOW';
      badge.style.cssText = 'font-size:9px;color:#f97202;font-weight:700;margin-left:4px;white-space:nowrap';
      badge.innerHTML = '&#9654; NOW';
      row.appendChild(badge);
    } else if (!isNow && badge) {
      badge.remove();
    }
  });
}"""

content = content.replace(old_poll, new_poll)

# 2. Tambah CSS untuk show-track-row now playing
old_css = '.show-track-row{display:flex;align-items:center;padding:3px 8px 3px 22px;border-bottom:1px solid rgba(255,255,255,.04);font-size:10px}'
new_css = old_css + '\n.show-track-row{border-left:3px solid transparent;transition:background .3s,border-left .3s}'

content = content.replace(old_css, new_css)

# 3. Panggil highlightNowPlaying setelah renderShows selesai (di akhir renderShows)
old_render_end = "  list.innerHTML = html || '<div class=\"show-empty\">Tidak ada jadwal</div>';\n  badge.style.display = hasActive ? 'inline-block' : 'none';\n}"
new_render_end = "  list.innerHTML = html || '<div class=\"show-empty\">Tidak ada jadwal</div>';\n  badge.style.display = hasActive ? 'inline-block' : 'none';\n  highlightNowPlaying();\n}"

content = content.replace(old_render_end, new_render_end)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
# Verify
if 'highlightNowPlaying' in content:
    print('highlightNowPlaying: OK')
if 'nowPlayingTitle' in content:
    print('nowPlayingTitle: OK')

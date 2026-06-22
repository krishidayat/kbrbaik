path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# 1. Replace semua CSS show-track-row sekaligus
old_css = """.show-track-row{display:flex;align-items:center;padding:3px 8px 3px 22px;border-bottom:1px solid rgba(255,255,255,.04);font-size:10px}
.show-track-row{border-left:3px solid transparent;transition:background .3s,border-left .3s}
.show-track-row:hover{background:rgba(255,255,255,.04)}
.show-track-row .t-time{width:38px;font-size:10px;color:#aaa;flex-shrink:0;font-variant-numeric:tabular-nums}
.show-track-row .t-dur{width:38px;text-align:right;flex-shrink:0;font-variant-numeric:tabular-nums}
.show-track-row .t-title{flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin:0 6px}
.show-track-row .t-album{width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:10px;color:#666}
.show-track-row .t-dur{color:#777;white-space:nowrap;margin-left:6px}"""

new_css = """.show-track-row{display:flex;align-items:center;padding:4px 6px;border-bottom:1px solid rgba(255,255,255,.05);font-size:11px;gap:4px;transition:background .2s}
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

content = content.replace(old_css, new_css)

# 2. Update template track row - tambah artis, icon speaker, class now-playing via data attr
old_row = """        return `<div class="show-track-row">
          <span class="t-time">${tStart}</span>
          <span class="t-time muted">${tEnd}</span>
          <span class="t-dur muted">${dur ? fmtSec(dur) : '--:--'}</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-album muted">${escHtml(t.album||'')}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#555;cursor:pointer;padding:0 4px;font-size:10px" title="Hapus">&#x2715;</button>` : ''}
        </div>`;"""

new_row = """        return `<div class="show-track-row" data-title="${escHtml(t.title.toLowerCase())}">
          <span class="t-icon">&#9836;</span>
          <span class="t-time">${tStart}</span>
          <span class="t-time">${tEnd}</span>
          <span class="t-dur">${dur ? fmtSec(dur) : '--:--'}</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-artist">${escHtml(t.artist||'')}</span>
          <span class="t-album">${escHtml(t.album||'')}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#555;cursor:pointer;padding:0 2px;font-size:10px;flex-shrink:0" title="Hapus">&#x2715;</button>` : ''}
        </div>`;"""

content = content.replace(old_row, new_row)

# 3. Fix highlightNowPlaying - pakai class now-playing + data-title
old_hl = """  document.querySelectorAll('.show-track-row').forEach(row => {
    const titleEl = row.querySelector('.t-title');
    if (!titleEl) return;
    const t = titleEl.textContent.toLowerCase().trim();
    const isNow = nowPlayingTitle && nowPlayingTitle.length > 3 && (t.includes(nowPlayingTitle) || nowPlayingTitle.includes(t));
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
  });"""

new_hl = """  document.querySelectorAll('.show-track-row').forEach(row => {
    const t = (row.dataset.title || '').trim();
    const isNow = nowPlayingTitle && nowPlayingTitle.length > 3 &&
      (t.includes(nowPlayingTitle) || nowPlayingTitle.includes(t));
    row.classList.toggle('now-playing', isNow);
    const icon = row.querySelector('.t-icon');
    if (icon) icon.innerHTML = isNow ? '&#9654;' : '&#9836;';
  });"""

content = content.replace(old_hl, new_hl)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert 'now-playing' in content and 't-artist' in content and 'data-title' in content
print('OK')

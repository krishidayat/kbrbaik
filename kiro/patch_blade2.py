path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# 1. Tambah CSS badge SOON
old_css = '.badge-next{background:#555;color:#ddd}'
new_css = old_css + '\n.badge-soon{background:#996600;color:#ffdd88}'
content = content.replace(old_css, new_css)

# 2. Update renderShows - tambah is_upcoming handling
old_render = """    const isActive = s.is_active || (nowMin >= startMin && nowMin < endMin);
    const isNext = !isActive && startMin > nowMin;"""

new_render = """    const isActive = s.is_active || (nowMin >= startMin && nowMin < endMin);
    const isUpcoming = s.is_upcoming || (!isActive && (startMin - nowMin) <= 15 && (startMin - nowMin) > 0);
    const isNext = !isActive && !isUpcoming && startMin > nowMin;"""

content = content.replace(old_render, new_render)

# 3. Tambah badge SOON dan auto-expand untuk upcoming
old_badges = """        ${isActive ? '<span class="show-badge badge-live">LIVE</span>' : ''}
        ${isNext && !isActive ? '<span class="show-badge badge-next">NEXT</span>' : ''}"""

new_badges = """        ${isActive ? '<span class="show-badge badge-live">LIVE</span>' : ''}
        ${isUpcoming ? '<span class="show-badge badge-soon">T-15</span>' : ''}
        ${isNext ? '<span class="show-badge badge-next">NEXT</span>' : ''}"""

content = content.replace(old_badges, new_badges)

# 4. Auto-expand show aktif DAN upcoming
old_open = 'class="show-tracks${isActive ? \' open\' : \'\'}"'
new_open = 'class="show-tracks${(isActive || isUpcoming) ? \' open\' : \'\'}"'
content = content.replace(old_open, new_open)

# 5. Fix highlight - pakai includes() bukan === untuk toleransi judul terpotong
old_highlight = "    const t = titleEl.textContent.toLowerCase().trim();\n    const isNow = nowPlayingTitle && t === nowPlayingTitle;"
new_highlight = "    const t = titleEl.textContent.toLowerCase().trim();\n    const isNow = nowPlayingTitle && nowPlayingTitle.length > 3 && (t.includes(nowPlayingTitle) || nowPlayingTitle.includes(t));"
content = content.replace(old_highlight, new_highlight)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert 'badge-soon' in content
assert 'isUpcoming' in content
assert 'includes(nowPlayingTitle)' in content
print('All patches OK')

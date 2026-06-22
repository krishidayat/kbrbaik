path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# Filter data sebelum render - hanya active + upcoming (T-15)
old = """  const html = data.map(s => {"""
new = """  // Hanya tampilkan show aktif + T-15 (upcoming dalam 15 menit)
  const visible = data.filter(s => {
    const startMin = timeToMin(s.start_time);
    const endMin = timeToMin(s.end_time);
    const isActive = s.is_active || (nowMin >= startMin && nowMin < endMin);
    const isUpcoming = s.is_upcoming || (!isActive && (startMin - nowMin) <= 15 && (startMin - nowMin) > 0);
    return isActive || isUpcoming;
  });

  const html = visible.map(s => {"""

content = content.replace(old, new)

# Ganti list.innerHTML pakai visible.length bukan data.length
old_empty = "  list.innerHTML = html || '<div class=\"show-empty\">Tidak ada jadwal</div>';"
new_empty = "  list.innerHTML = visible.length ? html : '<div class=\"show-empty\">Tidak ada show aktif saat ini</div>';"
content = content.replace(old_empty, new_empty)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert "visible.length" in content
print('OK')

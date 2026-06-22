path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# Tambah auto-switch logic setelah INIT
old_init = """// ── INIT ───────────────────────────────────────────
loadTracks();
loadShows();"""

new_init = """// ── INIT ───────────────────────────────────────────
loadTracks();
loadShows();

// Auto-reload shows setiap menit — deteksi pergantian show
let lastActiveShow = null;
setInterval(() => {
  const now = new Date();
  const curMin = now.getHours() * 60 + now.getMinutes();
  // Reload tepat di menit pergantian show (detik < 10)
  const atBoundary = now.getSeconds() < 10;
  const active = showsData.find(s => {
    const st = timeToMin(s.start_time), en = timeToMin(s.end_time);
    return curMin >= st && curMin < en;
  });
  const activeName = active ? active.name : null;
  if (activeName !== lastActiveShow || atBoundary) {
    if (activeName !== lastActiveShow) {
      lastActiveShow = activeName;
      loadShows();
    }
  }
}, 30000); // cek setiap 30 detik"""

content = content.replace(old_init, new_init)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert 'lastActiveShow' in content
print('OK')

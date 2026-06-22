path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# Cek apakah sudah ada
if 'lastActiveShow' in content:
    print('Already patched')
else:
    # Sisipkan sebelum </script> terakhir
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
    # Sisipkan sebelum </script> terakhir
    idx = content.rfind('</script>')
    content = content[:idx] + autoswitch + content[idx:]
    open(path, 'w', encoding='utf-8').write(content)
    print('Patched OK')

assert 'lastActiveShow' in content
print('Verified')

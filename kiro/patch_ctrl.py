path = '/var/www/radio/app/Http/Controllers/StudioController.php'
content = open(path, encoding='utf-8').read()

old = """                $isActive = $nowTime >= $start && $nowTime <= $end;"""

new = """                $isActive = $nowTime >= $start && $nowTime < $end;
                // T-15: show berikutnya pre-load jika mulai dalam 15 menit
                $nowMinutes = (int)substr($nowTime,0,2)*60 + (int)substr($nowTime,3,2);
                $startMinutes = (int)substr($start,0,2)*60 + (int)substr($start,3,2);
                $isUpcoming = !$isActive && ($startMinutes - $nowMinutes) <= 15 && ($startMinutes - $nowMinutes) > 0;"""

content = content.replace(old, new)

# Tambah is_upcoming ke return array
old_return = """                    'is_active'    => $isActive,
                    'tracks'       => $tracks,
                    'track_count'  => count($tracks),"""

new_return = """                    'is_active'    => $isActive,
                    'is_upcoming'  => $isUpcoming,
                    'tracks'       => $tracks,
                    'track_count'  => count($tracks),"""

content = content.replace(old_return, new_return)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert 'is_upcoming' in content
assert 'isUpcoming' in content
print('OK')

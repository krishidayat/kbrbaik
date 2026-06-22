import sqlite3
from datetime import datetime

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)

now = datetime.now()
print('VPS time:', now.strftime('%H:%M:%S %Z'))
nowTime = now.strftime('%H:%M')

rows = conn.execute("SELECT name,start_time,end_time FROM schedules WHERE station_id=1 AND is_active=1 ORDER BY start_time").fetchall()
print('\nAll schedules:')
for name, start, end in rows:
    s = start[:5]; e = end[:5]
    active = s <= nowTime < e
    print(f'  {s}-{e}  {name}  {"<== ACTIVE" if active else ""}')
conn.close()

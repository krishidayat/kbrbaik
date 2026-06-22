import sqlite3, subprocess, json

db = '/var/www/radio/database/database.sqlite'
base = '/var/www/radio/storage/app/public/'
conn = sqlite3.connect(db)

rows = conn.execute('SELECT id, file_path FROM audio_tracks WHERE duration IS NULL OR duration = 0').fetchall()
for id_, fpath in rows:
    full = base + fpath
    try:
        out = subprocess.check_output([
            'ffprobe', '-v', 'quiet', '-print_format', 'json',
            '-show_format', full
        ], stderr=subprocess.DEVNULL)
        data = json.loads(out)
        dur = float(data['format']['duration'])
        conn.execute('UPDATE audio_tracks SET duration=? WHERE id=?', (int(dur), id_))
        print(f'ID {id_}: {int(dur)}s')
    except Exception as e:
        print(f'ID {id_}: ERROR {e}')

conn.commit()
conn.close()
print('Done')

import sqlite3, re

db = '/var/www/radio/database/database.sqlite'
conn = sqlite3.connect(db)

rows = conn.execute('SELECT id, title FROM audio_tracks').fetchall()
for id_, title in rows:
    # Pattern: digit + â__ + digit  ->  digit-digit (verse range)
    fixed = re.sub(r'(\d+)[_â]+__(\d+)', r'\1-\2', title)
    # Cleanup leftover underscores used as separators
    fixed = re.sub(r'_+', '_', fixed)
    fixed = fixed.replace('_â_', '-').replace('â_', '').replace('â__', '-')
    if fixed != title:
        print(f'ID {id_}: {title!r}')
        print(f'      -> {fixed!r}')
        conn.execute('UPDATE audio_tracks SET title=? WHERE id=?', (fixed, id_))

conn.commit()
conn.close()
print('Done')

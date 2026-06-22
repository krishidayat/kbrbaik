path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
raw = open(path, 'rb').read()

# Detect encoding
for enc in ['utf-8', 'utf-8-sig', 'cp1252', 'latin-1']:
    try:
        content = raw.decode(enc)
        print(f'Decoded as: {enc}')
        break
    except:
        print(f'Not {enc}')
        continue

# Re-encode as clean UTF-8 without BOM
open(path, 'w', encoding='utf-8').write(content)
print('Written back as UTF-8')

# Verify
check = open(path, 'rb').read(20)
print('First bytes:', check[:6].hex())

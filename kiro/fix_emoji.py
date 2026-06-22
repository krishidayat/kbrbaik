path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# Replace emoji dengan teks/simbol aman
replacements = {
    '🏠': '&#8962;',
    '🎵': '&#9835;',
    '📋': '&#128203;',
    '⚡': '&#9889;',
    '📺': '&#128250;',
    '🎙': 'mic',
    '📅': 'cal',
    '▶': '&#9654;',
    '📡': 'ant',
    '🔁': '&#8635;',
    '⬆': '&#8679;',
    '⚙': '&#9881;',
    '🗑': '&#128465;',
    '↺': '&#8634;',
    '🔍': '&#128269;',
    '🔊': '&#128266;',
    '♫': '&#9835;',
    '▾': '&#9662;',
}

for emoji, entity in replacements.items():
    content = content.replace(emoji, entity)

open(path, 'w', encoding='utf-8').write(content)
print('Done - all emoji replaced with HTML entities')

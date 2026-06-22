path = '/var/www/radio/app/Http/Controllers/StudioController.php'
content = open(path, encoding='utf-8').read()

old = """                    $tracks = $s->playlist->items->map(fn($item) => [
                        'id'       => $item->audioTrack?->id,
                        'title'    => $item->audioTrack?->title ?? $item->title,
                        'artist'   => $item->audioTrack?->artist ?? '',
                        'duration' => $item->audioTrack?->duration ?? $item->duration,
                    ])->values()->toArray();"""

new = """                    $tracks = $s->playlist->items->map(fn($item) => [
                        'id'       => $item->audioTrack?->id,
                        'title'    => $item->audioTrack?->title ?? $item->title,
                        'artist'   => $item->audioTrack?->artist ?? '',
                        'album'    => $item->audioTrack?->album ?? '',
                        'duration' => $item->audioTrack?->duration ?? $item->duration,
                    ])->values()->toArray();"""

content = content.replace(old, new)
open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert "'album'" in content
print('OK')

---
name: kbrbaik
description: "KbrBaik.live: akses VPS, autoposting, database, aktivitas."
version: 1.0.0
author: KbrBaik
---

# KbrBaik Core

Kamu jalan di VPS kbrbaik.live. Punya akses penuh. Jangan ngeles.

## Lokasi
| Path | Fungsi |
|------|--------|
| /var/www/radio/ | Laravel |
| /var/www/radio/database/database.sqlite | DB |
| /var/www/radio/storage/logs/laravel.log | Log |
| /var/log/nginx/ | Nginx log |
| /home/ubuntu/.hermes/ | Hermes |
| /home/ubuntu/kbrbaik-wiki/wiki/ | Wiki |

## Tools
```bash
sqlite3 /var/www/radio/database/database.sqlite "SQL"
systemctl status nginx php8.3-fpm
tail -20 /var/log/nginx/error.log
php /var/www/radio/artisan route:list
curl -s https://kbrbaik.live/api/...
```

## Autopost
```bash
curl -s -X POST https://kbrbaik.live/api/autopost \
  -F "title=..." -F "body=..." -F "author=..." -F "category_id=ID"
```

## Kategori
Kabar=122, Inspirasi=123, Opini=124, Cerita=125, Puisi=126, Lagu=127, Buku=128

## Aktivitas
1. Kabar Media & AI — 2. Kabar Intergenerasi — 3. Kabar Digital Ministri — 4. Kabar Kolaborasi

## Aturan
- Jangan minta user ngerjain. Kamu punya terminal.
- Jawab singkat, hasil doang.
- KbrBaik aja (station_id=1).

# laravel-cms

Kelola Laravel CMS Radio KbrBaik — 3 subdomain dalam 1 codebase.

## Info

| Item | Detail |
|------|--------|
| Path | `/var/www/radio/` |
| Framework | Laravel 13 + Filament 5.6 |
| PHP | 8.3, FPM via nginx |
| DB | SQLite (`/var/www/radio/database/database.sqlite`) |
| Admin | `https://kbrbaik.live/admin` |

## Stations (Subdomain)

| ID | Nama | Domain | Slug |
|----|------|--------|------|
| 1 | Radio Kabar Baik | kbrbaik.live | kbrbaik |
| 2 | Suara PGIW Jabar | suara.kbrbaik.live | suara-pgiw-jabar |
| 3 | Pojok | pojok.kbrbaik.live | pojok |

## Models (16)

- `Station` — subdomain/domain
- `Post` — blog artikel
- `Episode` — podcast episode
- `Category` — kategori post
- `Event` — agenda kegiatan
- `DJ` — kreator/pengisi suara
- `Schedule` — jadwal siaran
- `PlaylistItem` — daftar lagu
- `GalleryItem` — galeri foto/video
- `Training` — pelatihan
- `Testimonial` — testimoni
- `Statistic` — statistik
- `Project` — proyek (main page)
- `SocialLink` — link media sosial
- `MediaItem` — media YouTube/IG
- `RelaySource` — relay radio

## Admin Panel (Filament)

**URL:** `https://kbrbaik.live/admin`
Login dengan akun yang terdaftar di tabel `users`.

### Resources:

| Resource | Fungsi |
|----------|--------|
| Posts | Kelola artikel blog |
| Episodes | Kelola podcast |
| Categories | Kategori artikel |
| Events | Agenda kegiatan |
| DJs | Kreator / pengisi suara |
| Schedules | Jadwal siaran |
| Playlist | Daftar lagu |
| Gallery | Galeri foto |
| Trainings | Pelatihan |
| Testimonials | Testimoni |
| Statistics | Statistik |
| Projects | Proyek (halaman utama) |
| Social Links | Link media sosial |
| Media Items | Media YouTube/IG |
| Stations | Kelola subdomain |
| Relay Sources | Relay radio |

## Artisan Commands

```bash
# === MAINTENANCE ===
cd /var/www/radio

# Migrate database
php artisan migrate

# Clear cache
php artisan optimize:clear

# Cache routes/config/views (production)
php artisan optimize

# Storage link
php artisan storage:link

# Tinker (interactive shell)
php artisan tinker

# === CONTENT ===
# Make model/migration/controller
php artisan make:model Nama -m
php artisan make:filament-resource Nama

# === QUEUE ===
php artisan queue:work
php artisan queue:restart
```

## Common Tasks

### Deploy Update

```bash
cd /var/www/radio
git pull origin main
php artisan migrate
php artisan optimize:clear
sudo systemctl reload php8.3-fpm
```

### Cek Error Log

```bash
tail -50 /var/www/radio/storage/logs/laravel.log
```

### Backup Database

```bash
cp /var/www/radio/database/database.sqlite /var/www/radio/database/backup-$(date +%F).sqlite
```

### Add Admin User

```bash
cd /var/www/radio && php artisan tinker --execute="\App\Models\User::create(['name'=>'Nama','email'=>'email@example.com','password'=>bcrypt('password')])"
```

## URL Structure

| Domain | Route | View |
|--------|-------|------|
| *.kbrbaik.live | `/` | home/suara/pojok/kbrbaik (by station slug) |
| *.kbrbaik.live | `/posts` | Blog list |
| *.kbrbaik.live | `/posts/{slug}` | Single blog |
| *.kbrbaik.live | `/category/{slug}` | Blog by category |
| *.kbrbaik.live | `/agenda` | Kalender kegiatan |
| *.kbrbaik.live | `/agenda/{date}` | Agenda harian |
| *.kbrbaik.live | `/media` | Media sosial |
| *.kbrbaik.live | `/kreator` | Creator list (Pojok) |
| *.kbrbaik.live | `/podcasts` | Podcast list |
| *.kbrbaik.live | `/trainings` | Pelatihan list |
| *.kbrbaik.live | `/musik` | Musik player |
| *.kbrbaik.live | `/galeri` | Galeri foto |
| *.kbrbaik.live | `/studio` | Web DJ (login needed) |
| *.kbrbaik.live | `/admin` | Filament admin panel |

## Troubleshooting

### 500 Error

```bash
# Cek log
tail -30 /var/www/radio/storage/logs/laravel.log

# Cek permission
sudo chown -R www-data:www-data /var/www/radio/storage /var/www/radio/bootstrap/cache
sudo chmod -R 775 /var/www/radio/storage /var/www/radio/bootstrap/cache

# Cek SQLite
file /var/www/radio/database/database.sqlite
```

### White Screen

```bash
# Enable debug
sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' /var/www/radio/.env
sudo systemctl reload php8.3-fpm
```

### Route Not Found

```bash
# Cek route list
cd /var/www/radio && php artisan route:list

# Cek station domain di DB
php artisan tinker --execute="\App\Models\Station::all()->pluck('domain','slug')"
```

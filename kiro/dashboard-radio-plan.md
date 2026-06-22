# Perencanaan Dashboard Radio v2 — Libretime-style
**Tanggal:** 22 Juni 2026  
**Target:** `studio.kbrbaik.live/manage`  
**Referensi:** Libretime 4.5.0 @ `ubuntu@radio.tanganterbukamedia.com`

---

## Latar Belakang

Dashboard lama (`dashboard.blade.php`) bermasalah karena:
- Global CSS override di `layout.blade.php` merusak Tailwind classes
- Banyak dead code dan endpoint yang tidak konsisten
- Modal upload stuck karena konflik `display:flex` vs class `hidden`

**Keputusan:** Buat ulang dari nol sebagai standalone blade — tidak extend layout lama.

---

## Color Palette (dari Libretime 4.5.0)

| Elemen | Warna |
|---|---|
| Body background | `#242424` |
| Sidebar background | `#111` |
| Master panel (header) | `#3d3d3d` |
| Now-playing info block | `#3a3a3a` |
| Panel/card background | `#2d2d2d` |
| Border | `#444` / `#5b5b5b` |
| Text primary | `#efefef` |
| Text muted | `#c4c4c4`, `#9b9b9b` |
| Accent orange | `#ff5d1a` |
| Progress track | `#f97202` |
| Progress show | `#02cef9` |
| Progress error | `#d40000` |
| Highlight/select | `rgba(255,93,26,.6)` |

---

## Struktur Layout

```
┌─────────────────────────────────────────────────────────────────────────┐
│ MASTER PANEL (header)                                                   │
│ [Logo] [AlbumArt] [Prev/Cur/Next + dual progress bar] [ON AIR] [Clock] │
├──────────┬──────────────────────────┬──────────────────────────────────┤
│ SIDEBAR  │ PANEL KIRI               │ PANEL KANAN                      │
│ Upload   │ Dashboard - Tracks       │ Scheduled Shows    [✕] [ON AIR]  │
│ ──────── │ [search bar]             │ [date] [time] [date] [time] [🔍] │
│Dashboard │ [+New] [✏] [+] [🗑]      │ [Filter by Show ▾]               │
│Tracks    │ ──────────────────────── │ [Select▾][✂][🗑][→][🚫] [Col▾]  │
│Playlists │ ☐ 🎵 Title  Creator Type │ ────────────────────────────────  │
│SmartBlk  │ ☐ 🎵 ...                 │ ▼ 09:00 12:00 sapa-siang        │
│Shows     │ ☐ 🎵 ...                 │   ☐🔊 09:56 10:01 5:14 Track1   │
│Podcasts  │ ☐ 🎵 ...                 │   ☐🔊 10:01 10:05 3:07 Track2   │
│──────────│ [pagination]             │ ▶ 12:00 15:00 karya-hari-ini     │
│Calendar  │                          │ ▶ 15:00 18:00 cerita-senja [LIVE]│
│Rundown   │                          │ ▶ 18:00 21:00 tembang-mal [NEXT] │
│Webstream │                          │ ▶ 21:00 23:59 nada-doa           │
│Relay     │                          │                                  │
└──────────┴──────────────────────────┴──────────────────────────────────┘
```

---

## File yang Dibuat/Diubah

| File | Aksi | Keterangan |
|---|---|---|
| `resources/views/studio/dashboard_v2.blade.php` | Buat baru | Standalone, tidak extend layout lama |
| `routes/web.php` | Update | Ganti route `studio.dashboard` → view baru |
| `app/Http/Controllers/StudioController.php` | Tidak berubah | Semua method sudah ada |

---

## API Endpoints (sudah tersedia)

| Method | URL | Fungsi |
|---|---|---|
| GET | `/manage/tracks/json?search=&sort=title&page=1` | Track library paginated |
| GET | `/manage/schedules/today-with-tracks` | Shows hari ini + tracklist per show |
| GET | `/manage/now-playing` | Now playing dari Icecast (polling 5 detik) |
| POST | `/manage/tracks/upload` | AJAX upload audio file |
| POST | `/manage/shows/get-or-create` | Resolve/buat show dari schedule |
| POST | `/manage/shows/{id}/tracks` | Tambah track ke show |
| DELETE | `/manage/shows/{id}/tracks/{trackId}` | Hapus track dari show |
| POST | `/manage/switch-station` | Ganti station aktif |

---

## Fitur yang Diimplementasi

| Fitur | Detail |
|---|---|
| Now playing header | Track title/artist, elapsed, remaining, progress bar real-time |
| Dual progress bar | Oranye = track, biru = show progress |
| Prev / Next track | Ditampilkan di header |
| Track library | AJAX search, sort, pagination (25/50/100 per page) |
| Drag & drop | Track dari kiri → drop ke show aktif di kanan |
| Scheduled Shows | Expandable per show, auto-buka show aktif |
| Track timestamps | Start time, end time, durasi per track di dalam show |
| AJAX upload | Modal upload tanpa page reload, progress indicator |
| Station switcher | Dropdown di sidebar + header, multi-station |
| Auto-refresh | Now playing polling 5 detik |
| LIVE / NEXT badge | Show aktif dan show berikutnya ditandai |

## Fitur TIDAK Diimplementasi (scope nanti)

- Reorder tracks drag dalam show (sortable)
- Live DJ encoder panel
- Calendar view (sudah ada di `/manage/schedules`)
- Smart Blocks editor

---

## Catatan Teknis

- **Tidak pakai Tailwind** — pure CSS inline/embedded untuk hindari konflik global override
- **Tidak extend `studio.layout`** — standalone HTML lengkap dengan sidebar sendiri
- **Semua interaksi AJAX** — tidak ada form POST biasa yang menyebabkan page reload
- **CSS mengikuti Libretime** — color palette, font size, spacing sesuai referensi asli
- Panel kiri & kanan: `height: calc(100vh - 120px)` agar full height seperti Libretime

---

## Status

- [x] Perencanaan selesai
- [x] Referensi Libretime dipelajari (CSS, HTML, JS structure)
- [ ] Implementasi `dashboard_v2.blade.php`
- [ ] Update routing
- [ ] Testing di VPS

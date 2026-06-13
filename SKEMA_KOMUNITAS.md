# Skema Komunitas — KBRBaik

```
╔══════════════════════════════════════════════════════╗
║                    STATION                           ║
║              (kbrbaik.live / 1)                       ║
╚══════════════════════════════════════════════════════╝
                      │
                      │ 1
                      │
             ┌────────┴────────┐
             │                 │
             ▼                 ▼
   ┌─────────────────┐  ┌──────────────┐
   │   COMMUNITY     │  │   COMMUNITY  │  ...
   │  (Klasikal A)   │  │ (Klasikal B) │
   └────────┬────────┘  └──────────────┘
            │
            │ 1
            │
      ┌─────┴──────┐
      │            │
      ▼            ▼
┌──────────┐ ┌──────────┐
│  STUDIO  │ │  STUDIO  │  ... (banyak studio per komunitas)
│ "PELITA" │ │ "SUARA"  │
└────┬─────┘ └────┬─────┘
     │            │
     │ 1          │ 1
     │            │
     ▼            ▼
┌─────────────────────────────────────────────────────┐
│                 PRODUK MEDIA                         │
├─────────────────────────────────────────────────────┤
│                                                      │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────┐ │
│  │ PODCAST  │  │ YOUTUBE  │  │ SPOTIFY  │  │ LIVE │ │
│  │ (episode)│  │ (channel)│  │ (podcast)│  │ STREAM│ │
│  └──────────┘  └──────────┘  └──────────┘  └──────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
```

---

## Struktur Database

### `studios`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `community_id` | FK → communities | Induk Klasikal |
| `station_id` | FK → stations | Induk station |
| `name` | string | Nama Studio |
| `slug` | string unique | URL slug |
| `description` | text nullable | Deskripsi |
| `logo` | string nullable | Path logo |
| `location` | string nullable | Lokasi/daerah |
| `contact` | string nullable | Kontak |
| **`stream_url`** | string nullable | → Live Streaming |
| **`youtube_url`** | string nullable | → YouTube |
| **`spotify_url`** | string nullable | → Spotify |
| **`website_url`** | string nullable | → Website |
| `is_active` | boolean | Aktif/tidak |
| `timestamps` | | created_at, updated_at |

### `episodes` (Podcast)

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `studio_id` | FK → studios | **Producer** |
| `title` | string | Judul episode |
| `description` | text | Deskripsi |
| `audio_file` | string | File MP3 |
| `thumbnail` | string | Cover image |
| `duration` | integer | Durasi (detik) |
| `is_published` | boolean | |
| `published_at` | datetime | |

### Produk Media → URL fields langsung di `studios`

| Field | Platform | Tipe Output |
|-------|----------|-------------|
| `youtube_url` | YouTube | Link channel/video |
| `spotify_url` | Spotify | Link podcast/playlist |
| `stream_url` | Live Streaming | Link Icecast/AzuraCast |
| `website_url` | Website | Link profil eksternal |

---

## Relasi Entity

```
Community (1) ──< Studio (N) ──< Episode (N) [podcast]
                                  ── youtube_url   [YouTube]
                                  ── spotify_url   [Spotify]
                                  ── stream_url    [Live Streaming]
                                  ── website_url   [Website]
```

## Visual Flow (User Journey)

```
kbrbaik.live
    │
    ├── Beranda
    ├── Komunitas  ← daftar Klasikal
    │     │
    │     ├── Klasikal A  ← daftar Studio
    │     │     │
    │     │     ├── Studio "Pelita"
    │     │     │     ├── 🎙 Podcast (episode list)
    │     │     │     ├── 📺 YouTube (link)
    │     │     │     ├── 🎧 Spotify (link)
    │     │     │     └── 🔴 Live (link streaming)
    │     │     │
    │     │     └── Studio "Suara" ...
    │     │
    │     └── Klasikal B ...
    │
    ├── Agenda
    └── Layanan
```

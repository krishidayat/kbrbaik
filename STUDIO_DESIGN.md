# Studio KBRBaik — Rancangan Sistem & UI/UX
## studio.kbrbaik.live

---

## 1. Filosofi Desain

### Prinsip Utama
1. **Click-drop ala LibreTime** — drag & drop playlist, visual timeline, langsung terlihat hasilnya
2. **Awam-friendly** — tanpa jargon teknis, pakai ikon + bahasa Indonesia, tooltip di setiap tombol
3. **Station-isolated** — tiap stasiun punya bank lagu sendiri, tidak tercampur
4. **Siaran Bersama (Relay)** — 1x seminggu, semua stasiun menyiarkan relay dari stasiun induk

### Target User
| User | Kemampuan | Kebutuhan |
|------|-----------|-----------|
| **Operator Radio** | Bisa komputer dasar | Upload lagu, bikin playlist, lihat jadwal |
| **Penyiar (DJ)** | Bisa klik-play | Live broadcast, lihat antrian lagu |
| **Admin Jaringan** | Paham sistem | Kelola user & stasiun, atur relay |
| **Hermes (AI)** | Telegram bot | Perintah teks: "putar lagu X", "jadwal hari ini" |

---

## 2. Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────────────┐
│                        studio.kbrbaik.live                          │
│                          Nginx → Laravel                            │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐     │
│  │   PUBLIC AREA   │  │   STUDIO APP    │  │   ADMIN AREA    │     │
│  │  (no auth)      │  │  (auth: dj/op)  │  │  (auth: admin)  │     │
│  │                 │  │                 │  │                 │     │
│  │ • Home/Dashboard│  │ • Audio Library │  │ • User Manager  │     │
│  │ • Player        │  │ • Playlist DJ   │  │ • Station Mgmt  │     │
│  │ • Schedule View │  │ • Live Studio   │  │ • Relay Config  │     │
│  │ • Now Playing   │  │ • Schedule Grid │  │ • Hermes Config │     │
│  └─────────────────┘  └────────┬────────┘  └─────────────────┘     │
│                                │                                     │
│  ┌─────────────────────────────▼──────────────────────────────────┐ │
│  │                     DATABASE (PostgreSQL / MySQL)               │ │
│  │  stations │ users │ audio_tracks │ playlists │ schedule        │ │
│  │  relay_config │ shows │ playout_log │ hermes_commands          │ │
│  └────────────────────────────────────────────────────────────────┘ │
│                                │                                     │
│  ┌─────────────────────────────▼──────────────────────────────────┐ │
│  │                    LIBS (Service Layer)                         │ │
│  │  Liquidsoap API │ Icecast Admin │ LibreTime API │ Telegram API │ │
│  └────────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────────┘

        │                                                              
        ▼                                                              
┌─────────────────────────────────────────────────────────────────────┐
│                   INFRASTRUKTUR (VPS)                               │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐              │
│  │  LibreTime   │  │  Icecast     │  │  Hermes Bot  │              │
│  │  4.5 Docker  │  │  :8000       │  │  (Python)    │              │
│  │  Liquidsoap  │  │  /stream     │  │  Telegram    │              │
│  └──────────────┘  └──────────────┘  └──────────────┘              │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 3. Data Model

### 3.1 Stations (SUDAH ADA — perlu ditambah)
```
stations
├── id, name, slug, domain, stream_mount
├── is_active, is_relay_source (apakah ini sumber relay?)
├── relay_day (hari relay: 'monday' etc)
├── relay_time (jam relay: '20:00')
├── relay_duration (menit: 60)
├── timezone
├── stream_url, website_url
├── logo, description
└── created_at, updated_at
```

### 3.2 Users (SUDAH ADA — perlu ditambah role & station access)
```
users
├── id, name, email, password
├── role: 'superadmin' | 'admin' | 'operator' | 'dj' | 'user'
├── station_id (nullable — kalau khusus 1 stasiun)
├── phone, avatar, is_active
├── last_login_at
└── timestamps
```

### 3.3 Audio Tracks (BARU — bank lagu per stasiun)
```
audio_tracks
├── id
├── station_id (FK → stations) — ISOLASI: tiap stasiun punya bank sendiri
├── title, artist, album, genre
├── track_number, year
├── file_path (storage path)
├── file_size, duration (detik), duration_display (H:i:s)
├── mime_type ('audio/mpeg', dll)
├── bitrate, sample_rate, channels
├── cover_art_path
├── isrc_code, bpm, composer
├── license ('original' | 'royalty_free' | 'copyright')
├── lyrics (text)
├── tags (array/JSON)
├── play_count, last_played_at
├── is_active, sort_order
└── timestamps + soft_deletes
```

### 3.4 Playlists (SUDAH ADA — perlu refactor)
```
playlists
├── id
├── station_id (FK → stations)
├── name, period ('subuh'|'pagi'|'siang'|'sore'|'malam'|'custom')
├── description, is_active, sort_order
├── playlist_type: 'manual' | 'auto' | 'smart' (by aturan)
├── auto_rules (JSON — untuk smart playlist)
│   └── {genre: "Christian", min_bpm: 60, max_bpm: 120, recent_played: false}
├── total_duration (calculated)
├── color (untuk tampilan kalender)
└── timestamps
```

### 3.5 Playlist Items (SUDAH ADA — perlu tambahan)
```
playlist_items
├── id
├── playlist_id (FK → playlists)
├── station_id (FK → stations)
├── audio_track_id (FK → audio_tracks) — BARU: link ke bank lagu
├── title, artist
├── item_type: 'audio' | 'webstream' | 'podcast' | 'jingle' | 'ad' | 'relay'
├── audio_file (legacy — akan deprecated)
├── audio_file_path (BARU — consolidate)
├── webstream_url, podcast_url, podcast_rss
├── duration, duration_display
├── cover_url
├── fade_in, fade_out (detik)
├── cue_in, cue_out (detik — potong lagu)
├── is_active, sort_order
└── timestamps
```

### 3.6 Schedule / Shows (BARU)
```
schedules
├── id
├── station_id (FK → stations)
├── title (nama acara)
├── description
├── day_of_week (0=Sunday...6=Saturday) — atau specific date
├── specific_date (date, nullable — untuk acara khusus)
├── start_time (time), end_time (time)
├── playlist_id (FK → playlists, nullable)
├── show_type: 'playlist' | 'live_dj' | 'relay' | 'podcast' | 'automation'
├── relay_source_station_id (FK → stations, nullable — untuk relay)
├── dj_id (FK → users, nullable)
├── color (hex — tampilan kalender)
├── is_active, is_recurring
├── priority (untuk conflict resolution)
└── timestamps
```

### 3.7 Relay Network (BARU)
```
relay_configs
├── id
├── source_station_id (FK → stations — stasiun yang disiarkan)
├── target_station_id (FK → stations — penerima relay)
├── day_of_week (0-6)
├── start_time, end_time
├── is_active
├── auto_switch_back (bool — setelah relay, kembali ke AutoDJ)
├── switch_back_delay (menit)
└── timestamps

relay_logs
├── id
├── relay_config_id
├── source_station_id, target_station_id
├── started_at, ended_at
├── status: 'scheduled' | 'active' | 'completed' | 'failed'
├── error_message (nullable)
└── timestamps
```

### 3.8 Live Streams (BARU)
```
live_streams
├── id
├── station_id
├── dj_id (FK → users)
├── stream_url (input dari encoder DJ)
├── started_at, ended_at
├── status: 'idle' | 'preparing' | 'live' | 'ended'
├── listener_peak
├── recording_path (nullable — rekaman otomatis)
├── notes
└── timestamps
```

### 3.9 Playout Logs (BARU — history putar lagu)
```
playout_logs
├── id
├── station_id
├── audio_track_id (nullable)
├── schedule_id (nullable)
├── played_at
├── duration_played (berapa detik dimainkan)
├── source: 'autodj' | 'live' | 'relay' | 'manual'
├── listener_count_at_play
└── timestamps
```

### 3.10 Hermes Commands (BARU — log perintah Telegram)
```
hermes_commands
├── id
├── telegram_user_id, telegram_username
├── command (teks perintah)
├── intent (hasil parsing AI)
├── parameters (JSON)
├── status: 'received' | 'processing' | 'completed' | 'failed'
├── response_text
├── processed_at
└── timestamps
```

---

## 4. UI/UX Design — Gambaran Layout

### 4.1 Warna & Tema
```
Primary:   #0F172A (slate-900) — navbar, sidebar
Secondary: #1E40AF (blue-800) — tombol aksi
Accent:    #3B82F6 (blue-500) — hover, active states
Success:   #10B981 (emerald-500) — online, active
Warning:   #F59E0B (amber-500) — pending
Danger:    #EF4444 (red-500) — offline, error

Background: #F1F5F9 (slate-100)
Card:       #FFFFFF
Text:       #0F172A (slate-900), #64748B (slate-500) untuk secondary
```

### 4.2 Layout Utama (Desktop 1440px)

```
┌─────────────────────────────────────────────────────────────────────┐
│ TOPBAR: Logo KBRBaik | Nama Stasiun ▼ | [🔴 LIVE] | Status | 👤   │
├──────────┬──────────────────────────────────────────────────────────┤
│          │                                                          │
│ SIDEBAR  │   ┌──────────────────────────────────────────────────┐  │
│          │   │  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ │  │
│ 🏠 Home  │   │  │LAGU  │ │PUTAR │ │JADWAL│ │SIARAN│ │RELAY │ │  │
│          │   │  │      │ │      │ │      │ │      │ │      │ │  │
│ 📁 Lagu  │   │  └──────┘ └──────┘ └──────┘ └──────┘ └──────┘ │  │
│          │   │                                                 │  │
│ 📋 Putar │   │  ┌─────────────────────────────────────────┐    │  │
│          │   │  │  SEARCH: [🔍 cari lagu...]  [+ Upload] │    │  │
│ 📅 Jadwal│   │  └─────────────────────────────────────────┘    │  │
│          │   │                                                 │  │
│ 🔴 Siaran│   │  ┌──────┬────────┬──────┬──────┬───────────┐   │  │
│          │   │  │ #    │ JUDUL  │ ARTIS│ DUR  │ SERET 🖐  │   │  │
│ 🔁 Relay │   │  ├──────┼────────┼──────┼──────┼───────────┤   │  │
│          │   │  │  1   │ Song A │ Artis│ 4:20 │ ⠿⠿⠿⠿⠿   │   │  │
│ 🤖 Hermes│   │  │  2   │ Song B │ Artis│ 3:15 │ ⠿⠿⠿⠿⠿   │   │  │
│          │   │  │  3   │ Song C │ Artis│ 5:00 │ ⠿⠿⠿⠿⠿   │   │  │
│ ⚙️ Set   │   │  └──────┴────────┴──────┴──────┴───────────┘   │  │
│          │   │                                                 │  │
│          │   │  [📥 Import dari Bank Lagu]                     │  │
│          │   │                                                 │  │
│          │   │  ┌──────────────────────────────────────────┐   │  │
│          │   │  │ NOW PLAYING: Song X — Artis Y            │   │  │
│          │   │  │ ────────●───────────────────────  0:20   │   │  │
│          │   │  │ ⏮  ⏸  ⏭  🔊 ████████░░ 70%            │   │  │
│          │   │  └──────────────────────────────────────────┘   │  │
└──────────┴──────────────────────────────────────────────────────┘
```

### 4.3 Layout Mobile (< 768px)

```
┌────────────────────┐
│ 🔴 KBRBaik  ≡ Menu│  ← Topbar compact
├────────────────────┤
│                    │
│ [🏠] [📁] [📋] [📅]│  ← Bottom tab bar
│                    │
│ ┌────────────────┐ │
│ │ 🔍 Cari...   + │ │
│ └────────────────┘ │
│                    │
│ ⬤ Song A          │
│   Artis Y • 4:20  │  ← Swipe to reorder
│ ⬤ Song B          │
│   Artis Z • 3:15  │
│ ⬤ Song C          │
│   Artis X • 5:00  │
│                    │
├────────────────────┤
│ ▶ Song X — Artis Y │  ← Mini player (sticky)
│ ────────●── 0:20   │
└────────────────────┘
```

### 4.4 Halaman Detail

#### A. Dashboard (Home)
```
┌─────────────────────────────────────────────────────────────┐
│ 🏠 DASHBOARD              [Refresh]      [Hari ini: Rabu]  │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐        │
│ │ 🎵 1,234 │ │ ▶️ 89    │ │ 📅 12    │ │ 🔴 LIVE  │        │
│ │   Lagu   │ │ Sedang   │ │ Acara    │ │         │        │
│ │          │ │ Putar    │ │ Hari Ini │ │          │        │
│ └──────────┘ └──────────┘ └──────────┘ └──────────┘        │
│                                                             │
│ ┌─ SEKARANG ───────────────────────────────────────────┐   │
│ │ 🎵 Malam Kudus — Kidung Jemaat                       │   │
│ │ 📡 AutoDJ • 42 listeners • 🔄 relay ke 3 stasiun    │   │
│ │ ────────●───────────────────────────────  1:23/4:20 │   │
│ └──────────────────────────────────────────────────────┘   │
│                                                             │
│ ┌─ JADWAL HARI INI ────────────────────────────────────┐   │
│ │ ⏰ 06:00  Pagi        📋 Playlist Pagi               │   │
│ │ ⏰ 08:00  Renungan    🔴 Live DJ: Kristono           │   │
│ │ ⏰ 11:00  Siang       📋 Playlist Siang               │   │
│ │ ⏰ 15:00  Sore        📋 Playlist Sore                │   │
│ │ ⏰ 18:00  Relay Jaringan 🔁 Sumber: KBRBaik Induk    │   │
│ │ ⏰ 20:00  Malam       📋 Playlist Malam               │   │
│ └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

#### B. Audio Library (Bank Lagu) — Click-Drop Style
```
┌─────────────────────────────────────────────────────────────┐
│ 📁 BANK LAGU: KBRBaik              [Upload] [Import] [🗑] │
├─────────────────────────────────────────────────────────────┤
│ [🔍 Cari lagu...]            [Genre ▼] [Urut ▼] [Grid/List]│
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ ┌──────┬──────────────────────┬────────┬───────┬──────┐    │
│ │  🎵  │ Malam Kudus          │ KJ     │ 4:20  │  🔄  │    │
│ │      │ Kidung Jemaat        │ 42     │       │  ▶️   │    │
│ ├──────┼──────────────────────┼────────┼───────┼──────┤    │
│ │  🎵  │ Bethlehem           │ IR      │ 3:15  │  🔄  │    │
│ │      │ Symphony            │ 128     │       │  ▶️   │    │
│ ├──────┼──────────────────────┼────────┼───────┼──────┤    │
│ │  🎵  │ How Great Thou Art  │ Hymns   │ 5:00  │  🔄  │    │
│ │      │ Elvis Presley       │ 256     │       │  ▶️   │    │
│ ├──────┼──────────────────────┼────────┼───────┼──────┤    │
│ │  🎵  │ Amazing Grace       │ My    │ 3:45  │  🔄  │    │
│ │      │ Chains              │ 192     │       │  ▶️   │    │
│ └──────┴──────────────────────┴────────┴───────┴──────┘    │
│                                                             │
│ Mode Preview (klik ▶️ dengar dulu sebelum drag ke playlist): │
│ ┌────────────────────────────────────────────────────────┐  │
│ │ ▶️ Malam Kudus — Kidung Jemaat   ────●──── 1:23/4:20 │  │
│ │ [Tambah ke Playlist ▾] [Edit Metadata] [Download]     │  │
│ └────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

#### C. Playlist Editor — LibreTime Style Drag & Drop
```
┌─────────────────────────────────────────────────────────────┐
│ 📋 PLAYLIST: Pagi (06:00-11:00)   KBRBaik   [🔄 AutoDJ]   │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ Bank Lagu ──────▶  ┌─ PAGI ────────────────────────────┐    │
│ ┌──────────────┐   │                                   │    │
│ │ Amazing Grace│   │ 1. Malam Kudus          🖐  4:20 │    │
│ │ Bethleem     │──▶│ 2. Bethleem             🖐  3:15 │    │
│ │ How Great    │   │ 3. How Great Thou Art  🖐  5:00 │    │
│ │ Malam Kudus  │──▶│ 4. Amazing Grace       🖐  3:45 │    │
│ │ O Holy Night │   │ 5. O Holy Night        🖐  4:30 │    │
│ └──────────────┘   │                                   │    │
│                    │ Total: 20:50 │ 5 lagu             │    │
│                    └────────────────────────────────────┘    │
│                                                             │
│ [Simpan] [Generate Liquidsoap] [Export M3U] [Reset]        │
│                                                             │
│ ┌─ PREVIEW ────────────────────────────────────────────┐   │
│ │ ▶️ Bethleem — IR symphony    ────●──── 1:00/3:15    │   │
│ └──────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

#### D. Schedule Grid (Weekly View)
```
┌─────────────────────────────────────────────────────────────┐
│ 📅 JADWAL SIARAN: KBRBaik         [Minggu Ini] [◀] [▶]   │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│      Sen     Sel     Rab     Kam     Jum     Sab     Min    │
│ ┌────┬────┬────┬────┬────┬────┬────┐                        │
│ │ 🔴 │    │    │    │    │    │    │ 06:00 Pagi             │
| │Pg-P│Pg-P│Pg-P│Pg-P│Pg-P│Pg-P│Pg-P|                        │
│ ├────┼────┼────┼────┼────┼────┼────┤                        │
│ │    │    │ 🔴 │    │    │    │    │ 08:00 Renungan         │
│ │    │    │Live│    │    │    │    │  (Kristono)            │
│ ├────┼────┼────┼────┼────┼────┼────┤                        │
│ │Sn-P│Sn-P│Sn-P│Sn-P│Sn-P│Sn-P│Sn-P│ 11:00 Siang           │
│ ├────┼────┼────┼────┼────┼────┼────┤                        │
│ │Sr-P│Sr-P│Sr-P│Sr-P│Sr-P│Sr-P│Sr-P│ 15:00 Sore            │
│ ├────┼────┼────┼────┼────┼────┼────┤                        │
│ │ 🔁 │Mlm-│Mlm-│Mlm-│Mlm-│Mlm-│Mlm-│ 18:00 Relay Jaringan  │
│ │Rly │P   │P   │P   │P   │P   │P   │  (KBRBaik → semua)   │
│ └────┴────┴────┴────┴────┴────┴────┘                        │
│                                                             │
│ [Tambah Acara] [Edit] [Drag to Reschedule]                 │
└─────────────────────────────────────────────────────────────┘
```

#### E. Live Studio (WebDJ)
```
┌─────────────────────────────────────────────────────────────┐
│ 🔴 LIVE STUDIO: KBRBaik          [Status: 🟢 ON AIR]       │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ ┌─ MIXER ──────────────────────────────────────────────┐   │
│ │                                                       │   │
│ │  Player 1: [▶ Malam Kudus] ────●── 1:23  🔊 ████░░  │   │
│ │  Player 2: [⏸ Bethleem]      ──────●─ 0:45  🔊 ██░░  │   │
│ │  Mic:     [🎤 ON]            [Push to Talk]  ██░░    │   │
│ │                                                       │   │
│ │  ┌─────────────┐ ┌─────────────┐ ┌─────────────────┐ │   │
│ │  │  ▶ PLAY 1   │ │  ▶ PLAY 2   │ │  🎤 MIC ON/OFF │ │   │
│ │  └─────────────┘ └─────────────┘ └─────────────────┘ │   │
│ └───────────────────────────────────────────────────────┘   │
│                                                             │
│ ┌─ QUEUE ──────────────────────────────────────────────┐   │
│ │ NEXT: 1. How Great Thou Art — Elvis                  │   │
│ │       2. Amazing Grace — My Chains                   │   │
│ │       3. O Holy Night — Nat King Cole                │   │
│ └──────────────────────────────────────────────────────┘   │
│                                                             │
│ [🔄 Switch to AutoDJ]  [📊 Listeners: 42]  [⏹ End Live]  │
└─────────────────────────────────────────────────────────────┘
```

#### F. Relay Manager
```
┌─────────────────────────────────────────────────────────────┐
│ 🔁 RELAY JARINGAN                          [Setiap Rabu]   │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ ┌─ KONFIGURASI RELAY ──────────────────────────────────┐   │
│ │                                                       │   │
│ │ Sumber:  [KBRBaik Induk ▼]                           │   │
│ │ Hari:    [Rabu ▼]                                    │   │
│ │ Jam:     [18:00 ▼] hingga [20:00 ▼]                  │   │
│ │                                                       │   │
│ │ Target:  ✅ Suara PGIW Jabar (radio.suarapgiw.live)  │   │
│ │          ✅ KBRBaik (kbrbaik.live)                     │   │
│ │          ☐ Pojok Radio (pojok.kbrbaik.live)          │   │
│ │          ☐ Stasiun Baru                               │   │
│ │                                                       │   │
│ │ [Simpan] [Test Relay Sekarang] [Lihat Log]            │   │
│ └───────────────────────────────────────────────────────┘   │
│                                                             │
│ ┌─ RELAY LOG ──────────────────────────────────────────┐   │
│ │ 12 Jun ✅ 18:00-20:00 — Selesai (120 listeners)     │   │
│ │ 05 Jun ✅ 18:00-20:00 — Selesai (98 listeners)      │   │
│ │ 29 Mei ❌ Gagal — Icecast connection timeout          │   │
│ └───────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

---

## 5. Fitur Hermes (AI Agent Telegram)

### 5.1 Perintah yang Didukung
```
/hermes help                         — daftar perintah
/hermes status                       — status semua stasiun
/hermes nowplaying [station]         — lagu sedang diputar
/hermes schedule [station] [hari]    — jadwal hari ini
/hermes playlist [station] [periode] — lihat playlist
/hermes play [station] "judul"       — putar lagu sekarang
/hermes queue [station]              — antrian berikutnya
/hermes relay [on|off]              — toggle relay
/hermes dj [station] [on|off]       — toggle live DJ mode
/hermes upload                       — upload lagu via Telegram
```

### 5.2 Arsitektur Hermes
```
Telegram User
    │
    ▼
┌─────────────────────────────┐
│  HERMES BOT (Python)        │
│  python-telegram-bot        │
│                             │
│  ┌──────────────────────┐  │
│  │  Intent Parser       │  │  → NLP sederhana (regex + keyword)
│  │  Command Router      │  │  → mapping intent → action
│  │  Action Executor     │  │  → HTTP call ke Studio API
│  │  Response Formatter  │  │  → format rapi buat Telegram
│  └──────────────────────┘  │
└──────────┬──────────────────┘
           │ HTTP API
           ▼
┌─────────────────────────────┐
│  STUDIO API (Laravel)       │
│  /api/hermes/*               │
└─────────────────────────────┘
```

---

## 6. Nginx Config (studio.kbrbaik.live)

```nginx
server {
    listen 443 ssl;
    server_name studio.kbrbaik.live;

    root /var/www/radio/public;
    index index.php;

    # SSL (same cert as main domain)
    ssl_certificate /etc/letsencrypt/live/kbrbaik.live/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/kbrbaik.live/privkey.pem;

    # Static files
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Audio files (protected, only auth'd users)
    location /storage/audio {
        internal;
        alias /var/www/radio/storage/app/public/audio;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # CORS for Hermes API
    location /api/hermes {
        if ($request_method = OPTIONS) {
            add_header Access-Control-Allow-Origin "*";
            add_header Access-Control-Allow-Methods "GET, POST, PUT, DELETE";
            add_header Access-Control-Allow-Headers "Content-Type, Authorization";
            add_header Content-Length 0;
            return 204;
        }
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

---

## 7. Migrations Strategy

### Sesi 1 — Database Schema
| # | Migration | Tabel | Prioritas |
|---|-----------|-------|-----------|
| 1 | `add_station_relay_fields` | stations (add relay_*) | HIGH |
| 2 | `add_user_role_station` | users (add role + station_id) | HIGH |
| 3 | `create_audio_tracks_table` | audio_tracks | HIGH |
| 4 | `add_audio_track_id_to_items` | playlist_items (add audio_track_id, fade, cue) | HIGH |
| 5 | `create_schedules_table` | schedules | HIGH |
| 6 | `create_relay_configs_table` | relay_configs | HIGH |
| 7 | `create_relay_logs_table` | relay_logs | MEDIUM |
| 8 | `create_live_streams_table` | live_streams | MEDIUM |
| 9 | `create_playout_logs_table` | playout_logs | MEDIUM |
| 10 | `create_hermes_commands_table` | hermes_commands | LOW |

### Sesi 2 — Controllers & Routes
| # | Controller | Routes | Prioritas |
|---|-----------|--------|-----------|
| 1 | `AudioTrackController` | CRUD audio_tracks | HIGH |
| 2 | `PlaylistController` | CRUD playlists + drag-drop reorder | HIGH |
| 3 | `ScheduleController` | CRUD schedules + weekly grid | HIGH |
| 4 | `LiveController` | live broadcast management | HIGH |
| 5 | `RelayController` | relay config + execute + log | HIGH |
| 6 | `StudioDashboardController` | dashboard stats + now playing | HIGH |
| 7 | `HermesController` | API endpoint for Hermes | MEDIUM |
| 8 | `UserController` | admin user management | MEDIUM |

### Sesi 3 — Views (UI/UX)
| # | View | Fitur | Prioritas |
|---|------|-------|-----------|
| 1 | `studio.dashboard` | Dashboard with stats, now playing, schedule today | HIGH |
| 2 | `studio.tracks.index` | Audio library with search, filter, preview | HIGH |
| 3 | `studio.tracks.upload` | Upload modal/drag-drop | HIGH |
| 4 | `studio.playlists.index` | Playlist list per station | HIGH |
| 5 | `studio.playlists.edit` | Drag-drop playlist editor (LibreTime style) | HIGH |
| 6 | `studio.schedules.index` | Weekly grid view | HIGH |
| 7 | `studio.schedules.edit` | Schedule CRUD form | HIGH |
| 8 | `studio.live.index` | Live Studio / WebDJ | HIGH |
| 9 | `studio.relay.index` | Relay configuration | MEDIUM |
| 10 | `studio.users.index` | User management | MEDIUM |

### Sesi 4 — Hermes Bot
| # | File | Fitur | Prioritas |
|---|------|-------|-----------|
| 1 | `hermes/bot.py` | Telegram bot main loop | MEDIUM |
| 2 | `hermes/handlers.py` | Command handlers | MEDIUM |
| 3 | `hermes/intents.py` | NLP parser | MEDIUM |
| 4 | `hermes/api.py` | HTTP client to Studio API | MEDIUM |

---

## 8. Implementation Roadmap

```
Minggu 1: Database + Migrations + Models
  ├── migration & model semua tabel
  ├── seed stasiun + user admin
  └── test relasi

Minggu 2: API & Controllers (Backend)
  ├── AudioTrack CRUD + upload (chunked for large files)
  ├── Playlist CRUD + drag-drop reorder API
  ├── Schedule CRUD + weekly grid data API
  ├── Relay config & execution
  └── Live stream endpoints

Minggu 3: UI/UX (Frontend)
  ├── Layout: sidebar + topbar + responsive
  ├── Dashboard page
  ├── Audio Library page (search, filter, preview, upload)
  ├── Playlist Editor (drag-drop, LibreTime style)
  ├── Schedule Grid (weekly calendar)
  └── Live Studio (WebDJ mixer)

Minggu 4: Relay + Hermes + Polish
  ├── Relay Manager UI
  ├── Hermes bot (Telegram)
  ├── AutoDJ integration w/ Liquidsoap
  ├── User & Station management (admin)
  └── Testing & deployment studio.kbrbaik.live
```

---

## 9. Teknologi Stack

| Layer | Teknologi | Alasan |
|-------|-----------|--------|
| **Framework** | Laravel 12 (existing) | reuse auth, Eloquent, Filament |
| **Admin Panel** | Filament v3 (existing) | StationResource sudah pakai |
| **Frontend** | TailwindCSS + Alpine.js | ringan, no build step complex |
| **Drag & Drop** | SortableJS + Livewire | real-time reorder, LibreTime feel |
| **Audio Player** | Howler.js | reliable audio playback |
| **WebSocket** | Laravel Reverb (existing) | real-time now playing updates |
| **Queue** | Laravel Horizon | background job untuk relay |
| **AI Agent** | Python + python-telegram-bot | Hermes |
| **Stream Control** | Liquidsoap telnet API | AutoDJ, relay switching |
| **Storage** | Laravel Filesystem (local/S3) | audio files |

---

## 10. Catatan Penting

### Isolasi Station
- `audio_tracks.station_id` = foreign key WAJIB
- Semua query harus difilter by station
- User dengan role `operator` atau `dj` hanya bisa lihat station yang ditugaskan
- Superadmin bisa lihat semua station

### Upload Audio
- File besar (100MB+) perlu chunked upload
- Validasi: mp3, wav, ogg, aac, flac
- Auto-extract metadata dengan getID3 (existing code sudah pakai)
- Generate waveform thumbnail
- Deduplication by file hash

### Relay Execution Flow
1. Schedule trigger → Cron tiap menit
2. Cek jadwal relay yang waktunya sekarang
3. Hit Liquidsoap API: `relay.start(source_station.stream_url)`
4. Set target station mount point ke mode relay
5. Log start ke relay_logs
6. Saat waktu habis: `relay.stop` → kembali ke AutoDJ

### Keamanan
- Studio.kbrbaik.live hanya bisa diakses via HTTPS
- Semua endpoint kecuali public stats require auth
- Role-based middleware: `can:manage-studio`
- Hermes API pakai API key + signature
- File audio dilindungi (internal nginx, tidak public)

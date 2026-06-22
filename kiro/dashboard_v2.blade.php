<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Studio Dashboard â€” {{ $station->name ?? 'KBR Baik' }}</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{background:#242424;color:#efefef;font-family:'Segoe UI',Arial,sans-serif;font-size:12px;overflow:hidden;height:100vh;display:flex;flex-direction:column}
a{color:#efefef;text-decoration:none}

/* MASTER PANEL */
#master{background:#3d3d3d;border-bottom:2px solid #555;padding:6px 12px;display:flex;align-items:center;gap:10px;flex-shrink:0;min-height:80px}
#master .logo{font-size:14px;font-weight:700;color:#ff5d1a;white-space:nowrap;min-width:90px}
#master .album-art{width:52px;height:52px;background:#222;border:1px solid #555;border-radius:2px;flex-shrink:0;object-fit:cover}
.np-block{flex:1;min-width:0}
.np-label{font-size:9px;color:#9b9b9b;text-transform:uppercase;letter-spacing:.5px}
.np-prev-next{display:flex;gap:16px;margin-bottom:2px}
.np-prev,.np-next{min-width:0}
.np-cur{margin-bottom:4px}
.np-title{font-size:13px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#fff}
.np-artist{font-size:11px;color:#c4c4c4;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.np-time{font-size:10px;color:#9b9b9b}
.progress-wrap{margin-top:3px}
.progress-row{display:flex;align-items:center;gap:6px;margin-bottom:2px}
.progress-bar-bg{flex:1;height:4px;background:#1a1a1a;border-radius:2px;overflow:hidden}
.progress-bar-fill{height:100%;border-radius:2px;transition:width .5s linear}
.bar-track{background:#f97202}
.bar-show{background:#02cef9}
.progress-label{font-size:9px;color:#9b9b9b;white-space:nowrap;min-width:70px}
.on-air-badge{background:#d40000;color:#fff;font-size:10px;font-weight:700;padding:3px 8px;border-radius:3px;letter-spacing:1px;flex-shrink:0}
.clock-block{text-align:right;flex-shrink:0;min-width:70px}
#clock{font-size:22px;font-weight:700;color:#fff;font-variant-numeric:tabular-nums}
.clock-date{font-size:9px;color:#9b9b9b}
.listeners{font-size:9px;color:#9b9b9b;text-align:center}

/* BODY LAYOUT */
#body{display:flex;flex:1;overflow:hidden}

/* SIDEBAR */
#sidebar{width:130px;background:#111;border-right:1px solid #2a2a2a;display:flex;flex-direction:column;flex-shrink:0;overflow-y:auto}
#sidebar::-webkit-scrollbar{width:3px}
#sidebar::-webkit-scrollbar-thumb{background:#333}
.sb-section{padding:4px 0;border-bottom:1px solid #1e1e1e}
.sb-label{font-size:9px;color:#666;text-transform:uppercase;letter-spacing:.5px;padding:6px 12px 2px}
.sb-link{display:flex;align-items:center;gap:7px;padding:6px 12px;font-size:11px;color:#aaa;cursor:pointer;border-left:3px solid transparent}
.sb-link:hover{background:#1a1a1a;color:#efefef;border-left-color:#444}
.sb-link.active{background:#1a1a1a;color:#fff;border-left-color:#ff5d1a}
.sb-icon{font-size:12px;width:14px;text-align:center}

/* STATION SWITCHER */
.station-select{background:#1a1a1a;border:1px solid #333;color:#ccc;font-size:10px;padding:4px 6px;margin:6px 8px;border-radius:3px;width:calc(100% - 16px);outline:none}

/* MAIN PANELS */
#panels{display:flex;flex:1;gap:0;overflow:hidden}

/* PANEL SHARED */
.panel{display:flex;flex-direction:column;flex:1;overflow:hidden;border-right:1px solid #2a2a2a}
.panel:last-child{border-right:none}
.panel-header{background:#3a3a3a;border-bottom:1px solid #444;padding:5px 10px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.panel-title{font-size:12px;font-weight:700;color:#fff}
.toolbar{display:flex;align-items:center;gap:3px;padding:4px 8px;border-bottom:1px solid #2a2a2a;flex-shrink:0;flex-wrap:wrap;background:#2a2a2a}
.btn{display:inline-flex;align-items:center;gap:3px;padding:3px 7px;font-size:10px;border-radius:2px;border:1px solid #555;background:#3d3d3d;color:#ccc;cursor:pointer;white-space:nowrap}
.btn:hover{background:#505050;color:#fff}
.btn-danger{border-color:#7a2020;background:#5a1818;color:#ff8080}
.btn-danger:hover{background:#7a2020}
.btn-primary{border-color:#0077aa;background:#005588;color:#88ddff}
.btn-primary:hover{background:#0077aa}
.tbl-head{display:flex;align-items:center;padding:3px 8px;background:#1e1e1e;border-bottom:1px solid #2a2a2a;font-size:9px;color:#777;font-weight:600;text-transform:uppercase;letter-spacing:.4px;flex-shrink:0}
.scroll-area{flex:1;overflow-y:auto}
.scroll-area::-webkit-scrollbar{width:4px}
.scroll-area::-webkit-scrollbar-thumb{background:#444;border-radius:2px}
.row{display:flex;align-items:center;padding:4px 8px;border-bottom:1px solid #2e2e2e;cursor:pointer}
.row:hover{background:#333}
.row.selected{background:rgba(255,93,26,.25)}
.row-icon{width:16px;text-align:center;color:#9b9b9b;font-size:11px;flex-shrink:0}
.row-title{flex:1;font-size:11px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#efefef}
.row-meta{font-size:10px;color:#888;white-space:nowrap;flex-shrink:0;margin-left:6px}
.muted{color:#888}
.search-wrap{padding:5px 8px;background:#2a2a2a;border-bottom:1px solid #2e2e2e;flex-shrink:0}
.search-input{width:100%;background:#1a1a1a;border:1px solid #444;color:#efefef;padding:4px 8px;font-size:11px;border-radius:2px;outline:none}
.search-input::placeholder{color:#666}
.search-input:focus{border-color:#ff5d1a}
.pagination{display:flex;align-items:center;justify-content:center;gap:4px;padding:6px;border-top:1px solid #2a2a2a;flex-shrink:0;background:#1e1e1e}
.page-btn{padding:2px 7px;font-size:10px;border:1px solid #444;background:#333;color:#aaa;cursor:pointer;border-radius:2px}
.page-btn:hover{background:#444;color:#fff}
.page-btn.active{background:#ff5d1a;border-color:#ff5d1a;color:#fff}

/* RIGHT PANEL â€” SHOWS */
.show-block{border-left:3px solid #00aacc;margin:4px 8px 0;border-radius:1px;overflow:hidden}
.show-hdr{display:flex;align-items:center;gap:6px;padding:5px 8px;cursor:pointer;font-size:11px}
.show-hdr:hover{filter:brightness(1.15)}
.show-hdr .show-name{flex:1;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.show-hdr .show-time{font-size:10px;color:#aaa;white-space:nowrap}
.show-badge{font-size:9px;font-weight:700;padding:1px 5px;border-radius:2px;letter-spacing:.5px}
.badge-live{background:#d40000;color:#fff}
.badge-next{background:#555;color:#ddd}
.show-tracks{display:none;border-top:1px solid rgba(255,255,255,.08)}
.show-tracks.open{display:block}
.show-track-row{display:flex;align-items:center;padding:3px 8px 3px 22px;border-bottom:1px solid rgba(255,255,255,.04);font-size:10px}
.show-track-row:hover{background:rgba(255,255,255,.04)}
.show-track-row .t-title{flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.show-track-row .t-dur{color:#777;white-space:nowrap;margin-left:6px}
.show-empty{padding:12px 8px;font-size:10px;color:#666;text-align:center}

/* UPLOAD MODAL */
#upload-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:1000;align-items:center;justify-content:center}
#upload-modal.open{display:flex}
.modal-box{background:#2d2d2d;border:1px solid #555;border-radius:4px;padding:20px;width:360px}
.modal-title{font-size:14px;font-weight:700;margin-bottom:16px;color:#fff}
.form-group{margin-bottom:12px}
.form-label{font-size:10px;color:#aaa;margin-bottom:4px;display:block}
.form-input{width:100%;background:#1a1a1a;border:1px solid #444;color:#efefef;padding:6px 8px;font-size:11px;border-radius:2px;outline:none}
.form-input:focus{border-color:#ff5d1a}
.upload-progress{display:none;margin-top:8px}
.upload-bar{height:4px;background:#1a1a1a;border-radius:2px;overflow:hidden;margin-top:4px}
.upload-bar-fill{height:100%;background:#ff5d1a;width:0;transition:width .3s}
.modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:16px}

/* DROP ZONES */
.drop-zone{outline:2px dashed transparent;transition:outline .15s}
.drop-zone.drag-over{outline:2px dashed #ff5d1a;background:rgba(255,93,26,.08)}
</style>
</head>
<body>
@php
$csrfToken = csrf_token();
$stationId = $station->id ?? 1;
$stationName = $station->name ?? 'KBR Baik';
$stationSlug = $station->slug ?? 'kbrbaik';
$nowTitle = $nowPlaying['title'] ?? 'Offline';
$nowArtist = $nowPlaying['artist'] ?? '';
$isOnline = $nowPlaying['online'] ?? false;
$listeners = $nowPlaying['listeners'] ?? 0;
@endphp

<!-- MASTER PANEL -->
<div id="master">
  <div class="logo">ðŸŽ™ Studio</div>
  <img class="album-art" id="album-art" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='52' height='52'%3E%3Crect width='52' height='52' fill='%23333'/%3E%3Ctext x='50%25' y='55%25' dominant-baseline='middle' text-anchor='middle' fill='%23777' font-size='22'%3Eâ™«%3C/text%3E%3C/svg%3E" alt="">
  <div class="np-block">
    <div class="np-prev-next">
      <div class="np-prev">
        <div class="np-label">PREV</div>
        <div class="np-time muted" id="np-prev">â€”</div>
      </div>
      <div class="np-next">
        <div class="np-label">NEXT</div>
        <div class="np-time muted" id="np-next">â€”</div>
      </div>
    </div>
    <div class="np-cur">
      <div class="np-title" id="np-title">{{ $nowTitle }}</div>
      <div class="np-artist" id="np-artist">{{ $nowArtist }}</div>
    </div>
    <div class="progress-wrap">
      <div class="progress-row">
        <span class="progress-label" id="np-elapsed">0:00 / 0:00</span>
        <div class="progress-bar-bg"><div class="progress-bar-fill bar-track" id="bar-track" style="width:0%"></div></div>
      </div>
      <div class="progress-row">
        <span class="progress-label" id="np-show-label">Show â€”</span>
        <div class="progress-bar-bg"><div class="progress-bar-fill bar-show" id="bar-show" style="width:0%"></div></div>
      </div>
    </div>
    <div class="listeners" id="np-listeners">{{ $listeners }} pendengar</div>
  </div>
  <div class="on-air-badge" id="on-air-badge" style="{{ $isOnline ? '' : 'background:#555' }}">
    {{ $isOnline ? 'ON AIR' : 'OFFLINE' }}
  </div>
  <div class="clock-block">
    <div id="clock">00:00</div>
    <div class="clock-date" id="clock-date"></div>
  </div>
</div>

<!-- BODY -->
<div id="body">

<!-- SIDEBAR -->
<div id="sidebar">
  <div class="sb-section">
    <div class="sb-label">Stasiun</div>
    <select class="station-select" id="station-switcher" onchange="switchStation(this.value)">
      @foreach($allStations as $s)
        <option value="{{ $s->id }}" {{ $s->id == $stationId ? 'selected' : '' }}>{{ $s->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="sb-section">
    <div class="sb-link active" onclick="window.location='/manage'"><span class="sb-icon">ðŸ </span>Dashboard</div>
    <div class="sb-link" onclick="window.location='/manage/tracks'"><span class="sb-icon">ðŸŽµ</span>Tracks</div>
    <div class="sb-link" onclick="window.location='/manage/playlists'"><span class="sb-icon">ðŸ“‹</span>Playlists</div>
    <div class="sb-link" onclick="window.location='/manage/smart-blocks'"><span class="sb-icon">âš¡</span>Smart Blk</div>
    <div class="sb-link" onclick="window.location='/manage/shows'"><span class="sb-icon">ðŸ“º</span>Shows</div>
    <div class="sb-link" onclick="window.location='/manage/podcasts'"><span class="sb-icon">ðŸŽ™</span>Podcasts</div>
  </div>
  <div class="sb-section">
    <div class="sb-link" onclick="window.location='/manage/schedules/calendar'"><span class="sb-icon">ðŸ“…</span>Calendar</div>
    <div class="sb-link" onclick="window.location='/manage/rundown'"><span class="sb-icon">â–¶</span>Rundown</div>
    <div class="sb-link" onclick="window.location='/manage/webstreams'"><span class="sb-icon">ðŸ“¡</span>Webstream</div>
    <div class="sb-link" onclick="window.location='/manage/relay'"><span class="sb-icon">ðŸ”</span>Relay</div>
  </div>
  <div class="sb-section">
    <div class="sb-link" onclick="document.getElementById('upload-modal').classList.add('open')"><span class="sb-icon">â¬†</span>Upload</div>
    <div class="sb-link" onclick="window.location='/admin'"><span class="sb-icon">âš™</span>Admin</div>
  </div>
  <div style="margin-top:auto;padding:8px 10px;border-top:1px solid #1e1e1e">
    <div style="font-size:9px;color:#555">{{ auth()->user()->name ?? '' }}</div>
    <form action="/logout" method="POST" style="margin-top:4px">
      @csrf
      <button type="submit" class="btn" style="font-size:9px;padding:2px 6px;width:100%">Logout</button>
    </form>
  </div>
</div>

<!-- PANELS -->
<div id="panels">


<!-- PANEL KIRI: TRACK LIBRARY -->
<div class="panel" id="panel-tracks">
  <div class="panel-header">
    <span class="panel-title">Dashboard â€” Tracks</span>
    <span style="font-size:10px;color:#888" id="track-count">Loading...</span>
  </div>
  <div class="toolbar">
    <button class="btn btn-primary" onclick="openUpload()">â¬† Upload</button>
    <button class="btn" onclick="loadTracks()">â†º Refresh</button>
    <button class="btn btn-danger" id="btn-delete-track" onclick="deleteSelectedTrack()" style="display:none">ðŸ—‘ Hapus</button>
    <select id="sort-select" class="btn" onchange="loadTracks()" style="cursor:pointer">
      <option value="title">Sort: Judul</option>
      <option value="artist">Sort: Artis</option>
      <option value="created_at">Sort: Terbaru</option>
    </select>
    <select id="perpage-select" class="btn" onchange="loadTracks()" style="cursor:pointer">
      <option value="25">25</option>
      <option value="50">50</option>
      <option value="100">100</option>
    </select>
  </div>
  <div class="search-wrap">
    <input class="search-input" id="track-search" placeholder="ðŸ” Cari judul, artis, album..." oninput="debounceSearch()">
  </div>
  <div class="tbl-head">
    <div style="width:16px"></div>
    <div style="flex:1">Judul</div>
    <div style="width:100px">Artis</div>
    <div style="width:55px;text-align:right">Durasi</div>
  </div>
  <div class="scroll-area" id="track-list" ondragover="event.preventDefault()" ondrop="handleTrackAreaDrop(event)">
    <div style="padding:20px;text-align:center;color:#666">Loading tracks...</div>
  </div>
  <div class="pagination" id="track-pagination"></div>
</div>

<!-- PANEL KANAN: SCHEDULED SHOWS -->
<div class="panel" id="panel-shows">
  <div class="panel-header">
    <span class="panel-title">Scheduled Shows</span>
    <div style="display:flex;align-items:center;gap:6px">
      <span id="show-onair-badge" style="display:none" class="show-badge badge-live">ON AIR</span>
      <button class="btn" onclick="loadShows()">â†º</button>
    </div>
  </div>
  <div class="toolbar">
    <input type="date" class="btn" id="show-date" value="{{ now()->toDateString() }}" onchange="loadShows()" style="cursor:pointer">
    <input class="search-input" id="show-search" placeholder="Filter show..." style="flex:1;max-width:150px" oninput="filterShows()">
  </div>
  <div class="scroll-area drop-zone" id="show-list" ondragover="handleShowAreaDragover(event)" ondrop="handleDropToActive(event)">
    <div style="padding:20px;text-align:center;color:#666">Loading jadwal...</div>
  </div>
</div>

</div><!-- /panels -->
</div><!-- /body -->


<!-- UPLOAD MODAL -->
<div id="upload-modal">
  <div class="modal-box">
    <div class="modal-title">â¬† Upload Audio</div>
    <div class="form-group">
      <label class="form-label">Judul *</label>
      <input class="form-input" id="up-title" placeholder="Judul lagu">
    </div>
    <div class="form-group">
      <label class="form-label">Artis</label>
      <input class="form-input" id="up-artist" placeholder="Nama artis">
    </div>
    <div class="form-group">
      <label class="form-label">File Audio (MP3/WAV/OGG/AAC/FLAC, max 300MB) *</label>
      <input class="form-input" type="file" id="up-file" accept=".mp3,.wav,.ogg,.aac,.flac" onchange="autoFillTitle(this)">
    </div>
    <div class="upload-progress" id="upload-progress">
      <div style="font-size:10px;color:#aaa" id="upload-status">Mengupload...</div>
      <div class="upload-bar"><div class="upload-bar-fill" id="upload-bar-fill"></div></div>
    </div>
    <div class="modal-actions">
      <button class="btn" onclick="closeUpload()">Batal</button>
      <button class="btn btn-primary" onclick="doUpload()">Upload</button>
    </div>
  </div>
</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let selectedTrackId = null;
let trackPage = 1;
let trackData = [];
let showsData = [];
let activeShowId = null;

// â”€â”€ CLOCK â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function updateClock() {
  const now = new Date();
  document.getElementById('clock').textContent =
    now.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
  document.getElementById('clock-date').textContent =
    now.toLocaleDateString('id-ID', {weekday:'short',day:'numeric',month:'short'});
}
setInterval(updateClock, 1000);
updateClock();

// â”€â”€ NOW PLAYING POLLING â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
let npStartTime = null;
let npDuration = 0;
let npElapsed = 0;
let showStartMin = 0, showEndMin = 0;

function pollNowPlaying() {
  fetch('/manage/now-playing', {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r => r.json()).then(d => {
      document.getElementById('np-title').textContent = d.title || 'â€”';
      document.getElementById('np-artist').textContent = d.artist || '';
      document.getElementById('np-listeners').textContent = (d.listeners || 0) + ' pendengar';
      const badge = document.getElementById('on-air-badge');
      badge.textContent = d.online ? 'ON AIR' : 'OFFLINE';
      badge.style.background = d.online ? '#d40000' : '#555';
    }).catch(()=>{});
}
setInterval(pollNowPlaying, 5000);
pollNowPlaying();

// Show progress from schedule times
function updateShowProgress() {
  if (!showStartMin || !showEndMin) return;
  const now = new Date();
  const curMin = now.getHours() * 60 + now.getMinutes() + now.getSeconds() / 60;
  const total = showEndMin - showStartMin;
  const elapsed = curMin - showStartMin;
  const pct = total > 0 ? Math.min(100, Math.max(0, (elapsed / total) * 100)) : 0;
  document.getElementById('bar-show').style.width = pct + '%';
  const rem = Math.max(0, showEndMin - curMin);
  const remH = Math.floor(rem / 60), remM = Math.floor(rem % 60);
  document.getElementById('np-show-label').textContent = 'Show ' + (remH ? remH + 'j ' : '') + remM + 'm lagi';
}
setInterval(updateShowProgress, 5000);

// â”€â”€ TRACKS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
let searchTimer = null;
function debounceSearch() {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => { trackPage = 1; loadTracks(); }, 350);
}

function loadTracks(page) {
  if (page) trackPage = page;
  const search = document.getElementById('track-search').value;
  const sort = document.getElementById('sort-select').value;
  const perPage = parseInt(document.getElementById('perpage-select').value);
  const list = document.getElementById('track-list');
  list.innerHTML = '<div style="padding:16px;text-align:center;color:#666">Loading...</div>';

  fetch(`/manage/tracks/json?search=${encodeURIComponent(search)}&sort=${sort}`, {
    headers:{'X-Requested-With':'XMLHttpRequest'}
  }).then(r => r.json()).then(data => {
    trackData = data;
    renderTracks(data, perPage);
  }).catch(() => {
    list.innerHTML = '<div style="padding:16px;text-align:center;color:#c33">Gagal load tracks</div>';
  });
}

function renderTracks(data, perPage) {
  const total = data.length;
  const totalPages = Math.ceil(total / perPage);
  const start = (trackPage - 1) * perPage;
  const page = data.slice(start, start + perPage);

  document.getElementById('track-count').textContent = total + ' track';

  const list = document.getElementById('track-list');
  if (!page.length) {
    list.innerHTML = '<div class="show-empty">Tidak ada track ditemukan</div>';
    document.getElementById('track-pagination').innerHTML = '';
    return;
  }

  list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : 'â€”';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      onclick="selectTrack(${t.id})"
      ondblclick="addToActiveShow(${t.id})">
      <div class="row-icon">ðŸŽµ</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:100px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:55px;text-align:right">${dur}</div>
    </div>`;
  }).join('');

  // Pagination
  const pg = document.getElementById('track-pagination');
  if (totalPages <= 1) { pg.innerHTML = ''; return; }
  let html = '';
  if (trackPage > 1) html += `<button class="page-btn" onclick="loadTracks(${trackPage-1})">â€¹</button>`;
  for (let i = Math.max(1, trackPage-2); i <= Math.min(totalPages, trackPage+2); i++) {
    html += `<button class="page-btn${i===trackPage?' active':''}" onclick="loadTracks(${i})">${i}</button>`;
  }
  if (trackPage < totalPages) html += `<button class="page-btn" onclick="loadTracks(${trackPage+1})">â€º</button>`;
  pg.innerHTML = html;
}

function selectTrack(id) {
  selectedTrackId = id;
  document.querySelectorAll('#track-list .row').forEach(r => r.classList.remove('selected'));
  const el = document.getElementById('tr-' + id);
  if (el) el.classList.add('selected');
  document.getElementById('btn-delete-track').style.display = 'inline-flex';
}

function deleteSelectedTrack() {
  if (!selectedTrackId) return;
  if (!confirm('Hapus track ini?')) return;
  fetch(`/manage/tracks/${selectedTrackId}`, {
    method: 'DELETE',
    headers: {'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest'}
  }).then(r => r.json()).then(() => {
    selectedTrackId = null;
    document.getElementById('btn-delete-track').style.display = 'none';
    loadTracks();
  });
}

// â”€â”€ DRAG & DROP â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
let dragTrackId = null, dragTrackTitle = '', dragTrackArtist = '';

function startDrag(ev, id, title, artist) {
  dragTrackId = id;
  dragTrackTitle = title;
  dragTrackArtist = artist;
  ev.dataTransfer.effectAllowed = 'copy';
  ev.dataTransfer.setData('text/plain', id);
}

function handleShowAreaDragover(ev) {
  ev.preventDefault();
  ev.dataTransfer.dropEffect = 'copy';
  ev.currentTarget.classList.add('drag-over');
}

function handleTrackAreaDrop(ev) {
  ev.currentTarget.classList.remove('drag-over');
}

function handleDropToActive(ev) {
  ev.preventDefault();
  ev.currentTarget.classList.remove('drag-over');
  if (!dragTrackId) return;
  // Find which show was dropped onto
  const showEl = ev.target.closest('[data-show-id]');
  const targetShowId = showEl ? showEl.dataset.showId : activeShowId;
  if (targetShowId) addTrackToShow(targetShowId, dragTrackId);
}

function addToActiveShow(trackId) {
  if (!activeShowId) { alert('Tidak ada show aktif. Pilih/drop ke show di panel kanan.'); return; }
  addTrackToShow(activeShowId, trackId);
}

function addTrackToShow(showId, trackId) {
  fetch(`/manage/shows/${showId}/tracks`, {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'},
    body: JSON.stringify({audio_track_id: trackId})
  }).then(r => r.json()).then(d => {
    if (d.success) loadShows();
  });
}

function removeTrackFromShow(showId, trackId) {
  if (!confirm('Hapus track dari show ini?')) return;
  fetch(`/manage/shows/${showId}/tracks/${trackId}`, {
    method: 'DELETE',
    headers: {'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest'}
  }).then(r => r.json()).then(() => loadShows());
}
</script>


<script>
// â”€â”€ SHOWS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function loadShows() {
  const date = document.getElementById('show-date').value;
  const list = document.getElementById('show-list');
  list.innerHTML = '<div style="padding:20px;text-align:center;color:#666">Loading jadwal...</div>';

  fetch(`/manage/schedules/today-with-tracks`, {
    headers: {'X-Requested-With': 'XMLHttpRequest'}
  }).then(r => r.json()).then(data => {
    showsData = data;
    renderShows(data);
  }).catch(() => {
    list.innerHTML = '<div class="show-empty" style="color:#c33">Gagal load jadwal</div>';
  });
}

function filterShows() {
  const q = document.getElementById('show-search').value.toLowerCase();
  const filtered = q ? showsData.filter(s => s.name.toLowerCase().includes(q)) : showsData;
  renderShows(filtered);
}

function renderShows(data) {
  const list = document.getElementById('show-list');
  const badge = document.getElementById('show-onair-badge');

  if (!data.length) {
    list.innerHTML = '<div class="show-empty">Tidak ada jadwal hari ini</div>';
    badge.style.display = 'none';
    return;
  }

  const nowMin = (() => {
    const n = new Date();
    return n.getHours() * 60 + n.getMinutes();
  })();

  let hasActive = false;
  const html = data.map(s => {
    const startMin = timeToMin(s.start_time);
    const endMin = timeToMin(s.end_time);
    const isActive = s.is_active || (nowMin >= startMin && nowMin < endMin);
    const isNext = !isActive && startMin > nowMin;

    if (isActive) {
      hasActive = true;
      activeShowId = s.show_id || null;
      showStartMin = startMin;
      showEndMin = endMin;
      document.getElementById('np-show-label').textContent = s.name;
      updateShowProgress();
    }

    const color = s.color || '#00aacc';
    const trackRows = (s.tracks && s.tracks.length) ?
      s.tracks.map(t => `
        <div class="show-track-row">
          <span class="row-icon">ðŸ”Š</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-dur muted">${t.duration ? fmtSec(t.duration) : 'â€”'}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#666;cursor:pointer;padding:0 4px;font-size:10px" title="Hapus">âœ•</button>` : ''}
        </div>`) .join('') :
      '<div class="show-empty">Belum ada track</div>';

    return `<div class="show-block drop-zone" data-show-id="${s.show_id || ''}"
        style="border-left-color:${color}"
        ondragover="handleShowAreaDragover(event)"
        ondrop="handleDropToShow(event, ${s.show_id || 'null'})">
      <div class="show-hdr" style="background:${color}22" onclick="toggleShow('show-${s.id}')">
        <span style="color:${color};font-size:14px">â–¾</span>
        <span class="show-name">${escHtml(s.name)}</span>
        <span class="show-time muted">${s.start_time}â€“${s.end_time}</span>
        ${isActive ? '<span class="show-badge badge-live">LIVE</span>' : ''}
        ${isNext && !isActive ? '<span class="show-badge badge-next">NEXT</span>' : ''}
        <span class="muted" style="font-size:10px">${s.track_count || 0}ðŸŽµ</span>
      </div>
      <div class="show-tracks${isActive ? ' open' : ''}" id="show-${s.id}">
        ${trackRows}
      </div>
    </div>`;
  }).join('');

  list.innerHTML = html || '<div class="show-empty">Tidak ada jadwal</div>';
  badge.style.display = hasActive ? 'inline-block' : 'none';
}

function toggleShow(id) {
  const el = document.getElementById(id);
  if (el) el.classList.toggle('open');
}

function handleDropToShow(ev, showId) {
  ev.preventDefault();
  ev.stopPropagation();
  ev.currentTarget.classList.remove('drag-over');
  if (!dragTrackId) return;
  const targetId = showId || activeShowId;
  if (targetId) addTrackToShow(targetId, dragTrackId);
  else alert('Show ini belum terhubung ke Show Manager. Buka menu Shows dulu.');
}

// â”€â”€ UPLOAD â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function openUpload() {
  document.getElementById('upload-modal').classList.add('open');
  document.getElementById('upload-progress').style.display = 'none';
  document.getElementById('upload-bar-fill').style.width = '0%';
}

function closeUpload() {
  document.getElementById('upload-modal').classList.remove('open');
  document.getElementById('up-title').value = '';
  document.getElementById('up-artist').value = '';
  document.getElementById('up-file').value = '';
}

function autoFillTitle(input) {
  if (!input.files[0]) return;
  const name = input.files[0].name.replace(/\.[^.]+$/, '').replace(/[-_]+/g, ' ');
  const titleEl = document.getElementById('up-title');
  if (!titleEl.value) titleEl.value = name;
}

function doUpload() {
  const title = document.getElementById('up-title').value.trim();
  const artist = document.getElementById('up-artist').value.trim();
  const file = document.getElementById('up-file').files[0];
  if (!title) { alert('Judul wajib diisi'); return; }
  if (!file) { alert('Pilih file audio'); return; }

  const fd = new FormData();
  fd.append('_token', CSRF);
  fd.append('title', title);
  fd.append('artist', artist);
  fd.append('audio_file', file);

  const prog = document.getElementById('upload-progress');
  const bar = document.getElementById('upload-bar-fill');
  const status = document.getElementById('upload-status');
  prog.style.display = 'block';

  const xhr = new XMLHttpRequest();
  xhr.upload.onprogress = e => {
    if (e.lengthComputable) bar.style.width = Math.round(e.loaded / e.total * 100) + '%';
  };
  xhr.onload = () => {
    try {
      const res = JSON.parse(xhr.responseText);
      if (res.success) {
        status.textContent = 'âœ“ Upload berhasil!';
        bar.style.background = '#00cc66';
        setTimeout(() => { closeUpload(); loadTracks(); }, 1200);
      } else {
        status.textContent = 'âœ— Gagal: ' + (res.message || 'Error');
        bar.style.background = '#d40000';
      }
    } catch(e) { status.textContent = 'âœ— Error server'; bar.style.background = '#d40000'; }
  };
  xhr.onerror = () => { status.textContent = 'âœ— Koneksi gagal'; bar.style.background = '#d40000'; };
  xhr.open('POST', '/manage/tracks/upload');
  xhr.send(fd);
}

// â”€â”€ STATION SWITCHER â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function switchStation(stationId) {
  fetch('/manage/switch-station', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'},
    body: JSON.stringify({station_id: stationId})
  }).then(r => r.json()).then(d => {
    if (d.success) { loadTracks(); loadShows(); pollNowPlaying(); }
  });
}

// â”€â”€ HELPERS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function fmtSec(s) {
  if (!s) return 'â€”';
  const m = Math.floor(s / 60), sec = s % 60;
  return m + ':' + String(sec).padStart(2,'0');
}

function timeToMin(t) {
  if (!t) return 0;
  const [h, m] = t.split(':').map(Number);
  return h * 60 + (m || 0);
}

function escHtml(s) {
  return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// Close modal on outside click
document.getElementById('upload-modal').addEventListener('click', function(e) {
  if (e.target === this) closeUpload();
});

// â”€â”€ INIT â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
loadTracks();
loadShows();
</script>
</body>
</html>


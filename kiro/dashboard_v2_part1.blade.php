<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Studio Dashboard — {{ $station->name ?? 'KBR Baik' }}</title>
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

/* RIGHT PANEL — SHOWS */
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
  <div class="logo">🎙 Studio</div>
  <img class="album-art" id="album-art" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='52' height='52'%3E%3Crect width='52' height='52' fill='%23333'/%3E%3Ctext x='50%25' y='55%25' dominant-baseline='middle' text-anchor='middle' fill='%23777' font-size='22'%3E♫%3C/text%3E%3C/svg%3E" alt="">
  <div class="np-block">
    <div class="np-prev-next">
      <div class="np-prev">
        <div class="np-label">PREV</div>
        <div class="np-time muted" id="np-prev">—</div>
      </div>
      <div class="np-next">
        <div class="np-label">NEXT</div>
        <div class="np-time muted" id="np-next">—</div>
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
        <span class="progress-label" id="np-show-label">Show —</span>
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
    <div class="sb-link active" onclick="window.location='/manage'"><span class="sb-icon">🏠</span>Dashboard</div>
    <div class="sb-link" onclick="window.location='/manage/tracks'"><span class="sb-icon">🎵</span>Tracks</div>
    <div class="sb-link" onclick="window.location='/manage/playlists'"><span class="sb-icon">📋</span>Playlists</div>
    <div class="sb-link" onclick="window.location='/manage/smart-blocks'"><span class="sb-icon">⚡</span>Smart Blk</div>
    <div class="sb-link" onclick="window.location='/manage/shows'"><span class="sb-icon">📺</span>Shows</div>
    <div class="sb-link" onclick="window.location='/manage/podcasts'"><span class="sb-icon">🎙</span>Podcasts</div>
  </div>
  <div class="sb-section">
    <div class="sb-link" onclick="window.location='/manage/schedules/calendar'"><span class="sb-icon">📅</span>Calendar</div>
    <div class="sb-link" onclick="window.location='/manage/rundown'"><span class="sb-icon">▶</span>Rundown</div>
    <div class="sb-link" onclick="window.location='/manage/webstreams'"><span class="sb-icon">📡</span>Webstream</div>
    <div class="sb-link" onclick="window.location='/manage/relay'"><span class="sb-icon">🔁</span>Relay</div>
  </div>
  <div class="sb-section">
    <div class="sb-link" onclick="document.getElementById('upload-modal').classList.add('open')"><span class="sb-icon">⬆</span>Upload</div>
    <div class="sb-link" onclick="window.location='/admin'"><span class="sb-icon">⚙</span>Admin</div>
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

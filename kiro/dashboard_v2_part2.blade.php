
<!-- PANEL KIRI: TRACK LIBRARY -->
<div class="panel" id="panel-tracks">
  <div class="panel-header">
    <span class="panel-title">Dashboard — Tracks</span>
    <span style="font-size:10px;color:#888" id="track-count">Loading...</span>
  </div>
  <div class="toolbar">
    <button class="btn btn-primary" onclick="openUpload()">⬆ Upload</button>
    <button class="btn" onclick="loadTracks()">↺ Refresh</button>
    <button class="btn btn-danger" id="btn-delete-track" onclick="deleteSelectedTrack()" style="display:none">🗑 Hapus</button>
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
    <input class="search-input" id="track-search" placeholder="🔍 Cari judul, artis, album..." oninput="debounceSearch()">
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
      <button class="btn" onclick="loadShows()">↺</button>
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

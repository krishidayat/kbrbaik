
<!-- UPLOAD MODAL -->
<div id="upload-modal">
  <div class="modal-box">
    <div class="modal-title">⬆ Upload Audio</div>
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

// ── CLOCK ──────────────────────────────────────────
function updateClock() {
  const now = new Date();
  document.getElementById('clock').textContent =
    now.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
  document.getElementById('clock-date').textContent =
    now.toLocaleDateString('id-ID', {weekday:'short',day:'numeric',month:'short'});
}
setInterval(updateClock, 1000);
updateClock();

// ── NOW PLAYING POLLING ────────────────────────────
let npStartTime = null;
let npDuration = 0;
let npElapsed = 0;
let showStartMin = 0, showEndMin = 0;

function pollNowPlaying() {
  fetch('/manage/now-playing', {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r => r.json()).then(d => {
      document.getElementById('np-title').textContent = d.title || '—';
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

// ── TRACKS ─────────────────────────────────────────
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
    const dur = t.duration ? fmtSec(t.duration) : '—';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      onclick="selectTrack(${t.id})"
      ondblclick="addToActiveShow(${t.id})">
      <div class="row-icon">🎵</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:100px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:55px;text-align:right">${dur}</div>
    </div>`;
  }).join('');

  // Pagination
  const pg = document.getElementById('track-pagination');
  if (totalPages <= 1) { pg.innerHTML = ''; return; }
  let html = '';
  if (trackPage > 1) html += `<button class="page-btn" onclick="loadTracks(${trackPage-1})">‹</button>`;
  for (let i = Math.max(1, trackPage-2); i <= Math.min(totalPages, trackPage+2); i++) {
    html += `<button class="page-btn${i===trackPage?' active':''}" onclick="loadTracks(${i})">${i}</button>`;
  }
  if (trackPage < totalPages) html += `<button class="page-btn" onclick="loadTracks(${trackPage+1})">›</button>`;
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

// ── DRAG & DROP ────────────────────────────────────
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

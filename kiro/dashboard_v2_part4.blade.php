
<script>
// ── SHOWS ──────────────────────────────────────────
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
          <span class="row-icon">🔊</span>
          <span class="t-title" title="${escHtml(t.title)}">${escHtml(t.title)}</span>
          <span class="t-dur muted">${t.duration ? fmtSec(t.duration) : '—'}</span>
          ${s.show_id ? `<button onclick="removeTrackFromShow(${s.show_id}, ${t.id})" style="background:none;border:none;color:#666;cursor:pointer;padding:0 4px;font-size:10px" title="Hapus">✕</button>` : ''}
        </div>`) .join('') :
      '<div class="show-empty">Belum ada track</div>';

    return `<div class="show-block drop-zone" data-show-id="${s.show_id || ''}"
        style="border-left-color:${color}"
        ondragover="handleShowAreaDragover(event)"
        ondrop="handleDropToShow(event, ${s.show_id || 'null'})">
      <div class="show-hdr" style="background:${color}22" onclick="toggleShow('show-${s.id}')">
        <span style="color:${color};font-size:14px">▾</span>
        <span class="show-name">${escHtml(s.name)}</span>
        <span class="show-time muted">${s.start_time}–${s.end_time}</span>
        ${isActive ? '<span class="show-badge badge-live">LIVE</span>' : ''}
        ${isNext && !isActive ? '<span class="show-badge badge-next">NEXT</span>' : ''}
        <span class="muted" style="font-size:10px">${s.track_count || 0}🎵</span>
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

// ── UPLOAD ─────────────────────────────────────────
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
        status.textContent = '✓ Upload berhasil!';
        bar.style.background = '#00cc66';
        setTimeout(() => { closeUpload(); loadTracks(); }, 1200);
      } else {
        status.textContent = '✗ Gagal: ' + (res.message || 'Error');
        bar.style.background = '#d40000';
      }
    } catch(e) { status.textContent = '✗ Error server'; bar.style.background = '#d40000'; }
  };
  xhr.onerror = () => { status.textContent = '✗ Koneksi gagal'; bar.style.background = '#d40000'; };
  xhr.open('POST', '/manage/tracks/upload');
  xhr.send(fd);
}

// ── STATION SWITCHER ───────────────────────────────
function switchStation(stationId) {
  fetch('/manage/switch-station', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'},
    body: JSON.stringify({station_id: stationId})
  }).then(r => r.json()).then(d => {
    if (d.success) { loadTracks(); loadShows(); pollNowPlaying(); }
  });
}

// ── HELPERS ────────────────────────────────────────
function fmtSec(s) {
  if (!s) return '—';
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

// ── INIT ───────────────────────────────────────────
loadTracks();
loadShows();
</script>
</body>
</html>

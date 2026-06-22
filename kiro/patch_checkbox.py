path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# 1. CSS checkbox dan selected state
old_css = '.row.selected{background:rgba(255,93,26,.25)}'
new_css = '''.row.selected{background:rgba(255,93,26,.2)}
.row input[type=checkbox]{accent-color:#ff5d1a;cursor:pointer;flex-shrink:0;width:13px;height:13px}
#selected-count{font-size:10px;color:#aaa;padding:0 4px}'''
content = content.replace(old_css, new_css)

# 2. Tambah checkbox select-all di tbl-head
old_thead = '''  <div class="tbl-head">
    <div style="width:16px"></div>
    <div style="flex:1">Judul</div>
    <div style="width:100px">Artis</div>
    <div style="width:55px;text-align:right">Durasi</div>
  </div>'''
new_thead = '''  <div class="tbl-head">
    <div style="width:20px"><input type="checkbox" id="chk-all" onclick="toggleAllChecks(this)" title="Pilih semua"></div>
    <div style="flex:1">Judul</div>
    <div style="width:90px">Artis</div>
    <div style="width:42px;text-align:right">Durasi</div>
  </div>'''
content = content.replace(old_thead, new_thead)

# 3. Toolbar - ganti btn-primary Upload + tambah btn Add Selected
old_toolbar = '''    <button class="btn btn-primary" onclick="openUpload()">&#8679; Upload</button>
    <button class="btn" onclick="loadTracks()">&#8634; Refresh</button>
    <button class="btn btn-danger" id="btn-delete-track" onclick="deleteSelectedTrack()" style="display:none">&#128465; Hapus</button>'''
new_toolbar = '''    <button class="btn btn-primary" onclick="openUpload()">&#8679; Upload</button>
    <button class="btn" onclick="loadTracks()">&#8634;</button>
    <button class="btn btn-primary" id="btn-add-selected" onclick="addSelectedToShow()" style="display:none" title="Tambah yang dicentang ke show aktif">+ Tambah ke Show</button>
    <span id="selected-count"></span>
    <button class="btn btn-danger" id="btn-delete-track" onclick="deleteSelectedTrack()" style="display:none">&#128465;</button>'''
content = content.replace(old_toolbar, new_toolbar)

# 4. Update track row - ganti onclick selectTrack dengan checkbox
old_row_start = '''    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '—';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      ondragend="this.classList.remove('dragging')"
      onclick="selectTrack(${t.id})"
      ondblclick="addToActiveShow(${t.id})"
      title="Drag ke show kanan, atau double-click untuk tambah ke show aktif">
      <div class="row-icon">&#9834;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:90px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:42px;text-align:right">${dur}</div>
      <button class="add-btn" onclick="event.stopPropagation();addToActiveShow(${t.id})" title="Tambah ke show aktif">+</button>
    </div>`;'''
new_row_start = '''    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '—';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      ondragend="this.classList.remove('dragging')"
      ondblclick="addToActiveShow(${t.id})">
      <div style="width:20px;flex-shrink:0"><input type="checkbox" class="track-chk" value="${t.id}" onchange="onCheckChange()"></div>
      <div class="row-icon">&#9834;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:90px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:42px;text-align:right">${dur}</div>
    </div>`;'''
content = content.replace(old_row_start, new_row_start)

# 5. Tambah fungsi checkbox
old_select_fn = '''function selectTrack(id) {
  selectedTrackId = id;
  document.querySelectorAll('#track-list .row').forEach(r => r.classList.remove('selected'));
  const el = document.getElementById('tr-' + id);
  if (el) el.classList.add('selected');
  document.getElementById('btn-delete-track').style.display = 'inline-flex';
}'''
new_select_fn = '''function selectTrack(id) {
  selectedTrackId = id;
  document.getElementById('btn-delete-track').style.display = 'inline-flex';
}

function onCheckChange() {
  const checked = getCheckedIds();
  const n = checked.length;
  document.getElementById('selected-count').textContent = n ? n + ' dipilih' : '';
  document.getElementById('btn-add-selected').style.display = n ? 'inline-flex' : 'none';
  document.getElementById('btn-delete-track').style.display = n === 1 ? 'inline-flex' : 'none';
  if (n === 1) selectedTrackId = checked[0];
  // Highlight rows
  document.querySelectorAll('.track-chk').forEach(chk => {
    document.getElementById('tr-' + chk.value)?.classList.toggle('selected', chk.checked);
  });
}

function getCheckedIds() {
  return [...document.querySelectorAll('.track-chk:checked')].map(c => parseInt(c.value));
}

function toggleAllChecks(master) {
  document.querySelectorAll('.track-chk').forEach(c => { c.checked = master.checked; });
  onCheckChange();
}

async function addSelectedToShow() {
  const ids = getCheckedIds();
  if (!ids.length) return;
  if (!activeShowId) { alert('Tidak ada show aktif.'); return; }
  for (const id of ids) {
    await fetch(`/manage/shows/${activeShowId}/tracks`, {
      method: 'POST',
      headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'X-Requested-With':'XMLHttpRequest'},
      body: JSON.stringify({audio_track_id: id})
    });
  }
  // Uncheck semua
  document.querySelectorAll('.track-chk').forEach(c => c.checked = false);
  document.getElementById('chk-all').checked = false;
  onCheckChange();
  loadShows();
}'''
content = content.replace(old_select_fn, new_select_fn)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert 'track-chk' in content and 'addSelectedToShow' in content
print('OK')

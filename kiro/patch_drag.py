path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

# 1. CSS - drag feedback + tombol add
old_css = '.drop-zone{outline:2px dashed transparent;transition:outline .15s}\n.drop-zone.drag-over{outline:2px dashed #ff5d1a;background:rgba(255,93,26,.08)}'
new_css = '''.drop-zone{outline:2px dashed transparent;transition:outline .15s}
.drop-zone.drag-over{outline:2px dashed #ff5d1a;background:rgba(255,93,26,.08)}
.row.dragging{opacity:.4;background:#555}
.row .add-btn{display:none;background:#005588;border:none;color:#88ddff;cursor:pointer;padding:1px 5px;border-radius:2px;font-size:10px;flex-shrink:0;margin-left:4px}
.row:hover .add-btn{display:inline-block}
.row .add-btn:hover{background:#0077aa}'''
content = content.replace(old_css, new_css)

# 2. Update track row template - tambah tombol + dan drag events lebih lengkap
old_row = """    list.innerHTML = page.map(t => {
    const dur = t.duration ? fmtSec(t.duration) : '—';
    return `<div class="row" id="tr-${t.id}"
      draggable="true"
      ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      onclick="selectTrack(${t.id})"
      ondblclick="addToActiveShow(${t.id})">
      <div class="row-icon">&#9834;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:100px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:55px;text-align:right">${dur}</div>
    </div>`;"""

new_row = """    list.innerHTML = page.map(t => {
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
    </div>`;"""

content = content.replace(old_row, new_row)

# 3. Update startDrag - tambah visual dragging class
old_start_drag = """function startDrag(ev, id, title, artist) {
  dragTrackId = id;
  dragTrackTitle = title;
  dragTrackArtist = artist;
  ev.dataTransfer.effectAllowed = 'copy';
  ev.dataTransfer.setData('text/plain', id);
}"""

new_start_drag = """function startDrag(ev, id, title, artist) {
  dragTrackId = id;
  dragTrackTitle = title;
  dragTrackArtist = artist;
  ev.dataTransfer.effectAllowed = 'copy';
  ev.dataTransfer.setData('text/plain', id);
  setTimeout(() => { const el = document.getElementById('tr-' + id); if (el) el.classList.add('dragging'); }, 0);
}"""

content = content.replace(old_start_drag, new_start_drag)

# 4. Show-list dragover - hilangkan outline dari seluruh list, fokus ke show-block
old_show_dragover = """function handleShowAreaDragover(ev) {
  ev.preventDefault();
  ev.dataTransfer.dropEffect = 'copy';
  ev.currentTarget.classList.add('drag-over');
}"""

new_show_dragover = """function handleShowAreaDragover(ev) {
  ev.preventDefault();
  ev.dataTransfer.dropEffect = 'copy';
  // Highlight hanya show-block yang di-hover, bukan seluruh panel
  document.querySelectorAll('.show-block').forEach(b => b.classList.remove('drag-over'));
  const block = ev.target.closest('.show-block');
  if (block) block.classList.add('drag-over');
}"""

content = content.replace(old_show_dragover, new_show_dragover)

open(path, 'w', encoding='utf-8').write(content)
print('Done')
assert 'add-btn' in content and 'dragging' in content
print('OK')

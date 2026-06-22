path = '/var/www/radio/resources/views/studio/dashboard_v2.blade.php'
content = open(path, encoding='utf-8').read()

old = '''    ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      onclick="selectTrack(${t.id})"
      ondblclick="addToActiveShow(${t.id})">
      <div class="row-icon">&#9834;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:100px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:55px;text-align:right">${dur}</div>
    </div>`;'''

new = '''    ondragstart="startDrag(event, ${t.id}, ${JSON.stringify(t.title)}, ${JSON.stringify(t.artist || '')})"
      ondragend="this.classList.remove('dragging')"
      ondblclick="addToActiveShow(${t.id})">
      <div style="width:20px;flex-shrink:0;padding-left:2px"><input type="checkbox" class="track-chk" value="${t.id}" onchange="onCheckChange()" onclick="event.stopPropagation()"></div>
      <div class="row-icon">&#9834;</div>
      <div class="row-title" title="${escHtml(t.title)}">${escHtml(t.title)}</div>
      <div class="row-meta muted" style="width:90px;overflow:hidden;text-overflow:ellipsis">${escHtml(t.artist||'')}</div>
      <div class="row-meta" style="width:42px;text-align:right">${dur}</div>
    </div>`;'''

if old in content:
    content = content.replace(old, new)
    open(path, 'w', encoding='utf-8').write(content)
    print('Patched OK')
else:
    # Debug: cari baris yang mirip
    for i, line in enumerate(content.split('\n')):
        if 'ondblclick' in line and 'addToActiveShow' in line:
            print(f'Line {i}: {repr(line)}')
    print('NOT FOUND - manual check needed')

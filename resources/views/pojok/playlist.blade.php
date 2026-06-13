@extends('pojok.layout')

@section('title', $playlist->name)
@section('page_title', ($icons[$playlist->period] ?? '🎵') . ' ' . $playlist->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- LEFT: Item List --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-sky-900">Daftar Item</h2>
                    <p class="text-xs text-gray-400">Seret & lepas untuk mengurutkan</p>
                </div>
                <span class="text-xs font-mono bg-gray-100 text-gray-500 px-2 py-1 rounded-full">{{ $items->count() }} item</span>
            </div>

            @if ($items->isEmpty())
            <div class="p-10 text-center">
                <div class="text-4xl mb-3">{{ $icons[$playlist->period] ?? '🎵' }}</div>
                <p class="text-gray-400 text-sm">Belum ada item di playlist ini</p>
                <p class="text-xs text-gray-300 mt-1">Gunakan menu Tambah Item di samping</p>
            </div>
            @else
            <div id="playlist-items" class="divide-y divide-gray-100">
                @foreach ($items as $item)
                <div class="playlist-item flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition group"
                     data-id="{{ $item->id }}" data-order="{{ $item->sort_order }}">
                    <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-500 shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 6h2v2H8V6zm6 0h2v2h-2V6zM8 11h2v2H8v-2zm6 0h2v2h-2v-2zm-6 5h2v2H8v-2zm6 0h2v2h-2v-2z"/></svg>
                    </div>
                    <span class="text-xs font-mono px-1.5 py-0.5 rounded shrink-0
                        @if($item->item_type === 'audio') bg-blue-50 text-blue-600
                        @elseif($item->item_type === 'webstream') bg-purple-50 text-purple-600
                        @else bg-green-50 text-green-600 @endif">
                        {{ $item->item_type }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item->title }}</p>
                        @if ($item->artist)
                        <p class="text-xs text-gray-400 truncate">{{ $item->artist }}</p>
                        @endif
                    </div>
                    @if ($item->duration_display)
                    <span class="text-xs font-mono text-gray-400 shrink-0">{{ $item->duration_display }}</span>
                    @endif
                    <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition">
                        <button onclick="toggleItem({{ $item->id }})"
                                class="p-1.5 rounded-lg hover:bg-gray-100 {{ $item->is_active ? 'text-green-500' : 'text-gray-300' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                @if ($item->is_active)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                        </button>
                        <button onclick="editItem({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->artist) }}', '{{ $item->item_type }}', '{{ addslashes($item->webstream_url) }}', '{{ addslashes($item->podcast_url) }}', '{{ addslashes($item->duration_display) }}')"
                                class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </button>
                        <form method="POST" action="{{ route('pojok.item.delete', $item->id) }}" class="inline" onsubmit="return confirm('Hapus item ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- RIGHT: Add Forms --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-bold text-sm text-sky-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Tambah Audio
            </h3>
            <form method="POST" action="{{ route('pojok.item.create', $playlist->period) }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="hidden" name="item_type" value="audio">
                <input type="text" name="title" placeholder="Judul lagu" required
                       class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                <input type="text" name="artist" placeholder="Nama artis"
                       class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                <input type="file" name="audio_file" accept="audio/*" required
                       class="w-full text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold py-2 rounded-lg transition">
                    Upload Audio
                </button>
            </form>
            <button onclick="openLibrary()" class="mt-3 w-full bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-semibold py-2 rounded-lg border border-blue-200 transition flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                Pilih dari Library
            </button>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-bold text-sm text-sky-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m9.86-2.5a4.5 4.5 0 00-6.364-6.365l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                Tambah Webstream
            </h3>
            <form method="POST" action="{{ route('pojok.item.create', $playlist->period) }}" class="space-y-3">
                @csrf
                <input type="hidden" name="item_type" value="webstream">
                <input type="text" name="title" placeholder="Nama stasiun radio" required
                       class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                <input type="url" name="webstream_url" placeholder="https://radio.example.com/stream" required
                       class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold py-2 rounded-lg transition">
                    Tambah Webstream
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-bold text-sm text-sky-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z"/></svg>
                Tambah Podcast
            </h3>
            <form method="POST" action="{{ route('pojok.item.create', $playlist->period) }}" class="space-y-3 pb-3 mb-3 border-b border-gray-100">
                @csrf
                <input type="hidden" name="item_type" value="podcast">
                <input type="text" name="title" placeholder="Judul episode" required
                       class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                <input type="url" name="podcast_url" placeholder="URL audio episode" required
                       class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                <input type="text" name="duration_display" placeholder="Durasi (45:30)"
                       class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 rounded-lg transition">
                    Tambah Podcast
                </button>
            </form>
            <form method="POST" action="{{ route('pojok.rss.import') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="playlist_period" value="{{ $playlist->period }}">
                <input type="url" name="rss_url" placeholder="https://feed.example.com/podcast.xml" required
                       class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold py-2 rounded-lg transition flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0115 0m-12 0a4.5 4.5 0 019 0m-6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"/></svg>
                    Import dari RSS
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="fixed inset-0 z-50 hidden bg-black/30 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <h3 class="font-bold text-sky-900 mb-4">Edit Item</h3>
        <form method="POST" id="edit-form" class="space-y-3">
            @csrf @method('PUT')
            <input type="text" name="title" id="edit-title" required
                   class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
            <input type="text" name="artist" id="edit-artist" placeholder="Artis"
                   class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
            <select name="item_type" id="edit-type"
                    class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                <option value="audio">Audio</option>
                <option value="webstream">Webstream</option>
                <option value="podcast">Podcast</option>
            </select>
            <input type="url" name="webstream_url" id="edit-webstream" placeholder="URL Webstream"
                   class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
            <input type="url" name="podcast_url" id="edit-podcast" placeholder="URL Podcast"
                   class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
            <input type="text" name="duration_display" id="edit-duration" placeholder="Durasi"
                   class="w-full text-sm px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold py-2 rounded-lg transition">Simpan</button>
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- Library Modal --}}
<div id="library-modal" class="fixed inset-0 z-50 hidden bg-black/30 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[80vh] flex flex-col">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
            <h3 class="font-bold text-sky-900">Pilih dari Library</h3>
            <button onclick="closeLibrary()" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-4" id="library-list">
            <div class="text-center text-gray-400 py-8 text-sm">Memuat...</div>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 text-xs text-gray-400 shrink-0" id="library-count"></div>
    </div>
</div>

@push('scripts')
<script>
    function openLibrary() {
        document.getElementById('library-modal').classList.remove('hidden');
        fetch('{{ route("pojok.library", $playlist->period) }}')
            .then(function(r) { return r.json(); })
            .then(function(items) {
                var list = document.getElementById('library-list');
                var count = document.getElementById('library-count');
                if (!items.length) {
                    list.innerHTML = '<div class="text-center text-gray-400 py-8 text-sm">Tidak ada lagu lain di library</div>';
                    count.textContent = '0 item';
                    return;
                }
                var html = '';
                items.forEach(function(item) {
                    html += '<div class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200 transition mb-1">';
                    html += '<div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">';
                    html += '<svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25"/></svg>';
                    html += '</div>';
                    html += '<div class="flex-1 min-w-0">';
                    html += '<p class="text-sm font-medium text-gray-900 truncate">' + (item.title || '(no title)') + '</p>';
                    html += '<p class="text-xs text-gray-400 truncate">' + (item.artist || '') + '</p>';
                    html += '</div>';
                    if (item.duration_display) {
                        html += '<span class="text-xs font-mono text-gray-400 shrink-0 mr-2">' + item.duration_display + '</span>';
                    }
                    html += '<button onclick="addFromLibrary(' + item.id + ')" class="px-3 py-1.5 rounded-lg bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold transition shrink-0">Pilih</button>';
                    html += '</div>';
                });
                list.innerHTML = html;
                count.textContent = items.length + ' item tersedia';
            })
            .catch(function() {
                document.getElementById('library-list').innerHTML = '<div class="text-center text-red-400 py-8 text-sm">Gagal memuat library</div>';
            });
    }

    function addFromLibrary(id) {
        var btn = event.target;
        btn.textContent = '...';
        btn.disabled = true;
        fetch('{{ route("pojok.addFromLibrary", $playlist->period) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({ source_id: id })
        })
        .then(function(r) { return r.json(); })
        .then(function(j) {
            if (j.success) location.reload();
        })
        .catch(function() {
            btn.textContent = 'Gagal';
        });
    }

    function closeLibrary() {
        document.getElementById('library-modal').classList.add('hidden');
    }

    document.getElementById('library-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeLibrary();
    });

    var itemsEl = document.getElementById('playlist-items');
    if (itemsEl) {
        new Sortable(itemsEl, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function() {
                var order = [];
                document.querySelectorAll('.playlist-item').forEach(function(el, i) {
                    order.push({ id: el.dataset.id, sort_order: i + 1 });
                });
                fetch('{{ route("pojok.reorder", $playlist->period) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ items: order })
                }).then(function(r) { return r.json(); }).then(function(j) {
                    if (j.success) location.reload();
                });
            }
        });
    }

    function toggleItem(id) {
        fetch('/item/' + id + '/toggle', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
        }).then(function() { location.reload(); });
    }

    function editItem(id, title, artist, type, webstream, podcast, duration) {
        document.getElementById('edit-form').action = '/item/' + id;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-artist').value = artist;
        document.getElementById('edit-type').value = type;
        document.getElementById('edit-webstream').value = webstream || '';
        document.getElementById('edit-podcast').value = podcast || '';
        document.getElementById('edit-duration').value = duration || '';
        document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }

    document.getElementById('edit-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });
</script>
@endpush

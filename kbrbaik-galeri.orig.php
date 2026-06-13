<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen flex flex-col">
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight">Radio KbrBaik</span>
            </a>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('services') }}" class="hover:text-sky-200 transition">Layanan</a>
                <a href="{{ route('pelatihan') }}" class="hover:text-sky-200 transition">Pelatihan</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>
            <a href="{{ route('pelatihan') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>
    </nav>

    <main class="flex-1 max-w-6xl mx-auto px-4 py-8 w-full">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-sky-900">Galeri Foto</h1>
                <p class="text-sky-600 mt-1">{{ $station?->name ?? 'KBRBaik' }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="openModal('upload-modal')" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12"/></svg>
                    Upload
                </button>
                <button onclick="openModal('unsplash-modal')" class="bg-white border border-sky-300 hover:bg-sky-100 text-sky-700 px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Unsplash
                </button>
            </div>
        </div>

        <div id="gallery-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($items as $item)
            <div class="gallery-card relative bg-white rounded-xl overflow-hidden shadow-sm border border-sky-100 hover:shadow-md transition group"
                 data-id="{{ $item->id }}">
                <div class="aspect-square min-h-[200px] bg-sky-100 overflow-hidden cursor-pointer"
                     onclick="openViewer('{{ asset("storage/" . $item->image_path) }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->description ?? '') }}')">
                    <img src="{{ asset("storage/" . ($item->thumbnail_path ?? $item->image_path)) }}"
                         alt="{{ $item->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-3 pt-8">
                    <p class="text-white font-semibold text-sm leading-tight truncate">{{ $item->title }}</p>
                    @if ($item->description)
                    <p class="text-white/80 text-xs mt-0.5 line-clamp-1">{{ $item->description }}</p>
                    @endif
                </div>
                @auth
                <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button onclick="event.stopPropagation(); editItem({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->description ?? '') }}')"
                            class="bg-white/90 hover:bg-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button onclick="event.stopPropagation(); deleteItem({{ $item->id }})"
                            class="bg-white/90 hover:bg-red-500 hover:text-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                @endauth
            </div>
            @empty
            <p id="empty-msg" class="text-center text-sky-400 py-12 col-span-full">Belum ada foto di galeri</p>
            @endforelse
        </div>
    </main>

    <div id="toast" class="fixed top-4 right-4 z-[100] hidden max-w-sm w-full shadow-lg rounded-lg px-4 py-3 text-sm font-medium"></div>

    <div id="upload-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-sky-900">Upload Foto</h3>
                <button onclick="closeModal('upload-modal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <form id="upload-form" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" id="upload-title" required maxlength="255"
                           class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                    <textarea id="upload-desc" rows="2" maxlength="1000"
                              class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Foto</label>
                    <input type="file" id="upload-file" accept="image/jpeg,image/png,image/webp" required
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                    <p class="text-xs text-gray-400 mt-1">Maksimal 100MB. JPEG, PNG, WebP.</p>
                </div>
                <div id="upload-progress-area" class="hidden space-y-1">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span id="progress-label">Mengupload...</span>
                        <span id="progress-pct">0%</span>
                    </div>
                    <div class="w-full bg-sky-100 rounded-full h-2 overflow-hidden">
                        <div id="progress-bar" class="bg-sky-600 h-2 rounded-full transition-all duration-300" style="width:0%"></div>
                    </div>
                </div>
                <button type="submit" id="upload-btn" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-2.5 rounded-lg font-semibold text-sm transition flex items-center justify-center gap-2">
                    <span id="upload-btn-text">Upload & Proses</span>
                    <svg id="upload-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div id="unsplash-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-sky-900">Import dari Unsplash</h3>
                <button onclick="closeModal('unsplash-modal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <form id="unsplash-form" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" id="unsplash-title" required maxlength="255"
                           class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                    <textarea id="unsplash-desc" rows="2" maxlength="1000"
                              class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Foto Unsplash</label>
                    <input type="url" id="unsplash-url" required placeholder="https://unsplash.com/photos/xxx"
                           class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                    <p class="text-xs text-gray-400 mt-1">Tempel link foto dari unsplash.com/photos/...</p>
                </div>
                <div id="unsplash-progress-area" class="hidden space-y-1">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Mengunduh & memproses...</span>
                        <span id="unsplash-progress-text">loading</span>
                    </div>
                    <div class="w-full bg-sky-100 rounded-full h-2 overflow-hidden">
                        <div id="unsplash-progress-bar" class="bg-sky-600 h-2 rounded-full" style="width:50%"></div>
                    </div>
                </div>
                <button type="submit" id="unsplash-btn" class="w-full bg-white border-2 border-sky-600 text-sky-700 hover:bg-sky-50 py-2.5 rounded-lg font-semibold text-sm transition flex items-center justify-center gap-2">
                    <span id="unsplash-btn-text">Import & Proses</span>
                    <svg id="unsplash-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div id="edit-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-sky-900">Edit Foto</h3>
                <button onclick="closeModal('edit-modal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <form id="edit-form" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" id="edit-title" required maxlength="255"
                           class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                    <textarea id="edit-desc" rows="2" maxlength="1000"
                              class="w-full px-3 py-2 border border-sky-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-2.5 rounded-lg font-semibold text-sm transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <div id="delete-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl text-center" onclick="event.stopPropagation()">
            <div class="text-4xl mb-3">🗑️</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Foto?</h3>
            <p class="text-sm text-gray-500 mb-6">Foto akan dihapus permanen. Yakin?</p>
            <input type="hidden" id="delete-id">
            <div class="flex gap-3">
                <button onclick="closeModal('delete-modal')" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-lg font-semibold text-sm transition">Batal</button>
                <button id="delete-confirm-btn" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg font-semibold text-sm transition">Hapus</button>
            </div>
        </div>
    </div>

    <div id="viewer" class="fixed inset-0 z-50 bg-black/90 hidden items-center justify-center p-4" onclick="closeViewer(event)">
        <button class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10" onclick="closeViewer()">&times;</button>
        <div class="max-w-4xl max-h-[90vh]" onclick="event.stopPropagation()">
            <img id="viewer-img" class="max-w-full max-h-[80vh] mx-auto rounded-lg" src="">
            <div class="text-center mt-4">
                <p id="viewer-title" class="text-lg font-medium text-white"></p>
                <p id="viewer-desc" class="text-sm text-gray-400"></p>
            </div>
        </div>
    </div>

    <script>
    function showToast(message, type) {
        var t = document.getElementById('toast');
        t.textContent = message;
        t.className = 'fixed top-4 right-4 z-[100] max-w-sm w-full shadow-lg rounded-lg px-4 py-3 text-sm font-medium transition-all duration-300 ';
        t.classList.add(type === 'success' ? 'bg-green-600' : 'bg-red-600', 'text-white');
        t.classList.remove('hidden');
        t.style.opacity = '1';
        t.style.transform = 'translateY(0)';
        setTimeout(function() { t.style.opacity = '0'; t.style.transform = 'translateY(-10px)'; setTimeout(function() { t.classList.add('hidden'); }, 300); }, 4000);
    }

    function renderCard(item, isAuth) {
        var desc = item.description ? '<p class="text-white/80 text-xs mt-0.5 line-clamp-1">' + item.description + '</p>' : '';
        var actions = isAuth
            ? '<div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">'
            + '<button onclick="event.stopPropagation(); editItem(' + item.id + ', \'' + item.title.replace(/'/g, "\\'") + '\', \'' + (item.description || '').replace(/'/g, "\\'") + '\')" class="bg-white/90 hover:bg-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow">'
            + '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>'
            + '</button>'
            + '<button onclick="event.stopPropagation(); deleteItem(' + item.id + ')" class="bg-white/90 hover:bg-red-500 hover:text-white text-gray-700 rounded-full w-8 h-8 flex items-center justify-center shadow">'
            + '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>'
            + '</button></div>'
            : '';
        return '<div class="gallery-card relative bg-white rounded-xl overflow-hidden shadow-sm border border-sky-100 hover:shadow-md transition group" data-id="' + item.id + '">'
            + '<div class="aspect-square min-h-[200px] bg-sky-100 overflow-hidden cursor-pointer" onclick="openViewer(\'' + item.image_url + '\', \'' + item.title.replace(/'/g, "\\'") + '\', \'' + (item.description || '').replace(/'/g, "\\'") + '\')">'
            + '<img src="' + item.thumbnail_url + '" alt="' + item.title + '" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">'
            + '</div>'
            + '<div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-3 pt-8">'
            + '<p class="text-white font-semibold text-sm leading-tight truncate">' + item.title + '</p>'
            + desc
            + '</div>'
            + actions
            + '</div>';
    }

    var isAuth = {{ auth()->check() ? 'true' : 'false' }};

    document.getElementById('upload-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var file = document.getElementById('upload-file').files[0];
        if (!file) return;

        var btn = document.getElementById('upload-btn');
        var btnText = document.getElementById('upload-btn-text');
        var spinner = document.getElementById('upload-spinner');
        var progressArea = document.getElementById('upload-progress-area');
        var progressBar = document.getElementById('progress-bar');
        var progressPct = document.getElementById('progress-pct');
        var progressLabel = document.getElementById('progress-label');

        btn.disabled = true;
        btnText.textContent = 'Mengupload...';
        spinner.classList.remove('hidden');
        progressArea.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressPct.textContent = '0%';
        progressLabel.textContent = 'Mengupload...';

        var formData = new FormData();
        formData.append('_token', document.querySelector('[name=_token]').value);
        formData.append('title', document.getElementById('upload-title').value);
        formData.append('description', document.getElementById('upload-desc').value);
        formData.append('image', file);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("galeri.upload") }}');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var pct = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = pct + '%';
                progressPct.textContent = pct + '%';
                if (pct < 100) progressLabel.textContent = 'Mengupload... ' + formatSize(e.loaded) + ' / ' + formatSize(e.total);
            }
        };

        xhr.onload = function() {
            progressLabel.textContent = 'Memproses gambar...';
            progressBar.style.width = '100%';
            progressPct.textContent = '100%';
            try {
                var res = JSON.parse(xhr.responseText);
                if (xhr.status >= 200 && xhr.status < 300 && res.success) {
                    closeModal('upload-modal');
                    addCard(res.item);
                    showToast(res.success, 'success');
                    resetUploadForm();
                } else {
                    showToast(res.error || 'Upload gagal (status ' + xhr.status + ')', 'error');
                    resetUploadButton();
                }
            } catch(e) {
                var msg = 'Gagal membaca respons server';
                if (xhr.status === 419) msg = 'Sesi habis. Silakan refresh halaman.';
                else if (xhr.status === 401) msg = 'Harus login terlebih dahulu.';
                else if (xhr.status === 422) msg = 'Data tidak valid. Periksa input.';
                showToast(msg, 'error');
                resetUploadButton();
            }
        };
        xhr.onerror = function() { showToast('Koneksi gagal. Coba lagi.', 'error'); resetUploadButton(); };
        xhr.send(formData);
    });

    function resetUploadForm() {
        document.getElementById('upload-title').value = '';
        document.getElementById('upload-desc').value = '';
        document.getElementById('upload-file').value = '';
        resetUploadButton();
        document.getElementById('upload-progress-area').classList.add('hidden');
    }

    function resetUploadButton() {
        var btn = document.getElementById('upload-btn');
        btn.disabled = false;
        document.getElementById('upload-btn-text').textContent = 'Upload & Proses';
        document.getElementById('upload-spinner').classList.add('hidden');
    }

    document.getElementById('unsplash-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('unsplash-btn');
        var btnText = document.getElementById('unsplash-btn-text');
        var spinner = document.getElementById('unsplash-spinner');
        var progressArea = document.getElementById('unsplash-progress-area');
        var progressText = document.getElementById('unsplash-progress-text');
        var progressBar = document.getElementById('unsplash-progress-bar');

        btn.disabled = true;
        btnText.textContent = 'Mengunduh...';
        spinner.classList.remove('hidden');
        progressArea.classList.remove('hidden');
        progressBar.style.width = '30%';
        progressText.textContent = 'mengunduh...';

        fetch('{{ route("galeri.unsplash") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('[name=_token]').value },
            body: JSON.stringify({ title: document.getElementById('unsplash-title').value, description: document.getElementById('unsplash-desc').value, unsplash_url: document.getElementById('unsplash-url').value })
        })
        .then(function(r) { progressBar.style.width = '70%'; progressText.textContent = 'memproses...'; return r.json(); })
        .then(function(res) {
            progressBar.style.width = '100%'; progressText.textContent = 'selesai';
            if (res.success) { closeModal('unsplash-modal'); addCard(res.item); showToast(res.success, 'success'); resetUnsplashForm(); }
            else { showToast(res.error || 'Import gagal', 'error'); resetUnsplashButton(); }
        })
        .catch(function() { showToast('Koneksi gagal. Coba lagi.', 'error'); resetUnsplashButton(); });
    });

    function resetUnsplashForm() {
        document.getElementById('unsplash-title').value = '';
        document.getElementById('unsplash-desc').value = '';
        document.getElementById('unsplash-url').value = '';
        resetUnsplashButton();
        document.getElementById('unsplash-progress-area').classList.add('hidden');
    }

    function resetUnsplashButton() {
        var btn = document.getElementById('unsplash-btn');
        btn.disabled = false;
        document.getElementById('unsplash-btn-text').textContent = 'Import & Proses';
        document.getElementById('unsplash-spinner').classList.add('hidden');
    }

    function editItem(id, title, desc) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-desc').value = desc;
        openModal('edit-modal');
    }

    document.getElementById('edit-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var id = document.getElementById('edit-id').value;
        fetch('/galeri/' + id, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('[name=_token]').value },
            body: JSON.stringify({ title: document.getElementById('edit-title').value, description: document.getElementById('edit-desc').value })
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success) { closeModal('edit-modal'); updateCard(res.item); showToast(res.success, 'success'); }
            else { showToast(res.error || 'Gagal', 'error'); }
        })
        .catch(function() { showToast('Koneksi gagal', 'error'); });
    });

    function updateCard(item) {
        var card = document.querySelector('.gallery-card[data-id="' + item.id + '"]');
        if (card) {
            var newCard = document.createElement('div');
            newCard.innerHTML = renderCard(item, isAuth);
            card.outerHTML = newCard.firstElementChild.outerHTML;
        }
    }

    function deleteItem(id) {
        document.getElementById('delete-id').value = id;
        openModal('delete-modal');
    }

    document.getElementById('delete-confirm-btn').addEventListener('click', function() {
        var id = document.getElementById('delete-id').value;
        fetch('/galeri/' + id, {
            method: 'DELETE',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('[name=_token]').value }
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success) {
                closeModal('delete-modal');
                var card = document.querySelector('.gallery-card[data-id="' + id + '"]');
                if (card) card.remove();
                showToast(res.success, 'success');
                if (document.querySelectorAll('.gallery-card').length === 0) {
                    document.getElementById('gallery-grid').innerHTML = '<p id="empty-msg" class="text-center text-sky-400 py-12 col-span-full">Belum ada foto di galeri</p>';
                }
            } else { showToast(res.error || 'Gagal', 'error'); }
        })
        .catch(function() { showToast('Koneksi gagal', 'error'); });
    });

    function addCard(item) {
        var grid = document.getElementById('gallery-grid');
        var empty = document.getElementById('empty-msg');
        if (empty) empty.remove();
        grid.insertAdjacentHTML('afterbegin', renderCard(item, isAuth));
    }

    function formatSize(bytes) {
        if (bytes < 1024) return bytes + 'B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + 'KB';
        return (bytes / 1048576).toFixed(1) + 'MB';
    }

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
        document.body.style.overflow = '';
    }
    function openViewer(src, title, desc) {
        document.getElementById('viewer-img').src = src;
        document.getElementById('viewer-title').textContent = title;
        document.getElementById('viewer-desc').textContent = desc;
        openModal('viewer');
    }
    function closeViewer(e) {
        if (e && e.target !== e.currentTarget) return;
        document.getElementById('viewer').classList.add('hidden');
        document.getElementById('viewer').classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeViewer(); closeModal('upload-modal'); closeModal('unsplash-modal'); closeModal('edit-modal'); closeModal('delete-modal'); }
    });
    document.querySelectorAll('#upload-modal, #unsplash-modal, #edit-modal, #delete-modal').forEach(function(m) {
        m.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
    });
    </script>

    @include('partials.player')
</body>
</html>

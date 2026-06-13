<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Konten - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">
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

    <div class="min-h-screen bg-gradient-to-b from-sky-50 to-white">
        <div class="relative overflow-hidden bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
            <div class="relative max-w-4xl mx-auto px-4 py-12 md:py-16 text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold">Kirim Konten</h1>
                <p class="text-white/80 mt-2 max-w-xl mx-auto">Bagikan ide, berita, atau informasi seputar Aktivitas Kabar Baik. Tulisanmu akan muncul di blog KbrBaik.</p>
            </div>
        </div>

        <div class="max-w-2xl mx-auto px-4 py-8 -mt-6 relative z-10">
            <div id="form-container" class="bg-white rounded-2xl shadow-sm border border-sky-100 p-6 md:p-8">
                <form id="submit-form" onsubmit="submitKonten(event)" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul *</label>
                        <input type="text" id="title" required
                               class="w-full px-4 py-2.5 border border-sky-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                               placeholder="Judul konten...">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <select id="category"
                                class="w-full px-4 py-2.5 border border-sky-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kamu</label>
                        <input type="text" id="author"
                               class="w-full px-4 py-2.5 border border-sky-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                               placeholder="Nama atau inisial">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Konten *</label>
                        <p class="text-xs text-gray-400 mb-2">Tulis dalam format Markdown. Bisa pakai **tebal**, *miring*, # heading, dll.</p>
                        <textarea id="body" rows="10" required
                                  class="w-full px-4 py-2.5 border border-sky-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none font-mono"
                                  placeholder="Tulis konten di sini...&#10;&#10;Gunakan Markdown:&#10;# Judul&#10;**tebal** *miring*&#10;- list item&#10;[link](url)"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar (opsional)</label>
                        <input type="file" id="image" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                    </div>

                    <div id="preview-section" class="hidden">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Pratinjau Gambar</h3>
                        <img id="preview-image" class="w-full h-48 object-cover rounded-xl">
                    </div>

                    <button type="submit" id="submit-btn"
                            class="w-full bg-sky-600 hover:bg-sky-700 text-white py-3 rounded-xl font-semibold text-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Kirim Konten
                    </button>
                </form>

                <div id="success-section" class="hidden text-center py-8">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Konten Terkirim!</h3>
                    <p class="text-gray-500 text-sm mt-1">Terima kasih! Kontenmu akan muncul di blog KbrBaik.</p>
                    <a href="{{ route('home') }}" class="inline-block mt-4 text-sm font-semibold text-sky-600 hover:text-sky-800">Kembali ke Beranda</a>
                </div>
            </div>

            <div class="mt-6 text-center text-xs text-gray-400">
                <p>Dengan mengirim konten, kamu menyetujui kontenmu ditayangkan di KbrBaik.live</p>
            </div>
        </div>
    </div>

    <footer class="bg-sky-800 text-sky-200 py-6 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $station?->name ?? 'Radio Kabar Baik' }}. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('preview-image').src = ev.target.result;
                    document.getElementById('preview-section').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        function submitKonten(e) {
            e.preventDefault();
            var btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Mengirim...';

            var formData = new FormData();
            formData.append('title', document.getElementById('title').value);
            formData.append('body', document.getElementById('body').value);
            formData.append('author', document.getElementById('author').value || 'Kontributor');
            formData.append('category_id', document.getElementById('category').value);

            var imageFile = document.getElementById('image').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            fetch('/api/autopost', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                }
            })
            .then(function(r) { return r.json(); })
            .then(function(json) {
                if (json.success) {
                    document.getElementById('form-container').innerHTML = document.getElementById('success-section').innerHTML;
                } else {
                    alert('Gagal: ' + (json.message || 'Coba lagi'));
                    btn.disabled = false;
                    btn.innerHTML = 'Kirim Konten';
                }
            })
            .catch(function() {
                alert('Terjadi gangguan. Coba lagi.');
                btn.disabled = false;
                btn.innerHTML = 'Kirim Konten';
            });
        }
    </script>
</body>
</html>

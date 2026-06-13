<?php
$f = '/var/www/radio/resources/views/kbrbaik-blog.blade.php';
$c = file_get_contents($f);

// Restructure: categories at top + full width posts
$oldSection = '    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Left: Title + Blog Posts --}}
                <div class="md:w-3/4">
                    <h1 class="text-4xl font-bold mb-8 text-sky-900">Kabar Baik Untuk Semua</h1>

                    <div id="posts-loading" class="text-center py-12">
                        <svg class="animate-spin h-8 w-8 text-sky-400 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6 hidden" id="posts-grid"></div>
                    <div id="posts-empty" class="text-center py-12 text-sky-400 hidden">Belum ada postingan.</div>
                </div>

                {{-- Right: Category Tabs --}}
                <div class="md:w-1/4">
                    <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                        <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Kategori</h3>
                        <div id="tab-container" class="space-y-2"></div>
                        <button id="btn-semua" onclick="switchTab('semua')" class="mt-3 flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm font-semibold bg-sky-800 text-white hover:bg-sky-700 transition w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            Semua
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>';

$newSection = '    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-6 text-sky-900">Kabar Baik Untuk Semua</h1>

            <div class="flex flex-wrap gap-2 mb-8" id="tab-container"></div>
            <button id="btn-semua" onclick="switchTab('semua')" class="hidden">Semua</button>

            <div id="posts-loading" class="text-center py-12">
                <svg class="animate-spin h-8 w-8 text-sky-400 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 hidden" id="posts-grid"></div>
            <div id="posts-empty" class="text-center py-12 text-sky-400 hidden">Belum ada postingan.</div>
        </div>
    </section>';

$c = str_replace($oldSection, $newSection, $c);

// Change default category to 'semua'
$c = str_replace("var currentCategory = 'kabar';", "var currentCategory = 'semua';", $c);

// Change initial fetch to 'semua'
$c = str_replace("fetchPosts('kabar');", "fetchPosts('semua');", $c);

// Update switchTab for horizontal layout
$c = str_replace(
    "function switchTab(slug) {
        currentCategory = slug;
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            var isActive = btn.dataset.category === slug;
            btn.classList.toggle('bg-sky-800', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('text-sky-700', !isActive);
            btn.classList.toggle('bg-white', !isActive);
        });
        // Reset 'Semua' button active state
        var semuaBtn = document.getElementById('btn-semua');
        if (slug === 'semua') {
            semuaBtn.classList.add('ring-2', 'ring-sky-400');
        } else {
            semuaBtn.classList.remove('ring-2', 'ring-sky-400');
        }
        fetchPosts(slug);
    }",
    "function switchTab(slug) {
        currentCategory = slug;
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            var isActive = btn.dataset.category === slug;
            btn.classList.toggle('bg-sky-800', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('bg-sky-50', !isActive);
            btn.classList.toggle('text-sky-600', !isActive);
        });
        fetchPosts(slug);
    }",
    $c
);

// Update tab creation for horizontal layout
$c = str_replace(
    "btn.className = 'tab-btn flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-left';",
    "btn.className = 'tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200';",
    $c
);
$c = str_replace(
    "if (i === 0) { btn.classList.add('bg-sky-800', 'text-white'); }
                else { btn.classList.add('bg-white', 'text-sky-700', 'border', 'border-sky-200'); }",
    "if (i === 0 && currentCategory === 'semua') { btn.classList.add('bg-sky-800', 'text-white'); }
                else if (slug === 'semua' && i === 0) { btn.classList.add('bg-sky-50', 'text-sky-600'); }
                else { btn.classList.add('bg-sky-50', 'text-sky-600'); }",
    $c
);

// Make the first tab active since 'semua' is default
$c = str_replace(
    "cats.forEach(function(c, i) {",
    "cats.unshift({slug:'semua',name:'Semua',id:0});
            cats.forEach(function(c, i) {",
    $c
);

// Fix first tab condition
$c = str_replace(
    "if (i === 0 && currentCategory === 'semua') { btn.classList.add('bg-sky-800', 'text-white'); }
                else if (slug === 'semua' && i === 0) { btn.classList.add('bg-sky-50', 'text-sky-600'); }
                else { btn.classList.add('bg-sky-50', 'text-sky-600'); }",
    "if (i === 0) { btn.classList.add('bg-sky-800', 'text-white'); }
                else { btn.classList.add('bg-sky-50', 'text-sky-600'); }",
    $c
);

file_put_contents($f, $c);
echo "OK\n";

<?php
$f = '/var/www/radio/resources/views/kbrbaik-blog.blade.php';
$c = file_get_contents($f);

$oldSection = '    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-6 text-sky-900">Kabar Baik Untuk Semua</h1>

            <div class="flex flex-wrap gap-2 mb-8" id="tab-container"></div>
            <button id="btn-semua" onclick="switchTab(\'semua\')" class="hidden">Semua</button>

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

$newSection = '    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-3/4 order-2 md:order-1">
                    <h1 class="text-4xl font-bold mb-8 text-sky-900">Kabar Baik Untuk Semua</h1>

                    <div id="posts-loading" class="text-center py-12">
                        <svg class="animate-spin h-8 w-8 text-sky-400 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden" id="posts-grid"></div>
                    <div id="posts-empty" class="text-center py-12 text-sky-400 hidden">Belum ada postingan.</div>
                    <div id="posts-nav" class="flex items-center justify-center gap-4 mt-8 hidden"></div>
                </div>

                <div class="md:w-1/4 order-1 md:order-2">
                    <div class="md:sticky md:top-6 bg-sky-50 rounded-xl p-5 border border-sky-100">
                        <h3 class="text-sm font-bold text-sky-800 uppercase tracking-widest mb-4">Kategori</h3>
                        <div id="tab-container" class="space-y-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>';

$c = str_replace($oldSection, $newSection, $c);

// Update tab buttons to vertical style
$c = str_replace(
    "btn.className = 'tab-btn px-5 py-2 rounded-t-lg text-sm font-semibold transition-all duration-200';",
    "btn.className = 'tab-btn flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-left';",
    $c
);
$c = str_replace(
    "if (i === 0) { btn.classList.add('bg-sky-800', 'text-white'); }
                else { btn.classList.add('bg-sky-50', 'text-sky-600'); }",
    "if (i === 0) { btn.classList.add('bg-sky-800', 'text-white'); }
                else { btn.classList.add('bg-white', 'text-sky-700', 'border', 'border-sky-200'); }",
    $c
);
$c = str_replace(
    "btn.classList.toggle('bg-sky-50', !isActive);
            btn.classList.toggle('text-sky-600', !isActive);",
    "btn.classList.toggle('bg-white', !isActive);
            btn.classList.toggle('text-sky-700', !isActive);
            btn.classList.toggle('border', !isActive);
            btn.classList.toggle('border-sky-200', !isActive);",
    $c
);

file_put_contents($f, $c);
echo "OK\n";

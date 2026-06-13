<?php
$f = '/var/www/radio/resources/views/home.blade.php';
$c = file_get_contents($f);

$old = '<div class="text-center mb-4">
                <span class="text-xs font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-600">Wiki Kabar Baik</span>
                <h2 class="text-3xl font-bold text-sky-900 mt-3">Aktivitas Kabar Baik</h2>
                <p class="text-gray-500 mt-2 max-w-2xl mx-auto">Bukan sekadar pendengar — jadilah bagian dari komunitas yang menciptakan, berbagi, dan menghidupkan kabar baik.</p>
            </div>';

$new = '<div class="flex items-start justify-between mb-4">
                <div class="flex-1 text-center">
                    <span class="text-xs font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-600">Wiki Kabar Baik</span>
                    <h2 class="text-3xl font-bold text-sky-900 mt-3">Aktivitas Kabar Baik</h2>
                    <p class="text-gray-500 mt-2 max-w-2xl mx-auto">Bukan sekadar pendengar — jadilah bagian dari komunitas yang menciptakan, berbagi, dan menghidupkan kabar baik.</p>
                </div>
                <a href="{{ route(\'services\') }}" class="shrink-0 text-sky-400 hover:text-sky-600 transition mt-2" title="Buka Wiki">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </a>
            </div>';

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";

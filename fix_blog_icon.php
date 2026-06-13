<?php
$f = '/var/www/radio/resources/views/home.blade.php';
$c = file_get_contents($f);

$old = '<div class="text-center mb-8">
            <div>
                <span class="text-xs font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-600">Inspirasi dan Narasi Kabar Baik</span>
                <h2 class="text-3xl font-bold text-sky-900 mt-3">Mata dan Telinga bagi Kabar Baik</h2>
            </div>
        </div>';

$new = '<div class="flex items-start justify-between mb-8">
            <div class="flex-1 text-center">
                <span class="text-xs font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-600">Inspirasi dan Narasi Kabar Baik</span>
                <h2 class="text-3xl font-bold text-sky-900 mt-3">Mata dan Telinga bagi Kabar Baik</h2>
            </div>
            <a href="{{ route(\'kbrbaik.blog\') }}" class="shrink-0 text-sky-400 hover:text-sky-600 transition mt-2" title="Buka Blog">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
            </a>
        </div>';

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";

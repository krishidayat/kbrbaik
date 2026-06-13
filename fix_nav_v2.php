<?php
$f = '/var/www/radio/resources/views/layouts/suara.blade.php';
$lines = file($f);
$out = [];

foreach ($lines as $i => $line) {
    // Desktop nav: Beranda link -> dropdown
    if (strpos($line, '<a href="{{ route(\'home\') }}" class="hover:text-primary-200 transition">Beranda</a>') !== false) {
        // Check if next non-empty line is Agenda
        $next = isset($lines[$i+1]) ? trim($lines[$i+1]) : '';
        $next2 = isset($lines[$i+2]) ? trim($lines[$i+2]) : '';
        if (strpos($next, 'Agenda') !== false || strpos($next2, 'Agenda') !== false) {
            $out[] = '                    <div class="relative group">' . "\n";
            $out[] = '                        <a href="{{ route(\'home\') }}" class="hover:text-primary-200 transition">Beranda <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></a>' . "\n";
            $out[] = '                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 py-1 hidden group-hover:block z-50">' . "\n";
            $out[] = '                            <a href="{{ route(\'laporan\') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Laporan</a>' . "\n";
            $out[] = '                            <a href="{{ route(\'program.kerja\') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Program Kerja</a>' . "\n";
            $out[] = '                        </div>' . "\n";
            $out[] = '                    </div>';
            continue;
        }
    }

    // Mobile nav: add sub-items after Beranda
    if (strpos($line, 'class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Beranda</a>') !== false) {
        $out[] = $line;
        $out[] = '                <a href="{{ route(\'laporan\') }}" class="block px-3 py-1 pl-6 text-sm text-primary-200 hover:text-white transition">— Laporan</a>' . "\n";
        $out[] = '                <a href="{{ route(\'program.kerja\') }}" class="block px-3 py-1 pl-6 text-sm text-primary-200 hover:text-white transition">— Program Kerja</a>';
        continue;
    }

    $out[] = $line;
}

file_put_contents($f, implode('', $out));
echo "OK\n";

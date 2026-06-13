<?php
$f = '/var/www/radio/resources/views/layouts/suara.blade.php';
$c = file_get_contents($f);

// Desktop nav - add @auth around laporan & program-kerja
$c = str_replace(
    ' <a href="{{ route(\'laporan\') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Laporan</a> <a href="{{ route(\'program.kerja\') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Program Kerja</a> ',
    ' @auth <a href="{{ route(\'laporan\') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Laporan</a> <a href="{{ route(\'program.kerja\') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Program Kerja</a> @endauth ',
    $c
);

// Mobile nav
$c = str_replace(
    '<a href="{{ route(\'laporan\') }}" class="block px-3 py-1 pl-6 text-sm text-primary-200 hover:text-white transition">- Laporan</a>
                <a href="{{ route(\'program.kerja\') }}" class="block px-3 py-1 pl-6 text-sm text-primary-200 hover:text-white transition">- Program Kerja</a>',
    '@auth
                <a href="{{ route(\'laporan\') }}" class="block px-3 py-1 pl-6 text-sm text-primary-200 hover:text-white transition">- Laporan</a>
                <a href="{{ route(\'program.kerja\') }}" class="block px-3 py-1 pl-6 text-sm text-primary-200 hover:text-white transition">- Program Kerja</a>
                @endauth',
    $c
);

file_put_contents($f, $c);
echo "OK\n";

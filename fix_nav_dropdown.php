<?php
$f = '/var/www/radio/resources/views/layouts/suara.blade.php';
$c = file_get_contents($f);

$old = '<a href="' . "'" . "{{ route('home') }}" . "'" . '" class="hover:text-primary-200 transition">Beranda</a>
                    <a href="' . "'" . "{{ route('agenda') }}" . "'" . '"';

$new = '<div class="relative group">
                        <a href="' . "'" . "{{ route('home') }}" . "'" . '" class="hover:text-primary-200 transition">Beranda</a>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 hidden group-hover:block z-50">
                            <a href="' . "'" . "{{ route('home') }}" . "'" . '" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Beranda</a>
                            <hr class="border-gray-100">
                            <a href="' . "'" . "{{ route('program.kerja') }}" . "'" . '" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Program Kerja</a>
                            <a href="' . "'" . "{{ route('laporan') }}" . "'" . '" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">Laporan</a>
                        </div>
                    </div>
                    <a href="' . "'" . "{{ route('agenda') }}" . "'" . '"';

$c = str_replace($old, $new, $c);

// Mobile nav
$old2 = '<a href="' . "'" . "{{ route('home') }}" . "'" . '" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Beranda</a>
                <a href="' . "'" . "{{ route('agenda') }}" . "'" . '"';

$new2 = '<a href="' . "'" . "{{ route('home') }}" . "'" . '" class="block px-3 py-2 rounded-lg hover:bg-primary-600 transition">Beranda</a>
                <a href="' . "'" . "{{ route('program.kerja') }}" . "'" . '" class="block px-3 py-1 pl-6 text-sm text-primary-200 hover:text-white transition">- Program Kerja</a>
                <a href="' . "'" . "{{ route('laporan') }}" . "'" . '" class="block px-3 py-1 pl-6 text-sm text-primary-200 hover:text-white transition">- Laporan</a>
                <a href="' . "'" . "{{ route('agenda') }}" . "'" . '"';

$c = str_replace($old2, $new2, $c);

file_put_contents($f, $c);
echo "OK\n";

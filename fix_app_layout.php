<?php
$f = '/var/www/radio/resources/views/layouts/app.blade.php';
$c = file_get_contents($f);

$c = str_replace(
    "colors: { primary: { 50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 950: '#1e1b4b' }",
    "colors: { primary: { 50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e', 950: '#082f49' }",
    $c
);

// Update desktop nav
$old = "<a href=\"{{ route('home') }}\" class=\"hover:text-primary-200 transition\">Beranda</a>
                    <a href=\"{{ route('komunitas') }}\" class=\"hover:text-primary-200 transition\">Komunitas</a>
                    @auth
                    <a href=\"{{ route('profil') }}\" class=\"hover:text-primary-200 transition\">{{ auth()->user()->name }}</a>
                    <form method=\"POST\" action=\"{{ route('logout') }}\" class=\"inline\">
                        @csrf
                        <button type=\"submit\" class=\"hover:text-primary-200 transition\">Keluar</button>
                    </form>
                    @else
                    <a href=\"{{ route('masuk') }}\" class=\"hover:text-primary-200 transition\">Masuk</a>
                    @endauth";

$new = "<a href=\"{{ route('home') }}\" class=\"hover:text-sky-200 transition\">Beranda</a>
                    <a href=\"{{ route('kbrbaik.blog') }}\" class=\"hover:text-sky-200 transition\">Narasi</a>
                    <a href=\"{{ route('komunitas') }}\" class=\"hover:text-sky-200 transition\">Komunitas</a>
                    <a href=\"{{ route('pelatihan') }}\" class=\"hover:text-sky-200 transition\">Pelatihan</a>
                    <a href=\"{{ route('radio') }}\" class=\"hover:text-sky-200 transition\">Radio</a>";

$c = str_replace($old, $new, $c);

// Update mobile nav
$oldMobile = "<a href=\"{{ route('home') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-primary-600 transition\">Beranda</a>
                <a href=\"{{ route('komunitas') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-primary-600 transition\">Komunitas</a>
                @auth
                <a href=\"{{ route('profil') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-primary-600 transition\">{{ auth()->user()->name }}</a>
                <form method=\"POST\" action=\"{{ route('logout') }}\">
                    @csrf
                    <button type=\"submit\" class=\"block w-full text-left px-3 py-2 rounded-lg hover:bg-primary-600 transition\">Keluar</button>
                </form>
                @else
                <a href=\"{{ route('masuk') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-primary-600 transition\">Masuk</a>
                @endauth";

$newMobile = "<a href=\"{{ route('home') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm\">Beranda</a>
                <a href=\"{{ route('kbrbaik.blog') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm\">Narasi</a>
                <a href=\"{{ route('komunitas') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm\">Komunitas</a>
                <a href=\"{{ route('pelatihan') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm\">Pelatihan</a>
                <a href=\"{{ route('radio') }}\" class=\"block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm\">Radio</a>";

$c = str_replace($oldMobile, $newMobile, $c);

file_put_contents($f, $c);
echo "OK\n";

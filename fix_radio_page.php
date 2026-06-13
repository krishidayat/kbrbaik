<?php
$html = '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio - ' . "{{ \$station?->name ?? 'KBRBaik' }}" . '</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>function toggleMobileMenu(){document.getElementById(\'mobile-menu\').classList.toggle(\'hidden\')}</script>
    <style>
        .waveform-bar{width:3px;background:rgba(255,255,255,0.3);border-radius:2px;animation:wave 1s ease-in-out infinite}
        .waveform-bar:nth-child(2){animation-delay:0.1s;height:60%}
        .waveform-bar:nth-child(3){animation-delay:0.2s;height:80%}
        .waveform-bar:nth-child(4){animation-delay:0.3s;height:40%}
        .waveform-bar:nth-child(5){animation-delay:0.4s;height:70%}
        @keyframes wave{0%,100%{height:20%}50%{height:90%}}
    </style>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="' . "{{ route('home') }}" . '" class="flex items-center gap-2">
                <img src="' . "{{ asset('images/kbrbaik-logo.png') }}" . '" alt="KBRBaik" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight">Radio KbrBaik</span>
            </a>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="hidden md:flex space-x-6 text-sm">
                <a href="' . "{{ route('home') }}" . '" class="hover:text-sky-200 transition">Beranda</a>
                <a href="' . "{{ route('komunitas') }}" . '" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="' . "{{ route('pelatihan') }}" . '" class="hover:text-sky-200 transition">Pelatihan</a>
                <a href="' . "{{ route('radio') }}" . '" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="' . "{{ route('home') }}" . '" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="' . "{{ route('komunitas') }}" . '" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="' . "{{ route('pelatihan') }}" . '" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="' . "{{ route('radio') }}" . '" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>
    </nav>

    <div class="relative overflow-hidden bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
        <div class="max-w-6xl mx-auto px-4 py-12 text-center">
            <h1 class="text-4xl md:text-5xl font-bold">Radio KbrBaik</h1>
            <p class="text-sky-100 mt-2">Siaran musik, renungan, dan informasi dari komunitas</p>
        </div>
    </div>

    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white rounded-2xl border border-sky-200 overflow-hidden shadow-sm mb-8">
                <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4 text-center">
                    <h2 class="text-lg font-bold">Siaran Langsung</h2>
                    <p class="text-sm text-sky-200">Streaming 24 jam</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-center gap-1 h-16 mb-6">
                        <div class="waveform-bar"></div><div class="waveform-bar"></div><div class="waveform-bar"></div><div class="waveform-bar"></div><div class="waveform-bar"></div>
                    </div>
                    <div class="flex items-center justify-center gap-4">
                        <audio controls class="w-full max-w-md" preload="none">
                            <source src="https://radio.kbrbaik.live/stream" type="audio/mpeg">
                        </audio>
                    </div>
                    <div id="now-playing" class="text-center mt-4">
                        <p class="text-sm text-gray-500" id="metadata">Memuat metadata siaran...</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-sky-200 overflow-hidden shadow-sm">
                <div class="bg-gradient-to-r from-sky-600 to-sky-700 text-white px-6 py-4 text-center">
                    <h2 class="text-lg font-bold">Jadwal Siaran</h2>
                </div>
                <div class="p-6">
                    <iframe src="https://radio.kbrbaik.live" class="w-full" height="600" frameborder="0" style="border-radius:8px"></iframe>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-sky-800 text-sky-200 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center text-sm">
            <p>&copy; ' . "{{ date('Y') }}" . ' Radio KbrBaik</p>
        </div>
    </footer>

    ' . "@include('partials.player')" . '

    <script>
    fetch(\'https://radio.kbrbaik.live/status-json.xsl\')
        .then(function(r){return r.json()})
        .then(function(d){
            var s = d.icestats.source;
            var title = s.title || \'Siaran Langsung\';
            document.getElementById(\'metadata\').textContent = title;
        })
        .catch(function(){document.getElementById(\'metadata\').textContent = \'Siaran Langsung\';});
    </script>
</body>
</html>';

file_put_contents('/var/www/radio/resources/views/kbrbaik-radio.blade.php', $html);
echo "OK\n";

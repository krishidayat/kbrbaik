<?php
$content = <<<'HTML'
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Bergabung - KBRBaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-sky-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full">
        @if (session("error"))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">{{ session("error") }}</div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-sky-100 overflow-hidden">
            <div class="bg-gradient-to-r from-sky-600 to-sky-700 px-6 py-6 text-center text-white">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold">Undangan Bergabung</h1>
                <p class="text-sky-200 text-sm mt-1">{{ $community->name }}</p>
            </div>

            <div class="p-6 space-y-4">
                <div class="text-center">
                    <p class="text-gray-600">
                        <strong>{{ $inviter->name }}</strong> mengundang Anda untuk bergabung
                        @if ($studio)
                            di studio <strong>{{ $studio->name }}</strong>
                        @endif
                        sebagai <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded
                            @if($invitation->role === "pengelola") bg-sky-100 text-sky-600
                            @else bg-green-100 text-green-600
                            @endif">{{ ucfirst($invitation->role) }}</span>
                    </p>
                    <p class="text-sm text-gray-400 mt-2">{{ $community->description ?? "Komunitas " . $community->name }}</p>
                </div>

                @if ($invitation->message)
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-800">
                    <p class="font-semibold text-xs uppercase tracking-wide mb-1">Pesan dari {{ $inviter->name }}</p>
                    <p>{{ $invitation->message }}</p>
                </div>
                @endif

                @if (auth()->check())
                    <form method="POST" action="{{ route("kredensi.undangan.terima", $invitation->token) }}">
                        @csrf
                        <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 rounded-xl transition">
                            Terima Undangan
                        </button>
                    </form>
                    <p class="text-xs text-center text-gray-400">Atau <a href="{{ route("kredensi") }}" class="text-sky-600 hover:underline">kembali ke dashboard</a></p>
                @else
                    <div class="border-t border-gray-100 pt-4">
                        <h2 class="text-sm font-semibold text-gray-700 mb-3">Lengkapi data untuk bergabung</h2>
                        <form method="POST" action="{{ route("kredensi.undangan.terima", $invitation->token) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                                <input type="email" value="{{ $invitation->email }}" disabled class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 text-sm">
                                <p class="text-xs text-gray-400 mt-1">Email sudah ditentukan oleh pengundang</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap *</label>
                                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Password *</label>
                                <input type="password" name="password" required minlength="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Konfirmasi Password *</label>
                                <input type="password" name="password_confirmation" required minlength="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">No. HP (opsional)</label>
                                <input type="text" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                            </div>
                            <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 rounded-xl transition">
                                Daftar & Terima Undangan
                            </button>
                        </form>
                        <p class="text-xs text-center text-gray-400 mt-3">
                            Sudah punya akun? <a href="{{ route("kredensi") }}" class="text-sky-600 hover:underline">Login di sini</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
HTML;
file_put_contents("/var/www/radio/resources/views/kredensi-undangan.blade.php", $content);
echo "View created: " . strlen($content) . " bytes\n";

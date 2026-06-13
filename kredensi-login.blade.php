<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kredensi - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-14 mx-auto">
            <h1 class="text-2xl font-bold text-white mt-4">Kredensi Anggota Studio</h1>
            <p class="text-sky-200 text-sm mt-1">Masuk untuk menulis narasi dan mengelola konten</p>
        </div>

        @if (session('error'))
        <div class="bg-red-500/10 border border-red-400/30 text-red-200 px-4 py-3 rounded-lg text-sm mb-4">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('kredensi.login') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none" placeholder="Password">
                    </div>
                    <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-3 rounded-xl font-semibold text-sm transition">Masuk</button>
                </div>
            </form>
            <p class="text-center text-xs text-gray-400 mt-6">Belum punya akun? Hubungi admin studio.</p>
        </div>
    </div>
</body>
</html>

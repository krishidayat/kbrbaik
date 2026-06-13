<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - {{ $station?->name ?? 'KBRBaik' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
    <style>
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .faq-answer.open { max-height: 500px; }
        .chat-msg { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        .typing-dot { animation: typingBounce 1.2s infinite; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typingBounce { 0%,60%,100% { transform: translateY(0); } 30% { transform: translateY(-6px); } }
    </style>
</head>
<body class="bg-sky-50 text-gray-900 min-h-screen">
    <nav class="bg-sky-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/kbrbaik-logo.png') }}" alt="KBRBaik" class="h-9 w-auto">
                <span class="text-lg font-bold tracking-tight">Radio KbrBaik</span>
            </a>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-sky-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="hidden md:flex space-x-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition">Beranda</a>
                <a href="{{ route('agenda') }}" class="hover:text-sky-200 transition">Agenda</a>
                <a href="{{ route('komunitas') }}" class="hover:text-sky-200 transition">Komunitas</a>
                <a href="{{ route('services') }}" class="hover:text-sky-200 transition">Layanan</a>
                <a href="{{ route('pelatihan') }}" class="hover:text-sky-200 transition">Pelatihan</a>
                <a href="{{ route('galeri') }}" class="hover:text-sky-200 transition">Galeri</a>
                <a href="{{ route('radio') }}" class="hover:text-sky-200 transition">Radio</a>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Beranda</a>
            <a href="{{ route('agenda') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Agenda</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Komunitas</a>
            <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Layanan</a>
            <a href="{{ route('pelatihan') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Pelatihan</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Galeri</a>
            <a href="{{ route('radio') }}" class="block px-3 py-2 rounded-lg hover:bg-sky-700 transition text-sm">Radio</a>
        </div>
    </nav>

    <div class="min-h-screen bg-sky-50">
        <div class="relative overflow-hidden bg-gradient-to-br from-sky-400 via-sky-500 to-sky-700 text-white">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(255,255,255,0.08),transparent_60%)]"></div>
            <div class="absolute top-1/4 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="relative max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-20">
                <div class="flex flex-col md:flex-row md:items-center gap-8">
                    <div class="md:w-1/2">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-[10px] font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white">Platform AI Otonom v1.2</span>
                            <span class="text-[10px] font-mono px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white/80">#AktivitasKbrBaik</span>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-display font-extrabold tracking-tight leading-[1.1] text-white">
                            Aktivitas <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-sky-200">Kabar Baik</span>
                        </h1>
                        <p class="text-sm md:text-base text-white/80 leading-relaxed mt-3">Empat area pencapaian besar yang menaungi seluruh aktivitas KbrBaik.live</p>
                    </div>
                    <div class="md:w-1/2 flex items-center justify-center gap-6">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-sky-300/30 to-sky-400/30 border border-white/20 flex items-center justify-center backdrop-blur-sm hover:bg-white/20 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 0 2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128m0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"/></svg>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-300/30 to-indigo-400/30 border border-white/20 flex items-center justify-center backdrop-blur-sm hover:bg-white/20 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-300/30 to-amber-400/30 border border-white/20 flex items-center justify-center backdrop-blur-sm hover:bg-white/20 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z"/></svg>
                        </div>
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-300/30 to-purple-400/30 border border-white/20 flex items-center justify-center backdrop-blur-sm hover:bg-white/20 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 pb-12 -mt-6 relative z-10">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Left Column: FAQ (2/3) --}}
                <div class="md:w-2/3 space-y-4" id="faq-section">
                    <div class="text-center mb-8">
                        <span class="text-[10px] font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-600">TANYA JAWAB</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mt-3">Yang Ingin Kamu Tahu</h2>
                        <p class="text-gray-500 text-sm mt-1">Klik pertanyaan untuk melihat jawaban.</p>
                    </div>

                    <div id="faq-container" class="space-y-4"></div>
                </div>

                {{-- Right Column: Chat Assistant (1/3, sticky on desktop) --}}
                <div class="md:w-1/3" id="chat-section">
                    <div class="md:sticky md:top-6 space-y-4">
                        <div class="text-center mb-4">
                            <span class="text-[10px] font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-600">ASISTEN WIKI</span>
                            <h2 class="text-xl font-extrabold text-gray-900 mt-2">Tanya KbrBaik Wiki</h2>
                            <p class="text-gray-500 text-xs mt-1">Cari jawaban dari wiki pengetahuan KbrBaik.</p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-sky-100 overflow-hidden">
                            <div id="chat-messages" class="h-72 overflow-y-auto p-4 space-y-3 bg-gradient-to-b from-sky-50/50 to-white">
                                <div class="chat-msg flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-sky-600 flex items-center justify-center text-white text-xs font-bold shrink-0">W</div>
                                    <div class="bg-white border border-sky-100 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm max-w-[80%]">
                                        <p class="text-sm text-gray-700">Halo! Tanyakan apa pun tentang aktivitas atau program KbrBaik. Saya akan mencari jawaban dari Wiki.</p>
                                    </div>
                                </div>
                            </div>

                            <div id="chat-suggestions" class="px-4 pb-2 flex flex-wrap gap-2 border-t border-sky-100 pt-3">
                                <span class="text-xs text-gray-400 mr-1 self-center">Coba tanya:</span>
                                <button onclick="askChat('Apa itu Kabar Media AI?')" class="text-xs bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-1.5 rounded-full border border-sky-200 transition">Apa itu Kabar Media AI?</button>
                                <button onclick="askChat('Apa itu Hermes Agent?')" class="text-xs bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-1.5 rounded-full border border-sky-200 transition">Apa itu Hermes Agent?</button>
                                <button onclick="askChat('Bagaimana cara bergabung?')" class="text-xs bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-1.5 rounded-full border border-sky-200 transition">Bagaimana cara bergabung?</button>
                                <button onclick="askChat('Program podcast')" class="text-xs bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-1.5 rounded-full border border-sky-200 transition">Program podcast</button>
                                <button onclick="askChat('WikiAI PGIW')" class="text-xs bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-1.5 rounded-full border border-sky-200 transition">WikiAI PGIW</button>
                                <button onclick="askChat('Pelatihan')" class="text-xs bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-1.5 rounded-full border border-sky-200 transition">Pelatihan</button>
                            </div>

                            <div class="border-t border-sky-100 p-4 flex gap-2">
                                <input type="text" id="chat-input" placeholder="Ketik pertanyaan..." class="flex-1 px-4 py-2.5 border border-sky-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
                                       onkeydown="if(event.key==='Enter') sendChat()">
                                <button onclick="sendChat()" class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                    Kirim
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFaq(idx) {
            var answer = document.getElementById('faq-' + idx);
            var chevron = answer.previousElementSibling.querySelector('.faq-chevron');
            var isOpen = answer.classList.toggle('open');
            chevron.style.transform = isOpen ? 'rotate(180deg)' : '';
            document.querySelectorAll('.faq-answer').forEach(function(el, i) {
                if (i !== idx && el.classList.contains('open')) {
                    el.classList.remove('open');
                    el.previousElementSibling.querySelector('.faq-chevron').style.transform = '';
                }
            });
        }

        var chatMessages = document.getElementById('chat-messages');
        var chatInput = document.getElementById('chat-input');

        function addMessage(text, isUser) {
            var div = document.createElement('div');
            div.className = 'chat-msg flex items-start gap-3 ' + (isUser ? 'flex-row-reverse' : '');
            var avatar = document.createElement('div');
            avatar.className = 'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 ' +
                (isUser ? 'bg-sky-200 text-sky-700' : 'bg-sky-600 text-white');
            avatar.textContent = isUser ? 'K' : 'W';
            var bubble = document.createElement('div');
            bubble.className = (isUser
                ? 'bg-sky-600 text-white rounded-2xl rounded-tr-sm px-4 py-3 shadow-sm max-w-[80%]'
                : 'bg-white border border-sky-100 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm max-w-[80%]');
            bubble.innerHTML = '<p class="text-sm">' + text + '</p>';
            div.appendChild(avatar);
            div.appendChild(bubble);
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTyping() {
            var div = document.createElement('div');
            div.id = 'typing-indicator';
            div.className = 'chat-msg flex items-start gap-3';
            div.innerHTML = '<div class="w-8 h-8 rounded-full bg-sky-600 flex items-center justify-center text-white text-xs font-bold shrink-0">W</div>'
                + '<div class="bg-white border border-sky-100 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm">'
                + '<div class="flex gap-1"><div class="typing-dot w-2 h-2 bg-sky-400 rounded-full"></div>'
                + '<div class="typing-dot w-2 h-2 bg-sky-400 rounded-full"></div>'
                + '<div class="typing-dot w-2 h-2 bg-sky-400 rounded-full"></div></div></div>';
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function hideTyping() {
            var el = document.getElementById('typing-indicator');
            if (el) el.remove();
        }

        function askChat(text) {
            chatInput.value = text;
            sendChat();
        }

        function sendChat() {
            var text = chatInput.value.trim();
            if (!text || text.length < 2) return;
            addMessage(escapeHtml(text), true);
            chatInput.value = '';
            showTyping();

            fetch('/api/wiki/search?q=' + encodeURIComponent(text))
                .then(function(r) { return r.json(); })
                .then(function(json) {
                    hideTyping();
                    var results = json.results || [];
                    if (results.length === 0) {
                        addMessage('Maaf, saya belum menemukan jawaban dari wiki untuk "' + escapeHtml(text) + '". Coba gunakan kata kunci lain atau tanyakan ke admin.', false);
                    } else {
                        var html = '<p class="text-sm text-gray-700 mb-2">Dari KbrBaik Wiki, saya temukan:</p>';
                        results.slice(0, 3).forEach(function(r) {
                            html += '<div class="mb-2 pb-2 border-b border-sky-100 last:border-0">'
                                + '<a href="' + r.url + '" target="_blank" class="font-semibold text-sm text-sky-700 hover:text-sky-900">' + escapeHtml(r.title) + '</a>'
                                + '<p class="text-xs text-gray-500 mt-0.5">' + escapeHtml(r.excerpt) + '...</p>'
                                + '</div>';
                        });
                        addMessage(html, false);
                    }
                })
                .catch(function() {
                    hideTyping();
                    addMessage('Maaf, terjadi gangguan. Silakan coba lagi nanti.', false);
                });
        }

        function escapeHtml(text) {
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function loadLayanan() {
            var container = document.getElementById('faq-container');
            if (!container) return;
            var loading = '<div class="text-center py-8"><div class="animate-spin w-8 h-8 border-4 border-sky-200 border-t-sky-600 rounded-full mx-auto"></div><p class="text-sm text-gray-400 mt-3">Memuat aktivitas...</p></div>';
            container.innerHTML = loading;
            fetch('/api/layanan/aktivitas')
                .then(function(r) { return r.json(); })
                .then(function(json) {
                    container.innerHTML = '';
                    json.data.forEach(function(faq, idx) {
                        var c = faq.color;
                        var card = '<div class="bg-white rounded-xl border border-' + c + '-200 overflow-hidden shadow-sm hover:shadow-md transition">'
                            + '<div class="p-5 cursor-pointer faq-header" onclick="toggleFaq(' + idx + ')">'
                            + '<div class="flex items-start gap-4">'
                            + '<div class="w-14 h-14 rounded-lg bg-gradient-to-br from-' + c + '-100 to-' + c + '-50 flex items-center justify-center shrink-0 border border-' + c + '-100">'
                            + '<svg class="w-7 h-7 text-' + c + '-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="' + faq.icon + '"/></svg>'
                            + '</div>'
                            + '<div class="flex-1">'
                            + '<span class="text-[10px] font-mono font-bold uppercase tracking-widest text-' + c + '-500">' + escapeHtml(faq.badge) + '</span>'
                            + '<h3 class="text-lg font-bold text-gray-900 mt-0.5">' + escapeHtml(faq.title) + '</h3>'
                            + '</div>'
                            + '<svg class="w-5 h-5 text-gray-400 mt-2 transition-transform faq-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>'
                            + '</div>'
                            + '</div>'
                            + '<div class="faq-answer" id="faq-' + idx + '">'
                            + '<div class="px-5 pb-5 space-y-3 border-t border-' + c + '-100 pt-4">';
                        faq.faqs.forEach(function(qa) {
                            card += '<div class="bg-' + c + '-50 rounded-lg p-4">'
                                + '<p class="font-semibold text-sm text-gray-900 flex items-start gap-2">'
                                + '<svg class="w-4 h-4 text-' + c + '-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>'
                                + escapeHtml(qa.q)
                                + '</p>'
                                + '<p class="text-sm text-gray-600 mt-2 pl-6">' + escapeHtml(qa.a) + '</p>'
                                + '</div>';
                        });
                        card += '</div></div></div>';
                        container.innerHTML += card;
                    });
                })
                .catch(function() {
                    container.innerHTML = '<div class="text-center py-8"><p class="text-sm text-red-400">Gagal memuat data aktivitas. Coba refresh halaman.</p></div>';
                });
        }
        loadLayanan();
    </script>
</body>
</html>

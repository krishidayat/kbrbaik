@php
$stations = \App\Models\Station::where('is_active', true)->where('id', '!=', 4)->get()->sortBy('name')->sortByDesc(function($s) { return $s->id == 1 ? 1 : 0; })->values();
$stationsJson = json_encode($stations->map(fn($s) => [
    'id' => $s->id, 'name' => $s->name, 'mount' => $s->stream_mount, 'domain' => $s->domain, 'slug' => $s->slug
]));
@endphp
<div id="kbr-player" class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white z-50 shadow-2xl border-t border-gray-700 transition-all duration-300">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <button id="kbr-btn-play" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center flex-shrink-0 transition" title="Play">
                <svg id="kbr-icon-play" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                <svg id="kbr-icon-pause" class="w-5 h-5 text-white hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                <svg id="kbr-icon-loading" class="w-5 h-5 text-white hidden animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            </button>
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2">
                    <span id="kbr-station-label" class="text-white text-sm font-semibold">Radio</span>
                    <select id="kbr-station-select" class="bg-gray-800 text-white text-sm font-semibold border-b border-white/20 pb-0.5 pr-6 cursor-pointer focus:outline-none truncate max-w-[180px]">
                        <optgroup label="Stasion Radio">
                        @foreach ($stations as $s)
                         <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                                            </select>
                    <span id="kbr-offline-badge" class="hidden text-xs font-bold text-red-400 bg-red-900/30 px-2 py-0.5 rounded">OFFLINE</span>
                    </div>
                <p id="kbr-nowplaying" class="text-xs text-gray-400 truncate">Memuat metadata siaran...</p>
                <p id="kbr-metadata" class="text-[10px] text-gray-500 truncate hidden"></p>
            </div>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <button id="kbr-btn-toggle" class="text-gray-400 hover:text-white transition">
                <svg id="kbr-chevron-down" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                <svg id="kbr-chevron-up" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
    <audio id="kbr-audio" preload="none"></audio>
</div>

<script>
(function() {
    var stations = {!! $stationsJson !!};
    var audio = document.getElementById('kbr-audio');
    var playBtn = document.getElementById('kbr-btn-play');
    var iconPlay = document.getElementById('kbr-icon-play');
    var iconPause = document.getElementById('kbr-icon-pause');
    var iconLoading = document.getElementById('kbr-icon-loading');
    var npEl = document.getElementById('kbr-nowplaying');
    var selectEl = document.getElementById('kbr-station-select');
    var toggleBtn = document.getElementById('kbr-btn-toggle');
    var chevDown = document.getElementById('kbr-chevron-down');
    var chevUp = document.getElementById('kbr-chevron-up');
    var player = document.getElementById('kbr-player');
    var offlineBadge = document.getElementById('kbr-offline-badge');
    var liveBadge = document.getElementById('kbr-live-badge');
    var minimized = false;

    function getStreamUrl(id) {
        id = parseInt(id);
        for (var i = 0; i < stations.length; i++) {
            if (stations[i].id === id) {
                return 'https://radio.kbrbaik.live' + stations[i].mount;
            }
        }
        return 'https://radio.kbrbaik.live/stream';
    }

    function setNowPlaying(show, artist, title, isError) {
        if (isError) {
            npEl.textContent = show || title || 'Stream tidak tersedia';
            npEl.className = 'text-xs text-red-400 truncate';
            return;
        }
        var parts = [];
        if (show) parts.push(show);
        if (artist && title) parts.push(artist + ' - ' + title);
        else if (title) parts.push(title);
        npEl.textContent = parts.join(' — ') || 'Siaran langsung';
        npEl.className = 'text-xs text-gray-400 truncate';
    }

    function setOffline(off) {
        if (off) {
            offlineBadge.classList.remove('hidden');
            
        } else {
            offlineBadge.classList.add('hidden');
            
        }
    }

    function setEpisodeMode(isEpisode) {
        var stationSelect = document.getElementById('kbr-station-select');
        var stationLabel = document.getElementById('kbr-station-label');
        if (isEpisode) {
            stationSelect.style.display = 'none';
            stationLabel.textContent = 'Podcast';
        } else {
            stationSelect.style.display = '';
            stationLabel.textContent = 'Radio';
        }
    }

    window.playEpisode = function(url, title) {
        setOffline(false);
        
        audio.src = url;
        showIcon('kbr-icon-loading');
        setNowPlaying(null, null, title);
        setEpisodeMode(true);
        audio.load();
        audio.play().then(function() {
            showIcon('kbr-icon-pause');
        }).catch(function() {
            showIcon('kbr-icon-play');
        });
    }

    function showIcon(id) {
        [iconPlay, iconPause, iconLoading].forEach(function(el) { el.classList.add('hidden'); });
        document.getElementById(id).classList.remove('hidden');
    }

    function loadStation() {
        var id = selectEl.value;
        var url = getStreamUrl(id);
        localStorage.setItem('kbr-player-station', id);
        setOffline(false);
        
        audio.src = url;
        showIcon('kbr-icon-loading');
        audio.load();
        audio.play().then(function() {
            showIcon('kbr-icon-pause');
            
        }).catch(function() {
            showIcon('kbr-icon-play');
            setNowPlaying(null, null, 'Stream tidak tersedia', true);
            setOffline(true);
        });
    }

    playBtn.addEventListener('click', function() {
        if (audio.paused) {
            if (!audio.src) { loadStation(); return; }
            showIcon('kbr-icon-loading');
            setNowPlaying(null, null, 'Memuat...');
            audio.play().then(function() {
                showIcon('kbr-icon-pause');
                
            }).catch(function() {
                showIcon('kbr-icon-play');
                setNowPlaying(null, null, 'Stream tidak tersedia', true);
                setOffline(true);
            });
        } else {
            audio.pause();
            showIcon('kbr-icon-play');
            setNowPlaying(null, null, 'Dijeda');
            setOffline(false);
        }
    });

    selectEl.addEventListener('change', loadStation);

    toggleBtn.addEventListener('click', function() {
        minimized = !minimized;pb(minimized);
        chevDown.classList.toggle('hidden');
        chevUp.classList.toggle('hidden');
        player.style.transform = minimized ? 'translateY(calc(100% - 3rem))' : 'translateY(0)';
    });

    audio.addEventListener('play', function() {
        showIcon('kbr-icon-pause');
        setNowPlaying(null, null, 'Siaran langsung');
        setOffline(false);
    });
    audio.addEventListener('pause', function() {
        if (audio.src) { showIcon('kbr-icon-play'); setNowPlaying(null, null, 'Dijeda'); setOffline(false); }
    });
    audio.addEventListener('waiting', function() {
        showIcon('kbr-icon-loading');
    });
    audio.addEventListener('canplay', function() {
        showIcon('kbr-icon-pause');
        
    });
    audio.addEventListener('error', function() {
        showIcon('kbr-icon-play');
        setNowPlaying(null, null, 'Stream tidak tersedia', true);
        setOffline(true);
    });

    // Restore saved station
    var saved = localStorage.getItem('kbr-player-station');
    if (saved) { selectEl.value = saved; }

    function pb(m){document.body.style.paddingBottom=m?"48px":"64px";}pb(false);

    // Init Reverb events once
    if (!window._kbrEchoInited) {
        window._kbrEchoInited = true;
        var echoConfig = {
            broadcaster: 'reverb',
            key: '{{ env("REVERB_APP_KEY") }}',
            wsHost: '{{ env("REVERB_HOST") }}',
            wsPort: {{ env("REVERB_PORT", 443) }},
            wssPort: {{ env("REVERB_PORT", 443) }},
            forceTLS: {{ env("REVERB_SCHEME") === 'https' ? 'true' : 'false' }},
            enabledTransports: ['ws', 'wss'],
        };
        function loadScript(src, cb) {
            var s = document.createElement('script');
            s.src = src;
            s.onload = cb;
            document.head.appendChild(s);
        }
        function subscribeChannels() {
            stations.forEach(function(s) {
                    Echo.channel('station.' + s.id)
                        .listen('.now-playing', function(e) {
                            if (selectEl.value == s.id) {
        setNowPlaying(e.title, e.artist, null);
        setOffline(false);
                            }
                        })
                        .listen('.studio-status', function(e) {
                            if (selectEl.value == s.id && e.status === 'on-air') {
                                
                            }
                        });
            });
        }
        if (window.Echo && window.Echo.channel) {
            subscribeChannels();
        } else if (!window.Pusher) {
            loadScript('https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.js', function() {
                loadScript('https://cdn.jsdelivr.net/npm/laravel-echo@1.18.1/dist/echo.iife.js', function() {
                    window.Echo = new Echo(echoConfig);
                    subscribeChannels();
                });
            });
        } else {
            loadScript('https://cdn.jsdelivr.net/npm/laravel-echo@1.18.1/dist/echo.iife.js', function() {
                window.Echo = new Echo(echoConfig);
                subscribeChannels();
            });
        }
    }

    // Fetch Icecast metadata periodically
    function fetchMetadata() {
        var selectEl = document.getElementById('kbr-station-select');
        var selectedText = selectEl ? selectEl.options[selectEl.selectedIndex].text : '';
        fetch('https://radio.kbrbaik.live/status-json.xsl')
            .then(function(r) { return r.json(); })
            .then(function(d) {
                var sources = d.icestats.source;
                if (!sources || !Array.isArray(sources)) return;
                var match = null;
                for (var i = 0; i < sources.length; i++) {
                    var sname = sources[i].server_name || '';
                    if (sname.toLowerCase().indexOf(selectedText.toLowerCase()) >= 0 ||
                        selectedText.toLowerCase().indexOf(sname.toLowerCase()) >= 0 ||
                        selectedText.toLowerCase().indexOf(sources[i].server_url ? sources[i].server_url.toLowerCase() : '') >= 0) {
                        match = sources[i];
                        break;
                    }
                }
                if (!match) {
                    setNowPlaying(null, null, selectedText || 'Siaran langsung');
                    return;
                }
                var showName = match.server_name || '';
                var rawTitle = match.title || '';
                var artist = null, song = rawTitle;
                if (rawTitle && rawTitle.indexOf(' - ') > 0) {
                    var parts = rawTitle.split(' - ');
                    artist = parts[0];
                    song = parts.slice(1).join(' - ');
                }
                setNowPlaying(showName, artist, song || 'Siaran langsung');
            })
            .catch(function() {});
    }
    fetchMetadata();
    setInterval(fetchMetadata, 30000);
})();
</script>

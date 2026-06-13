<?php
$f = '/var/www/radio/resources/views/home.blade.php';
$c = file_get_contents($f);

$old = '<div class="lg:w-1/2 w-full max-w-md">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                            <span class="text-xs font-bold tracking-widest">SIARAN LIVE</span>
                        </div>
                        <h3 class="text-lg font-bold">Renungan Pagi Bersama</h3>
                        <p class="text-sm text-white/60">Pdt. Elia Suryo · GKJ Purwokerto</p>
                        <div class="flex items-center gap-1 mt-4 mb-4 h-8">
                            <div class="w-1 bg-white/30 rounded-full h-3"></div><div class="w-1 bg-white/50 rounded-full h-5"></div><div class="w-1 bg-white/30 rounded-full h-2"></div><div class="w-1 bg-white/70 rounded-full h-6"></div><div class="w-1 bg-white/30 rounded-full h-4"></div>
                            <div class="w-1 bg-white/50 rounded-full h-3"></div><div class="w-1 bg-white/30 rounded-full h-5"></div><div class="w-1 bg-white/70 rounded-full h-2"></div><div class="w-1 bg-white/30 rounded-full h-6"></div><div class="w-1 bg-white/50 rounded-full h-4"></div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="w-10 h-10 rounded-full bg-white text-sky-700 flex items-center justify-center font-bold hover:bg-sky-100 transition">▶</button>
                            <div class="flex-1">
                                <div class="h-1 bg-white/20 rounded-full"><div class="w-2/5 h-1 bg-white rounded-full"></div></div>
                                <div class="flex justify-between text-xs text-white/60 mt-1"><span>18:24</span><span>48:00</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center gap-8 mt-6">
                        <div class="text-center"><div class="text-2xl font-bold">47+</div><div class="text-xs text-white/60">Gereja aktif</div></div>
                        <div class="text-center"><div class="text-2xl font-bold">320+</div><div class="text-xs text-white/60">Episode podcast</div></div>
                        <div class="text-center"><div class="text-2xl font-bold">12K</div><div class="text-xs text-white/60">Jemaat terhubung</div></div>
                    </div>
                </div>';

$new = '<div class="lg:w-1/2 w-full max-w-md space-y-6">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl overflow-hidden">
                        <div class="aspect-video bg-black/40">
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Siaran Langsung Studio" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                                <span class="text-xs font-bold tracking-widest">LIVE</span>
                                <span class="text-xs text-white/60">Siaran Langsung Studio</span>
                            </div>
                            <p class="text-sm text-white/80">Tonton siaran langsung dari studio KbrBaik.</p>
                            <a href="{{ route(\'komunitas\') }}" class="inline-block mt-3 text-xs text-sky-300 hover:text-white transition">Kunjungi Komunitas Studio →</a>
                        </div>
                    </div>
                    <div class="flex justify-center gap-8">
                        <div class="text-center"><div class="text-2xl font-bold">47+</div><div class="text-xs text-white/60">Gereja aktif</div></div>
                        <div class="text-center"><div class="text-2xl font-bold">320+</div><div class="text-xs text-white/60">Episode podcast</div></div>
                        <div class="text-center"><div class="text-2xl font-bold">12K</div><div class="text-xs text-white/60">Jemaat terhubung</div></div>
                    </div>
                </div>';

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";

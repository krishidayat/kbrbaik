<?php
$f = '/var/www/radio/resources/views/home.blade.php';
$c = file_get_contents($f);

$old = '                <div class="lg:w-1/2 w-full max-w-md ">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl overflow-hidden">
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
                </div>';

$new = '                <div class="lg:w-1/2 w-full max-w-md">
                    <div class="bg-black/30 border border-white/20 rounded-2xl overflow-hidden shadow-xl">
                        <div class="aspect-video bg-gradient-to-br from-gray-900 to-gray-800 flex items-center justify-center relative group cursor-pointer">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur border border-white/30 flex items-center justify-center group-hover:bg-white/30 transition hover:scale-110">
                                    <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                            <div class="absolute bottom-3 left-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                <span class="text-xs font-bold text-white/90">LIVE</span>
                            </div>
                            <div class="absolute bottom-3 right-3">
                                <span class="text-xs text-white/60 bg-black/50 px-2 py-0.5 rounded">Siaran Langsung</span>
                            </div>
                            <svg class="absolute top-3 right-3 w-5 h-5 text-white/30" viewBox="0 0 24 24" fill="currentColor"><path d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z"/></svg>
                        </div>
                        <div class="p-4 bg-white/5 backdrop-blur-sm">
                            <p class="text-sm text-white/80">Tonton siaran langsung dari studio KbrBaik.</p>
                            <a href="{{ route(\'komunitas\') }}" class="inline-block mt-2 text-xs text-sky-300 hover:text-white transition">Kunjungi Komunitas Studio →</a>
                        </div>
                    </div>
                </div>';

$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";

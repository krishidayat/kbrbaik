with open('/var/www/radio/resources/views/home.blade.php', 'r') as f:
    content = f.read()

old = """<section class=py-16 bg-white border-t border-sky-100>
        <div class=max-w-6xl mx-auto px-4>
            <div class=grid md:grid-cols-2 lg:grid-cols-4 gap-6>
                {{-- Card 1 --}}
                <div class=bg-gradient-to-br from-sky-50 to-white border border-sky-200 rounded-xl p-6 hover:shadow-lg transition relative>
                    <span class=absolute top-4 right-4 text-4xl font-bold text-sky-100>01</span>
                    <div class=w-14 h-14 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-2xl mb-4>\U0001f4e1</div>
                    <span class=text-xs font-mono font-bold tracking-widest text-sky-500>BERSABAT DENGAN MEDIA</span>
                    <h3 class=font-bold text-gray-900 mt-2>Media sebagai ekspresi diri</h3>
                    <p class=text-sm text-gray-500 mt-2>Manusia adalah media dan pesan dalam komunikasi. Bersahabat dengan media menjadi sarana pengembangan diri untuk menjadi komunikator yang baik.</p>
                </div>

                {{-- Card 2 --}}
                <div class=bg-gradient-to-br from-emerald-50 to-white border border-emerald-200 rounded-xl p-6 hover:shadow-lg transition relative>
                    <span class=absolute top-4 right-4 text-4xl font-bold text-emerald-100>02</span>
                    <div class=w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-4>\U0001f310</div>
                    <span class=text-xs font-mono font-bold tracking-widest text-emerald-500>BERSABAT DI INTERGENERASI</span>
                    <h3 class=font-bold text-gray-900 mt-2>Berdamai dengan perubahan</h3>
                    <p class=text-sm text-gray-500 mt-2>Jaman berubah, persahabatan adalah sarana berdamai dengan perubahan — lintas generasi, lintas wilayah, dan selalu menemukan kesamaan diri dan kebijaksanaan ketika menjadi pribadi yang terbuka dan bermakna.</p>
                </div>

                {{-- Card 3 --}}
                <div class=bg-gradient-to-br from-amber-50 to-white border border-amber-200 rounded-xl p-6 hover:shadow-lg transition relative>
                    <span class=absolute top-4 right-4 text-4xl font-bold text-amber-100>03</span>
                    <div class=w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-2xl mb-4>\u270d\ufe0f</div>
                    <span class=text-xs font-mono font-bold tracking-widest text-amber-500>BERSABAT DENGAN NARASI</span>
                    <h3 class=font-bold text-gray-900 mt-2>Dari gagasan menjadi kenyataan</h3>
                    <p class=text-sm text-gray-500 mt-2>Menuliskan narasi, mengucapkan kalimat persahabatan, dan menggandeng tangan dalam pekerjaan pelayanan — menjadikan ide menjadi kenyataan dari harapan baik bagi semua orang.</p>
                </div>

                {{-- Card 4 --}}
                <div class=bg-gradient-to-br from-purple-50 to-white border border-purple-200 rounded-xl p-6 hover:shadow-lg transition relative>
                    <span class=absolute top-4 right-4 text-4xl font-bold text-purple-100>04</span>
                    <div class=w-14 h-14 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-2xl mb-4>\u23f3</div>
                    <span class=text-xs font-mono font-bold tracking-widest text-purple-500>WAKTU ADALAH KESEMPATAN</span>
                    <h3 class=font-bold text-gray-900 mt-2>Warisan baik bagi semua</h3>
                    <p class=text-sm text-gray-500 mt-2>Memeluk bagian penting dari warisan baik di masa lalu, mengolah dalam zaman kekinian, dan menjadi warisan baik dari sang Pencipta bagi semua.</p>
                </div>
            </div>
        </div>
    </section>"""

new = """    <section class="py-16 bg-white border-t border-sky-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Card 1 --}}
                <div class="bg-gradient-to-br from-sky-50 to-white border border-sky-200 rounded-xl p-6 hover:shadow-lg transition relative">
                    <span class="absolute top-4 right-4 text-4xl font-bold text-sky-100">01</span>
                    <div class="w-14 h-14 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-2xl mb-4">📡</div>
                    <span class="text-xs font-mono font-bold tracking-widest text-sky-500">BERSABAT DENGAN MEDIA</span>
                    <h3 class="font-bold text-gray-900 mt-2">Media sebagai ekspresi diri</h3>
                    <p class="text-sm text-gray-500 mt-2">Manusia adalah media dan pesan dalam komunikasi. Bersahabat dengan media menjadi sarana pengembangan diri untuk menjadi komunikator yang baik.</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-gradient-to-br from-emerald-50 to-white border border-emerald-200 rounded-xl p-6 hover:shadow-lg transition relative">
                    <span class="absolute top-4 right-4 text-4xl font-bold text-emerald-100">02</span>
                    <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-4">🌐</div>
                    <span class="text-xs font-mono font-bold tracking-widest text-emerald-500">BERSABAT DI INTERGENERASI</span>
                    <h3 class="font-bold text-gray-900 mt-2">Berdamai dengan perubahan</h3>
                    <p class="text-sm text-gray-500 mt-2">Jaman berubah, persahabatan adalah sarana berdamai dengan perubahan — lintas generasi, lintas wilayah, dan selalu menemukan kesamaan diri dan kebijaksanaan ketika menjadi pribadi yang terbuka dan bermakna.</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-gradient-to-br from-amber-50 to-white border border-amber-200 rounded-xl p-6 hover:shadow-lg transition relative">
                    <span class="absolute top-4 right-4 text-4xl font-bold text-amber-100">03</span>
                    <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-2xl mb-4">✍️</div>
                    <span class="text-xs font-mono font-bold tracking-widest text-amber-500">BERSABAT DENGAN NARASI</span>
                    <h3 class="font-bold text-gray-900 mt-2">Dari gagasan menjadi kenyataan</h3>
                    <p class="text-sm text-gray-500 mt-2">Menuliskan narasi, mengucapkan kalimat persahabatan, dan menggandeng tangan dalam pekerjaan pelayanan — menjadikan ide menjadi kenyataan dari harapan baik bagi semua orang.</p>
                </div>

                {{-- Card 4 --}}
                <div class="bg-gradient-to-br from-purple-50 to-white border border-purple-200 rounded-xl p-6 hover:shadow-lg transition relative">
                    <span class="absolute top-4 right-4 text-4xl font-bold text-purple-100">04</span>
                    <div class="w-14 h-14 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-2xl mb-4">⏳</div>
                    <span class="text-xs font-mono font-bold tracking-widest text-purple-500">WAKTU ADALAH KESEMPATAN</span>
                    <h3 class="font-bold text-gray-900 mt-2">Warisan baik bagi semua</h3>
                    <p class="text-sm text-gray-500 mt-2">Memeluk bagian penting dari warisan baik di masa lalu, mengolah dalam zaman kekinian, dan menjadi warisan baik dari sang Pencipta bagi semua.</p>
                </div>
            </div>
        </div>
    </section>"""

if old in content:
    content = content.replace(old, new)
    with open('/var/www/radio/resources/views/home.blade.php', 'w') as f:
        f.write(content)
    print('SUCCESS')
else:
    print('NOT FOUND')

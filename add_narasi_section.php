<?php
$f = '/var/www/radio/resources/views/home.blade.php';
$c = file_get_contents($f);

$section = "
{{-- NARASI KABAR BAIK --}}
<section class=\"py-16 bg-white border-t border-sky-100\">
    <div class=\"max-w-6xl mx-auto px-4\">
        <div class=\"flex items-end justify-between mb-8\">
            <div>
                <span class=\"text-xs font-mono font-bold tracking-widest uppercase px-3 py-1 rounded-full bg-sky-100 border border-sky-200 text-sky-600\">blog</span>
                <h2 class=\"text-3xl font-bold text-sky-900 mt-3\">Narasi Kabar Baik</h2>
                <p class=\"text-sky-600\">Kabar baik dari blog komunitas</p>
            </div>
            <a href=\"{{ route('kbrbaik.blog') }}\" class=\"text-sm font-semibold text-sky-600 hover:text-sky-800 transition\">Lihat Semua &rarr;</a>
        </div>

        @if(isset(\$latestPosts) && \$latestPosts->count())
        <div class=\"grid md:grid-cols-2 lg:grid-cols-4 gap-6\">
            @foreach(\$latestPosts as \$post)
            <a href=\"{{ route('post', \$post->slug) }}\" class=\"bg-white border border-sky-200 rounded-xl overflow-hidden hover:shadow-lg transition group\">
                @if(\$post->featured_image)
                <img src=\"{{ asset('storage/' . \$post->featured_image) }}\" alt=\"{{ \$post->title }}\" class=\"w-full h-40 object-cover group-hover:scale-105 transition duration-300\">
                @else
                <div class=\"w-full h-40 bg-gradient-to-br from-sky-200 to-sky-300 flex items-center justify-center\">
                    <svg class=\"w-12 h-12 text-sky-400\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z\"/></svg>
                </div>
                @endif
                <div class=\"p-4\">
                    @if(\$post->category)
                    <span class=\"text-xs font-semibold text-sky-600 bg-sky-50 px-2 py-0.5 rounded\">{{ \$post->category->name }}</span>
                    @endif
                    <h3 class=\"font-semibold text-gray-900 mt-2 group-hover:text-sky-700 transition\">{{ \$post->title }}</h3>
                    <p class=\"text-xs text-gray-500 mt-1\">{{ Str::limit(\$post->lead ?? \$post->excerpt ?? strip_tags(\$post->body), 80) }}</p>
                    <span class=\"text-xs font-semibold text-sky-600 mt-3 inline-block group-hover:underline\">Baca &rarr;</span>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class=\"text-center py-8 text-gray-400\">
            <p>Belum ada narasi.</p>
        </div>
        @endif
    </div>
</section>
";

$c = str_replace('<section id="bergabung" class="py-16">', $section . "\n" . '<section id="bergabung" class="py-16">', $c);
file_put_contents($f, $c);
echo "OK\n";

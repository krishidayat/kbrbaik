<?php
$f = '/var/www/radio/routes/web.php';
$c = file_get_contents($f);

$old = "    \$studioPosts = AppModelsPost::where('studio_id', ->id)->where('is_published', true)->latest()->get();";
$new = "    \$studioPosts = \App\Models\Post::where('studio_id', \$studio->id)->where('is_published', true)->latest()->get();";

$c = str_replace($old, $new, $c, $count);

if ($count > 0) {
    // Also add to compact
    $c = str_replace(
        "return view('kbrbaik-studio-show', compact('station', 'studio', 'episodes'));",
        "return view('kbrbaik-studio-show', compact('station', 'studio', 'studioPosts', 'episodes'));",
        $c
    );
    file_put_contents($f, $c);
    echo "OK: fixed\n";
} else {
    echo "FAIL\n";
}

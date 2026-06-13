<?php
$f = '/var/www/radio/app/Models/Post.php';
$c = file_get_contents($f);
$old = "'featured_image', 'audio_url', 'video_url', 'body_format', 'author', 'type', 'is_published', 'published_at', 'source_url'";
$new = "'featured_image', 'audio_url', 'video_url', 'body_format', 'lead', 'quote', 'resume', 'author', 'type', 'is_published', 'published_at', 'source_url'";
if (strpos($c, $old) !== false) {
    $c = str_replace($old, $new, $c);
    file_put_contents($f, $c);
    echo "OK\n";
} else {
    echo "FAIL\n";
}

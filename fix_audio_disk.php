<?php
$f = '/var/www/radio/config/filesystems.php';
$c = file_get_contents($f);

$add = "        'audio' => [
            'driver' => 'local',
            'root' => '/var/radio/audio',
        ],
";

// Insert before 'private'
$c = str_replace("'private' => [", $add . "        'private' => [", $c);
file_put_contents($f, $c);
echo "OK\n";

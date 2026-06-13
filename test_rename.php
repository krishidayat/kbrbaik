<?php
$src = "/srv/libretime/organize/romansa.mp3";
$dst = "/srv/libretime/organize/44-test.mp3";
echo "Testing rename from organize to organize...\n";
if (file_exists($src)) {
    echo "Source exists: " . filesize($src) . " bytes\n";
}
if (is_dir(dirname($dst))) {
    echo "Dest dir exists, writable: " . (is_writable(dirname($dst)) ? "yes" : "no") . "\n";
}
$result = rename($src, $dst);
if ($result) {
    echo "RENAME SUCCESS\n";
} else {
    echo "RENAME FAILED\n";
    print_r(error_get_last());
}

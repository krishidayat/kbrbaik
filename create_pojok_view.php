<?php
$html = file_get_contents('/tmp/pojok-template.html');
$html = str_replace('Kabar Baik', 'Pojok KbrBaik', $html);
$html = str_replace('Kabar Baik — Komunitas Digital GKJ & GKI Jateng', 'Pojok KbrBaik — Komunitas Digital', $html);
$html = str_replace('Komunitas Digital GKJ & GKI Jateng', 'Komunitas Digital', $html);
file_put_contents('/var/www/radio/resources/views/pojok.blade.php', $html);
echo "OK\n";

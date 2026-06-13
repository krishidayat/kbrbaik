<?php
require_once "/var/www/html/application/configs/conf.php";

$ownerId = 1;
$trackTitle = "Romansa Ke Masa Depan";
$artistName = "Glenn Fredly";

$file = new CcFiles();
$file->setDbTrackTitle($trackTitle);
$file->setDbArtistName($artistName);
$file->setDbOwnerId($ownerId);
$file->setDbHidden(true);
$file->setDbFileExists(true);
$file->setDbImportStatus(0);
$file->save();

$fileId = $file->getPrimaryKey();
$storPath = "/srv/libretime/imported/" . $ownerId . "/" . $fileId . "/";
if (!is_dir($storPath)) {
    mkdir($storPath, 0777, true);
}
$srcFile = "/srv/libretime/organize/romansa.mp3";
$destFile = $storPath . "romansa.mp3";

if (file_exists($srcFile)) {
    rename($srcFile, $destFile);
    echo "Imported file ID: " . $fileId . " -> " . $destFile . PHP_EOL;
} else {
    echo "ERROR: Source file not found at " . $srcFile . PHP_EOL;
}

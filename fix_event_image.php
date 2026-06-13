<?php
$f = '/var/www/radio/app/Filament/Resources/Events/Schemas/EventForm.php';
$c = file_get_contents($f);
$old = "FileUpload::make('featured_image')
                    ->label('Gambar Utama')
                    ->image()
                    ->directory('events')
                    ->columnSpanFull(),";
$new = "FileUpload::make('featured_image')
                    ->label('Gambar Utama')
                    ->image()
                    ->disk('public')
                    ->directory('events')
                    ->imageResizeTargetWidth(1920)
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->columnSpanFull(),";
$c = str_replace($old, $new, $c);
file_put_contents($f, $c);
echo "OK\n";

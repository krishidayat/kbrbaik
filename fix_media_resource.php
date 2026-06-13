<?php
$f = '/var/www/radio/app/Filament/Resources/MediaItems/MediaItemResource.php';
$c = file_get_contents($f);

// Add station filter to table query
$search = "public static function table(Table \$table): Table
    {
        return \$table
            ->columns([";
$replace = "public static function table(Table \$table): Table
    {
        return \$table
            ->modifyQueryUsing(fn (Builder \$query) => \$query->when(
                station(),
                fn (\$q) => \$q->where('station_id', station()->id)
            ))
            ->columns([";
$c = str_replace($search, $replace, $c);

// Add canAccess
$search2 = "class MediaItemResource extends Resource
{";
$replace2 = "class MediaItemResource extends Resource
{
    public static function canAccess(): bool
    {
        return auth()->user()?->role !== 'user';
    }
";
$c = str_replace($search2, $replace2, $c);

file_put_contents($f, $c);
echo "OK: MediaItemResource updated.\n";

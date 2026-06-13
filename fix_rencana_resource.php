<?php
$f = '/var/www/radio/app/Filament/Resources/RencanaKerjas/RencanaKerjaResource.php';
$c = file_get_contents($f);

$table_code = <<<'PHP'
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('station_id')
                    ->relationship('station', 'name')->default(2),
                \Filament\Forms\Components\Select::make('bidang_no')
                    ->options(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6'])->label('No Bidang'),
                \Filament\Forms\Components\TextInput::make('bidang')->required(),
                \Filament\Forms\Components\TextInput::make('entitas')->label('Bidang/Komisi/Desk')->required(),
                \Filament\Forms\Components\TextInput::make('program')->label('Program/Kegiatan')->required(),
                \Filament\Forms\Components\TextInput::make('tujuan')->label('Tujuan/Sasaran'),
                \Filament\Forms\Components\TextInput::make('waktu'),
                \Filament\Forms\Components\TextInput::make('tempat'),
                \Filament\Forms\Components\TextInput::make('anggaran'),
                \Filament\Forms\Components\TextInput::make('keterangan'),
                \Filament\Forms\Components\Select::make('kategori')
                    ->options(['Sosialisasi & Edukasi'=>'Sosialisasi & Edukasi','Pelatihan & Pengembangan'=>'Pelatihan & Pengembangan','Pelayanan & Pendampingan'=>'Pelayanan & Pendampingan','Media & Informasi'=>'Media & Informasi','Rapat & Sidang'=>'Rapat & Sidang']),
                \Filament\Forms\Components\Toggle::make('is_active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('bidang_no')->label('#')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('bidang')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('entitas')->label('Pelaksana'),
                \Filament\Tables\Columns\TextColumn::make('program')->label('Program')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('kategori')->badge(),
                \Filament\Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('bidang_no', 'asc')
            ->filters([])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
PHP;

// Read the full file
$lines = file($f);
$out = [];
$skip = false;
foreach ($lines as $line) {
    if (trim($line) === "public static function form(Schema \$schema): Schema") {
        $skip = true;
    }
    if ($skip && trim($line) === "public static function getPages(): array") {
        $skip = false;
    }
    if (!$skip) {
        $out[] = $line;
    }
}

// Insert new code before getPages
$result = implode('', $out);
$result = str_replace("public static function getPages(): array", $table_code . "\n\n    public static function getPages(): array", $result);

file_put_contents($f, $result);
echo "OK\n";

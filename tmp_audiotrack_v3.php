<?php

namespace App\Filament\Resources\AudioTracks;

use App\Filament\Resources\AudioTracks\AudioTrackResource;
use App\Models\AudioTrack;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class AudioTrackResource extends Resource
{
    protected static ?string $model = AudioTrack::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMusicalNote;

    protected static UnitEnum|string|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Audio Tracks';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('community_id')
                    ->relationship('community', 'name')
                    ->required(),
                TextInput::make('title')->required(),
                TextInput::make('artist'),
                Select::make('playlist')
                    ->options(['pagi'=>'Pagi','siang'=>'Siang','malam'=>'Malam'])
                    ->default('siang'),
                FileUpload::make('file_path')
                    ->label('Audio File')
                    ->disk('audio')
                    ->directory(fn ($get) => ($get('community_id') ? \App\Models\Community::find($get('community_id'))?->slug : 'unknown') . '/' . ($get('playlist') ?? 'siang'))
                    ->acceptedFileTypes(['audio/mpeg','audio/mp3','audio/wav','audio/ogg'])
                    ->maxSize(102400),
                TextInput::make('duration')->numeric()->suffix('detik'),
                TextInput::make('sort_order')->numeric()->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('community.name')->label('Komunitas'),
                TextColumn::make('title')->searchable(),
                TextColumn::make('artist'),
                TextColumn::make('playlist')->badge()
                    ->color(fn ($s) => $s === 'pagi' ? 'warning' : ($s === 'siang' ? 'info' : 'dark')),
                TextColumn::make('duration')->formatStateUsing(fn ($s) => $s ? gmdate('i:s', $s) : '-'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('community_id')->relationship('community', 'name'),
                SelectFilter::make('playlist')->options(['pagi'=>'Pagi','siang'=>'Siang','malam'=>'Malam']),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListAudioTracks::route('/')];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('community', fn ($q) => $q->where('station_id', station()?->id ?? 1));
    }
}

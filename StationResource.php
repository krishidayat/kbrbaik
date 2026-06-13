<?php

namespace App\Filament\Resources\Stations;

use App\Filament\Resources\Stations\Pages\CreateStation;
use App\Filament\Resources\Stations\Pages\EditStation;
use App\Filament\Resources\Stations\Pages\ListStations;
use App\Filament\Resources\Stations\Schemas\StationForm;
use App\Filament\Resources\Stations\Tables\StationsTable;
use App\Models\Station;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StationResource extends Resource
{
    protected static ?string $model = Station::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRadio;

    public static function canAccess(): bool
    {
        return auth()->user()?->role !== 'user';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public static function form(Schema $schema): Schema
    {
        return StationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StationsTable::configure($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('name'));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStations::route('/'),
            'create' => CreateStation::route('/create'),
            'edit' => EditStation::route('/{record}/edit'),
        ];
    }
}

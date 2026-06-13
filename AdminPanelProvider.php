<?php

namespace App\Providers\Filament;

use App\Filament\Pages\ImportInstagram;
use App\Filament\Pages\ManageRelay;
use App\Models\Station;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Filament\Navigation\NavigationItem;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $host = request()->getHost();
        $current = Station::where('domain', $host)->first();
        $slug = $current?->slug;

        $color = match ($slug) {
            'pojok' => Color::Green,
            'suara-pgiw-jabar' => Color::Blue,
            default => Color::Amber,
        };

        $resources = match ($slug) {
            'pojok' => $this->pojokResources(),
            'suara-pgiw-jabar' => $this->suaraResources(),
            default => $this->mainResources(),
        };

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => $color,
            ])
            ->brandName($current?->name ?? 'Admin')
            ->resources($resources)
            ->pages([
                Dashboard::class,
                ImportInstagram::class,
                ManageRelay::class,
            ])
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->navigationItems([
                NavigationItem::make('Galeri Foto')
                    ->url(fn () => url('/galeri'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-photo')
                    ->group('Publik')
                    ->sort(1)
                    ->visible(fn () => auth()->user()?->role !== 'user'),
                NavigationItem::make('Galeri Musik')
                    ->url(fn () => url('/musik'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-play-circle')
                    ->group('Publik')
                    ->sort(2)
                    ->visible(fn () => auth()->user()?->role !== 'user'),
                NavigationItem::make('Radio Player')
                    ->url(fn () => url('/radio'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-signal')
                    ->group('Publik')
                    ->sort(3)
                    ->visible(fn () => auth()->user()?->role !== 'user'),
                NavigationItem::make('DJ Studio')
                    ->url(fn () => url('/dj'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-radio')
                    ->group('Publik')
                    ->sort(4)
                    ->visible(fn () => auth()->user()?->role !== 'user'),
            ])
            ->middleware([
                \App\Http\Middleware\ResolveStation::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    private function mainResources(): array
    {
        return [
            \App\Filament\Resources\Users\UserResource::class,
            \App\Filament\Resources\GalleryItems\GalleryItemResource::class,
            \App\Filament\Resources\Stations\StationResource::class,
            \App\Filament\Resources\RelaySources\RelaySourceResource::class,
            \App\Filament\Resources\DJS\DJResource::class,
            \App\Filament\Resources\Schedules\ScheduleResource::class,
            \App\Filament\Resources\Episodes\EpisodeResource::class,
            \App\Filament\Resources\PlaylistItems\PlaylistItemResource::class,
            \App\Filament\Resources\Posts\PostResource::class,
            \App\Filament\Resources\MediaItems\MediaItemResource::class,
            \App\Filament\Resources\Trainings\TrainingResource::class,
            \App\Filament\Resources\Categories\CategoryResource::class,
            \App\Filament\Resources\Events\EventResource::class,
            \App\Filament\Resources\Testimonials\TestimonialResource::class,
            \App\Filament\Resources\Statistics\StatisticResource::class,
            \App\Filament\Resources\Communities\CommunityResource::class,
            \App\Filament\Resources\CommunityProjects\CommunityProjectResource::class,
        ];
    }

    private function suaraResources(): array
    {
        return [
            \App\Filament\Resources\Posts\PostResource::class,
            \App\Filament\Resources\Categories\CategoryResource::class,
            \App\Filament\Resources\Events\EventResource::class,
            \App\Filament\Resources\GalleryItems\GalleryItemResource::class,
            \App\Filament\Resources\Schedules\ScheduleResource::class,
            \App\Filament\Resources\Episodes\EpisodeResource::class,
            \App\Filament\Resources\PlaylistItems\PlaylistItemResource::class,
            \App\Filament\Resources\Stations\StationResource::class,
        ];
    }

    private function pojokResources(): array
    {
        return [
            \App\Filament\Resources\GalleryItems\GalleryItemResource::class,
            \App\Filament\Resources\Stations\StationResource::class,
            \App\Filament\Resources\RelaySources\RelaySourceResource::class,
            \App\Filament\Resources\Posts\PostResource::class,
            \App\Filament\Resources\Trainings\TrainingResource::class,
            \App\Filament\Resources\Categories\CategoryResource::class,
            \App\Filament\Resources\Events\EventResource::class,
            \App\Filament\Resources\Episodes\EpisodeResource::class,
            \App\Filament\Resources\Testimonials\TestimonialResource::class,
            \App\Filament\Resources\Statistics\StatisticResource::class,
        ];
    }
}

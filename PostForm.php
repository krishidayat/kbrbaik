<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\GalleryItem;
use App\Models\MediaItem;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori')
                    ->options(fn () => \App\Models\Category::where('station_id', station()?->id ?? 0)->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                Select::make('body_format')
                    ->options([
                        'markdown' => 'Markdown',
                        'html' => 'HTML',
                    ])
                    ->default('markdown')
                    ->live(),
                MarkdownEditor::make('body')
                    ->required()
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('body_format') === 'markdown'),
                RichEditor::make('body')
                    ->required()
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('body_format') === 'html'),
                Textarea::make('lead')
                    ->label('Lead')
                    ->helperText('Pembuka artikel — muncul di bold besar sebelum konten utama')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('type') === 'article'),
                Textarea::make('quote')
                    ->label('Kutipan')
                    ->helperText('Kutipan menarik — ditampilkan dengan style blockquote')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('type') === 'article'),
                Textarea::make('resume')
                    ->label('Resume')
                    ->helperText('Kesimpulan/ringkasan di akhir artikel')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('type') === 'article'),
                FileUpload::make('featured_image')
                    ->image()
                    ->disk('public')
                    ->imageResizeTargetWidth(1920)
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->directory('featured'),
                Select::make('gallery_image_id')
                    ->label('Pilih dari Galeri')
                    ->helperText('Gambar dari halaman Galeri. Upload baru di menu Galeri.')
                    ->options(fn () => \App\Models\GalleryItem::where('is_active', true)->get()->mapWithKeys(fn ($item) => [
                        $item->id => '<img src="' . asset('storage/' . $item->thumbnail_path ?? $item->image_path) . '" class="w-10 h-10 rounded object-cover inline-block mr-2"> ' . $item->title
                    ]))
                    ->allowHtml()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $item = \App\Models\GalleryItem::find($state);
                            if ($item) {
                                $set('featured_image', $item->image_path);
                            }
                        }
                    }),
                Select::make('type')
                    ->label('Template')
                    ->options([
                        'article' => 'Artikel',
                        'podcast' => 'Podcast',
                        'video' => 'Video',
                    ])
                    ->default('article')
                    ->live()
                    ->required(),
                TextInput::make('audio_url')
                    ->label('Audio URL (SoundCloud / MP3)')
                    ->visible(fn ($get) => $get('type') === 'podcast')
                    ->columnSpanFull(),
                TextInput::make('video_url')
                    ->label('Video URL (YouTube / Vimeo)')
                    ->visible(fn ($get) => $get('type') === 'video')
                    ->columnSpanFull(),
                Select::make('media_item_id')
                    ->label('Pilih dari Media Library')
                    ->helperText('Video YouTube/Instagram/Podcast dari menu Media Items. Tambah baru di menu Media Items.')
                    ->options(fn () => \App\Models\MediaItem::where('is_active', true)->get()->mapWithKeys(fn ($item) => [
                        $item->id => ($item->thumbnail_url ? '<img src="' . $item->thumbnail_url . '" class="w-10 h-10 rounded object-cover inline-block mr-2"> ' : '') . $item->title
                    ]))
                    ->allowHtml()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $item = \App\Models\MediaItem::find($state);
                            if ($item) {
                                $set('video_url', $item->url);
                                $set('type', 'video');
                            }
                        }
                    }),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}

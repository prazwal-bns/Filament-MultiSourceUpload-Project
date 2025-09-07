<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use App\Filament\Components\FullWidthSection;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            FullWidthSection::make('Post Information')
                ->schema([
                    TextInput::make('title')
                        ->required(),
                    Textarea::make('content')
                        ->required()
                        ->columnSpanFull(),
                ]),
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Cover Image')
                        ->schema([
                            FileUpload::make('cover_image')
                                ->image()
                                ->required(fn (callable $get) => empty($get('cover_image_url')))
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (!empty($state)) {
                                        $set('cover_image_url', null);
                                    }
                                }),
                        ])
                        ->live()
                        ->hidden(fn(callable $get) => !empty($get('cover_image_url'))),
                    Tabs\Tab::make('Cover URL')
                        ->schema([
                            TextInput::make('cover_image_url')
                                ->url()
                                ->required(fn (callable $get) => empty($get('cover_image')))
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if (!empty($state)) {
                                        $set('cover_image', null);
                                    }
                                }),
                        ])
                        ->live()
                        ->hidden(fn(callable $get) => !empty($get('cover_image'))),
                ])
                ->columnSpanFull()
        ]);
    }
}

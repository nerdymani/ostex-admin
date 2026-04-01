<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('short_desc')
                    ->maxLength(255)
                    ->label('Short Description'),
                RichEditor::make('description')
                    ->columnSpanFull(),
                TextInput::make('icon')
                    ->maxLength(100)
                    ->helperText('Heroicon name e.g. globe-alt'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('services'),
                TextInput::make('category')
                    ->maxLength(100),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->default(true),
                Toggle::make('is_featured')
                    ->default(false),
            ]);
    }
}

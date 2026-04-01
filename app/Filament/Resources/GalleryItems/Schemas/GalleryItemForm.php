<?php
namespace App\Filament\Resources\GalleryItems\Schemas;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
class GalleryItemForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make("title")->required()->maxLength(255),
            TextInput::make("category")->maxLength(100),
            TextInput::make("alt_text")->maxLength(255),
            FileUpload::make("image")->image()->disk("public")->directory("gallery")->required(),
            Textarea::make("description")->rows(3)->columnSpanFull(),
            TextInput::make("sort_order")->numeric()->default(0),
            Toggle::make("is_active")->default(true),
        ]);
    }
}

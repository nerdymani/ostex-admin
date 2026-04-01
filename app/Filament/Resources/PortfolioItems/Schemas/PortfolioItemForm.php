<?php
namespace App\Filament\Resources\PortfolioItems\Schemas;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
class PortfolioItemForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make("title")->required()->maxLength(255)->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set("slug", Str::slug($state))),
            TextInput::make("slug")->required()->unique(ignoreRecord: true)->maxLength(255),
            TextInput::make("client")->maxLength(255),
            TextInput::make("category")->maxLength(100),
            TextInput::make("project_url")->url()->maxLength(255),
            DatePicker::make("completed_at"),
            FileUpload::make("image")->image()->disk("public")->directory("portfolio"),
            FileUpload::make("gallery")->image()->disk("public")->directory("portfolio/gallery")->multiple()->reorderable(),
            TagsInput::make("technologies"),
            TextInput::make("description")->maxLength(500)->columnSpanFull(),
            RichEditor::make("body")->columnSpanFull(),
            TextInput::make("sort_order")->numeric()->default(0),
            Toggle::make("is_active")->default(true),
            Toggle::make("is_featured")->default(false),
        ]);
    }
}

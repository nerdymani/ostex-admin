<?php
namespace App\Filament\Resources\BlogPosts\Schemas;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
class BlogPostForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make("title")->required()->maxLength(255)->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set("slug", Str::slug($state))),
            TextInput::make("slug")->required()->unique(ignoreRecord: true)->maxLength(255),
            TextInput::make("author_name")->maxLength(255),
            TextInput::make("category")->maxLength(100),
            TagsInput::make("tags"),
            FileUpload::make("cover_image")->image()->disk("public")->directory("blog"),
            TextInput::make("excerpt")->maxLength(500)->columnSpanFull(),
            RichEditor::make("body")->required()->columnSpanFull(),
            Select::make("status")->options(["draft"=>"Draft","published"=>"Published"])->default("draft")->required(),
            Toggle::make("is_featured")->default(false),
            DateTimePicker::make("published_at"),
        ]);
    }
}

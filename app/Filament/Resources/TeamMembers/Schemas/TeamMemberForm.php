<?php
namespace App\Filament\Resources\TeamMembers\Schemas;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
class TeamMemberForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make("name")->required()->maxLength(255)->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set("slug", Str::slug($state))),
            TextInput::make("slug")->required()->unique(ignoreRecord: true)->maxLength(255),
            TextInput::make("role")->required()->maxLength(255),
            TextInput::make("department")->maxLength(100),
            Textarea::make("bio")->rows(4)->columnSpanFull(),
            FileUpload::make("photo")->image()->disk("public")->directory("team"),
            TextInput::make("email")->email()->maxLength(255),
            TextInput::make("phone")->maxLength(50),
            TextInput::make("linkedin")->maxLength(255),
            TextInput::make("twitter")->maxLength(255),
            TextInput::make("sort_order")->numeric()->default(0),
            Toggle::make("is_active")->default(true),
            Toggle::make("show_on_site")->default(true),
        ]);
    }
}

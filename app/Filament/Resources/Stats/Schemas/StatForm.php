<?php
namespace App\Filament\Resources\Stats\Schemas;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
class StatForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make("label")->required()->maxLength(255),
            TextInput::make("value")->required()->maxLength(50),
            TextInput::make("icon")->maxLength(100)->helperText("Heroicon name"),
            TextInput::make("description")->maxLength(255),
            TextInput::make("sort_order")->numeric()->default(0),
            Toggle::make("is_active")->default(true),
        ]);
    }
}

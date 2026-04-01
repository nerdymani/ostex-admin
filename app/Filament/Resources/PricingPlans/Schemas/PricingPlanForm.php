<?php
namespace App\Filament\Resources\PricingPlans\Schemas;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
class PricingPlanForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make("name")->required()->maxLength(255)->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set("slug", Str::slug($state))),
            TextInput::make("slug")->required()->unique(ignoreRecord: true)->maxLength(255),
            TextInput::make("price")->numeric()->prefix("$"),
            TextInput::make("price_label")->maxLength(100)->helperText("e.g. \$499 or Custom"),
            TextInput::make("billing_cycle")->maxLength(100),
            Textarea::make("description")->rows(3)->columnSpanFull(),
            Repeater::make("features")->schema([TextInput::make("item")->required()->label("Feature")])->columnSpanFull(),
            TextInput::make("cta_label")->default("Get Started")->maxLength(100),
            TextInput::make("cta_url")->url()->maxLength(255),
            TextInput::make("sort_order")->numeric()->default(0),
            Toggle::make("is_featured")->default(false),
            Toggle::make("is_active")->default(true),
        ]);
    }
}

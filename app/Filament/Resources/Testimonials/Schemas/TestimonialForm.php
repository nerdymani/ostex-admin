<?php
namespace App\Filament\Resources\Testimonials\Schemas;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
class TestimonialForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make("name")->required()->maxLength(255),
            TextInput::make("role")->maxLength(255),
            TextInput::make("company")->maxLength(255),
            Select::make("rating")->options(["1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"])->default("5"),
            Textarea::make("message")->required()->rows(4)->columnSpanFull(),
            FileUpload::make("photo")->image()->disk("public")->directory("testimonials"),
            TextInput::make("sort_order")->numeric()->default(0),
            Toggle::make("is_approved")->default(false),
            Toggle::make("is_featured")->default(false),
        ]);
    }
}

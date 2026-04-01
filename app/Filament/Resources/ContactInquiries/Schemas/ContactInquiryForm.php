<?php
namespace App\Filament\Resources\ContactInquiries\Schemas;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
class ContactInquiryForm {
    public static function configure(Schema $schema): Schema {
        return $schema->components([
            TextInput::make("name")->disabled(),
            TextInput::make("email")->disabled(),
            TextInput::make("phone")->disabled(),
            TextInput::make("company")->disabled(),
            TextInput::make("subject")->disabled(),
            TextInput::make("type")->disabled(),
            Select::make("status")->options(["new"=>"New","read"=>"Read","replied"=>"Replied"]),
            Placeholder::make("message")->content(fn ($record) => $record?->message)->columnSpanFull(),
        ]);
    }
}

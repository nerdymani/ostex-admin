<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = "heroicon-o-cog";
    protected static string|\UnitEnum|null $navigationGroup = "System";
    protected static ?string $title = "Settings";

    protected string $view = 'filament.pages.manage-settings';

    public array $data = [];

    public function mount(): void
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('site_name')->label('Site Name')->required(),
            TextInput::make('site_tagline')->label('Tagline'),
            TextInput::make('site_email')->label('Contact Email')->email(),
            TextInput::make('site_phone')->label('Phone'),
            TextInput::make('site_address')->label('Address'),
            TextInput::make('social_facebook')->label('Facebook URL'),
            TextInput::make('social_twitter')->label('Twitter/X URL'),
            TextInput::make('social_linkedin')->label('LinkedIn URL'),
            TextInput::make('social_instagram')->label('Instagram URL'),
            FileUpload::make('site_logo')->label('Site Logo')->image()->disk('public')->directory('settings'),
            FileUpload::make('site_favicon')->label('Favicon')->image()->disk('public')->directory('settings'),
            Toggle::make('maintenance_mode')->label('Maintenance Mode'),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }
        Notification::make()->title('Settings saved')->success()->send();
    }
}

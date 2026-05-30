<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationLabel = 'Store Settings';

    protected static ?string $title = 'Store Settings';

    protected static ?int $navigationSort = 9;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'store_name' => Setting::get('store_name', 'BW E-commerce'),
            'store_email' => Setting::get('store_email', 'info@bytewebster.com'),
            'store_phone' => Setting::get('store_phone', '+91 99999 99999'),
            'store_address' => Setting::get('store_address', '123 Tech Park, India'),
            'shipping_cost' => Setting::get('shipping_cost', 0.00),
            'facebook_url' => Setting::get('facebook_url', 'https://facebook.com/bytewebster'),
            'instagram_url' => Setting::get('instagram_url', 'https://instagram.com/bytewebster'),
            'twitter_url' => Setting::get('twitter_url', 'https://twitter.com/bytewebster'),
            'maintenance_mode' => (bool) Setting::get('maintenance_mode', false),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Configuration')
                    ->description('Primary contact details for the e-commerce store.')
                    ->schema([
                        TextInput::make('store_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('store_email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('store_phone')
                            ->maxLength(255),
                        Textarea::make('store_address')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Shipping Options')
                    ->description('Default shipping configurations.')
                    ->schema([
                        TextInput::make('shipping_cost')
                            ->numeric()
                            ->prefix('INR')
                            ->required(),
                    ]),

                Section::make('Social Media Accounts')
                    ->description('Configure profile links for store social networks.')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->url()
                            ->placeholder('https://facebook.com/username'),
                        TextInput::make('instagram_url')
                            ->url()
                            ->placeholder('https://instagram.com/username'),
                        TextInput::make('twitter_url')
                            ->url()
                            ->placeholder('https://twitter.com/username'),
                    ])->columns(3),

                Section::make('Advanced & Status Controls')
                    ->description('Control system behavior.')
                    ->schema([
                        Toggle::make('maintenance_mode')
                            ->label('Enable Maintenance Mode')
                            ->helperText('Turns off the frontend customer-facing catalog.'),
                    ])
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Store settings saved successfully!')
            ->success()
            ->send();
    }
}

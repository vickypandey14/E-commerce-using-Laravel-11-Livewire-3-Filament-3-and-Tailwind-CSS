<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.pages.edit-profile';

    // Hide from the main sidebar list; we will link it via the avatar dropdown
    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile Information')
                    ->description('Update your account name.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),

                Section::make('Update Password')
                    ->description('Ensure your account is using a long, random password.')
                    ->schema([
                        TextInput::make('current_password')
                            ->password()
                            ->currentPassword()
                            ->revealable()
                            ->requiredWith('new_password'),

                        TextInput::make('new_password')
                            ->password()
                            ->label('New Password')
                            ->rule(Password::default())
                            ->revealable()
                            ->requiredWith('current_password'),

                        TextInput::make('new_password_confirmation')
                            ->password()
                            ->label('Confirm New Password')
                            ->same('new_password')
                            ->revealable()
                            ->requiredWith('new_password'),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $user = auth()->user();

        $userData = [
            'name' => $state['name'],
        ];

        if (!empty($state['new_password'])) {
            $userData['password'] = Hash::make($state['new_password']);
        }

        $user->update($userData);

        if (!empty($state['new_password'])) {
            auth()->login($user);
        }

        $this->form->fill([
            'name' => $user->name,
        ]);

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }
}

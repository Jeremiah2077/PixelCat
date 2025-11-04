<?php

namespace App\Filament\Photographer\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected static string $view = 'filament.photographer.pages.edit-profile';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->description('Update your personal information and avatar')
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Avatar')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->directory('avatars')
                            ->visibility('public')
                            ->columnSpanFull(),
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),

                Section::make('Brand Information')
                    ->description('Set your brand information')
                    ->schema([
                        TextInput::make('brand_name')
                            ->label('Brand Name')
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(255),
                        Textarea::make('bio')
                            ->label('Bio')
                            ->rows(4)
                            ->maxLength(1000),
                    ]),

                Section::make('Social Media')
                    ->description('Add your social media links')
                    ->schema([
                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->maxLength(255)
                            ->prefix('@'),
                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255)
                            ->prefix('https://'),
                    ]),

                Section::make('Change Password')
                    ->description('Update your password')
                    ->schema([
                        TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->revealable()
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(8)
                            ->same('passwordConfirmation'),
                        TextInput::make('passwordConfirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->revealable()
                            ->dehydrated(false),
                    ]),
            ]);
    }
}

<?php

namespace App\Filament\Teacher\Pages;

use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?int $navigationSort = 100;
    protected static string $view = 'filament.teacher.pages.edit-profile';

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $teacher = auth()->user()->teacher;
        
        $this->profileData = [
            'name' => $teacher?->name ?? auth()->user()->name,
            'email' => $teacher?->email ?? auth()->user()->email,
            'phone' => $teacher?->phone,
            'specialization' => $teacher?->specialization,
        ];
    }

    protected function getProfileFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Personal Information')
                ->description('Update your personal details')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(20),
                    Forms\Components\TextInput::make('specialization')
                        ->label('Subject Specialization')
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('profile_picture')
                        ->label('Profile Picture')
                        ->image()
                        ->avatar()
                        ->directory('teacher-profiles')
                        ->maxSize(2048),
                ])
                ->columns(2),
        ];
    }

    protected function getPasswordFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Change Password')
                ->description('Update your login credentials')
                ->schema([
                    Forms\Components\TextInput::make('current_password')
                        ->password()
                        ->required()
                        ->currentPassword()
                        ->revealable(),
                    Forms\Components\TextInput::make('new_password')
                        ->password()
                        ->required()
                        ->rule(Password::defaults())
                        ->revealable(),
                    Forms\Components\TextInput::make('new_password_confirmation')
                        ->password()
                        ->required()
                        ->same('new_password')
                        ->revealable(),
                ])
                ->columns(1),
        ];
    }

    public function updateProfile(): void
    {
        $data = $this->profileData;
        
        $teacher = auth()->user()->teacher;
        
        if ($teacher) {
            $teacher->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'specialization' => $data['specialization'] ?? null,
                'profile_picture' => $data['profile_picture'] ?? $teacher->profile_picture,
            ]);
        }

        auth()->user()->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        Notification::make()
            ->success()
            ->title('Profile Updated')
            ->body('Your profile has been updated successfully.')
            ->send();
    }

    public function updatePassword(): void
    {
        $data = $this->passwordData;

        auth()->user()->update([
            'password' => Hash::make($data['new_password']),
        ]);

        $this->passwordData = [];

        Notification::make()
            ->success()
            ->title('Password Changed')
            ->body('Your password has been updated successfully.')
            ->send();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Account extends Page
{
    public $name;
    public $email;
    public $password;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static string $view = 'filament.pages.account';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Settings';

    protected function me()
    {
        return Auth::user();
    }

    public function mount()
    {
        $user = User::firstWhere('id', $this->me()->id);
        $this->name = $user?->name;
        $this->email = $user?->email;
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
        ], [
            'name.required' => 'Currency field cannot be empty.',
            'email.required' => 'email field cannot be empty.',
        ]);

        $setting = User::firstWhere('id', $this->me()->id);
        $setting->name = $this->name;
        $setting->email = $this->email;
        $setting->password = $this->password;
        $setting->save();

        Notification::make()
            ->title('Account updated successfully!')
            ->success()
            ->send();
    }
}

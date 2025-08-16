<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Setting;
use Filament\Notifications\Notification;

class Settings extends Page
{
    public $currency;
    public $timezone;
    public $timezones = [];

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationGroup = 'Settings';

    public function mount()
    {
        $setting = Setting::first();
        $this->currency = $setting?->currency;
        $this->timezone = $setting?->timezone;

        $this->timezones = collect(timezone_identifiers_list())
            ->mapWithKeys(fn($tz) => [$tz => $tz])
            ->toArray();
    }

    public function submit()
    {
        $this->validate([
            'currency' => 'required',
            'timezone' => 'required',
        ], [
            'currency.required' => 'Currency field cannot be empty.',
            'timezone.required' => 'Timezone field cannot be empty.',
        ]);

        $setting = Setting::first() ?? new Setting();
        $setting->currency = $this->currency;
        $setting->timezone = $this->timezone;
        $setting->save();

        Notification::make()
            ->title('Settings updated successfully!')
            ->success()
            ->send();
    }
}

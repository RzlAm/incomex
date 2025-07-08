<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\HtmlString;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            fn(): string => new HtmlString('
            <link rel="icon" type="image/png" href="' . asset('favicon-96x96.png') . '" sizes="96x96" />
            <link rel="icon" type="image/svg+xml" href="' . asset('favicon.svg') . '" />
            <link rel="shortcut icon" href="' . asset('favicon.ico') . '" />
            <link rel="apple-touch-icon" sizes="180x180" href="' . asset('apple-touch-icon.png') . '" />
            <meta name="apple-mobile-web-app-title" content="Incomex" />
            <link rel="manifest" href="' . asset('site.webmanifest') . '" />
        ')
        );

        if (Schema::hasTable('settings')) {
            $tz = DB::table('settings')->value('timezone');

            if ($tz) {
                Config::set('app.timezone', $tz);
                date_default_timezone_set($tz);
            }
        }
    }
}

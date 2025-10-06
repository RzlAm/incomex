<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('/')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->renderHook(
                PanelsRenderHook::HEAD_END,
                function (): string {
                    return Blade::render('@laravelPWA');
                }
            )->renderHook(
                PanelsRenderHook::BODY_END,
                function (): ?string {
                    if (request()->routeIs('filament.app.auth.login')) {
                        return null;
                    }

                    return view('components.filament-bottom-navbar', [
                        'items' => [
                            [
                                'label' => 'Home',
                                'icon'  => 'heroicon-o-home',
                                'url'   => route('filament.app.pages.dashboard'),
                                'active' => 'filament.app.pages.dashboard',
                            ],
                            [
                                'label' => 'Statistics',
                                'icon'  => 'heroicon-o-chart-bar',
                                'url'   => route('filament.app.pages.statistics'),
                                'active' => 'filament.app.pages.statistics',
                            ],
                            [
                                'label' => 'Transaksi',
                                'icon'  => 'heroicon-o-banknotes',
                                'url'   => route('filament.app.resources.transactions.index'),
                                'active' => 'filament.app.resources.transactions.*',
                            ],
                            [
                                'label' => 'Backup',
                                'icon'  => 'heroicon-o-cloud-arrow-up',
                                'url'   => route('filament.app.pages.backup'),
                                'active' => 'filament.app.pages.backup',
                            ],
                            [
                                'label' => 'Settings',
                                'icon'  => 'heroicon-o-cog-6-tooth',
                                'url'   => route('filament.app.pages.settings'),
                                'active' => 'filament.app.pages.settings',
                            ],
                        ],
                    ])->render();
                }
            )->renderHook(
                PanelsRenderHook::BODY_START,
                fn(): string => "
                    <style>
                        body {
                            padding-bottom: 4.5rem; /* cukup buat tinggi navbar */
                        }

                        /* biar aman di dark mode juga */
                        @media (min-width: 640px) {
                            body {
                                padding-bottom: 0 !important; /* di desktop, navbar disembunyiin */
                            }
                        }
                    </style>
                "
            );
    }
}

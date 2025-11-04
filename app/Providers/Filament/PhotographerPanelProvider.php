<?php

namespace App\Providers\Filament;

use App\Filament\Photographer\Pages\EditProfile;
use App\Http\Middleware\CheckPhotographerStatus;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PhotographerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('photographer')
            ->path('photographer')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->profile(EditProfile::class)
            ->colors([
                'primary' => Color::hex('#1e3a8a'),  // 海军蓝
                'success' => Color::hex('#065f46'),  // 深绿
                'warning' => Color::hex('#d97706'),  // 琥珀色
                'danger' => Color::hex('#dc2626'),   // 红色
                'info' => Color::hex('#0284c7'),     // 天蓝
            ])
            ->authGuard('photographer')
            ->authPasswordBroker('photographers')
            ->brandName('Photographer Panel')
            ->discoverResources(in: app_path('Filament/Photographer/Resources'), for: 'App\\Filament\\Photographer\\Resources')
            ->discoverPages(in: app_path('Filament/Photographer/Pages'), for: 'App\\Filament\\Photographer\\Pages')
            ->pages([
                \App\Filament\Photographer\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Photographer/Widgets'), for: 'App\\Filament\\Photographer\\Widgets')
            ->widgets([])
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
                CheckPhotographerStatus::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

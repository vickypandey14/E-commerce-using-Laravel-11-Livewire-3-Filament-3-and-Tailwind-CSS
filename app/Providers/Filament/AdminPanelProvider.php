<?php

namespace App\Providers\Filament;

use App\Filament\Resources\OrderResource\Widgets\OrderStats;
use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('BW E-commerce')
            ->userMenuItems([
                'profile' => \Filament\Navigation\UserMenuItem::make()
                    ->url(fn (): string => \App\Filament\Pages\EditProfile::getUrl()),
                'change_password' => \Filament\Navigation\UserMenuItem::make()
                    ->label('Change Password')
                    ->icon('heroicon-o-key')
                    ->url(fn (): string => \App\Filament\Pages\EditProfile::getUrl()),
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                \Filament\Navigation\NavigationGroup::make()
                    ->label('User')
                    ->collapsible(false),
                \Filament\Navigation\NavigationGroup::make()
                    ->label('Shop')
                    ->collapsible(false),
                \Filament\Navigation\NavigationGroup::make()
                    ->label('Settings')
                    ->collapsible(false),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                OrderStats::class,
                \App\Filament\Widgets\CustomAccountWidget::class,
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
            ]);
    }

    public function boot(): void
    {
        \Filament\Support\Facades\FilamentView::registerRenderHook(
            \Filament\View\PanelsRenderHook::HEAD_END,
            fn (): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString('
                <style>
                    /* Hide scrollbar for Chrome, Safari and Opera */
                    .fi-sidebar-nav::-webkit-scrollbar,
                    .fi-sidebar::-webkit-scrollbar,
                    .fi-sidebar-nav-container::-webkit-scrollbar {
                        display: none !important;
                    }
                    /* Hide scrollbar for IE, Edge and Firefox */
                    .fi-sidebar-nav,
                    .fi-sidebar,
                    .fi-sidebar-nav-container {
                        -ms-overflow-style: none !important;  /* IE and Edge */
                        scrollbar-width: none !important;  /* Firefox */
                    }
                </style>
            '),
        );
    }
}

<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TeacherPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('teacher')
            ->path('teacher')
            // ->login() // Disabled - using standalone login at /login
            ->colors([
                // === INSTRUCTIONAL ACTIONS (Primary) ===
                'primary' => Color::hex('#3B82F6'), // Sapphire Blue
                
                // === COGNITIVE HIERARCHY COLORS ===
                'knowledge' => Color::hex('#10B981'),    // Emerald Green - Completed work, mastery
                'instruction' => Color::hex('#3B82F6'),  // Sapphire Blue - Teaching materials
                'attention' => Color::hex('#F59E0B'),    // Amber Gold - Requires action
                'analytics' => Color::hex('#8B5CF6'),    // Royal Purple - Data & metrics
                'engagement' => Color::hex('#EC4899'),   // Coral Pink - Student interaction
                
                // === STANDARD SEMANTIC COLORS ===
                'success' => Color::hex('#10B981'),      // Emerald - Aligned with knowledge
                'warning' => Color::hex('#F59E0B'),      // Amber - Aligned with attention
                'danger' => Color::hex('#EF4444'),       // Red - Critical issues
                'info' => Color::hex('#3B82F6'),         // Blue - Aligned with instruction
                
                // === NEUTRAL PALETTE ===
                'gray' => Color::Slate,
            ])
            ->font('Inter')
            ->sidebarWidth('18rem')
            ->sidebarCollapsibleOnDesktop()
            ->brandName('Teacher Portal')
            ->brandLogo(asset('school_logo_1766441408212.png'))
            ->brandLogoHeight('3rem')
            ->darkMode(true)
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->discoverResources(in: app_path('Filament/Teacher/Resources'), for: 'App\\Filament\\Teacher\\Resources')
            ->discoverPages(in: app_path('Filament/Teacher/Pages'), for: 'App\\Filament\\Teacher\\Pages')
            ->pages([
                \App\Filament\Teacher\Pages\TeacherDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Teacher/Widgets'), for: 'App\\Filament\\Teacher\\Widgets')
            ->widgets([
                \App\Filament\Teacher\Widgets\WelcomeHeaderWidget::class,
                \App\Filament\Teacher\Widgets\TeacherStatsWidget::class,
                \App\Filament\Teacher\Widgets\RecentMarksWidget::class,
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
            ])
            ->renderHook(
                'panels::head.end',
                fn (): string => '<link rel="stylesheet" href="' . asset('css/filament/teacher/theme.css') . '" />'
            )
            ->profile()
            ->passwordReset();
    }
}

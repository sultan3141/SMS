<?php

namespace App\Filament\Teacher\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeHeaderWidget extends Widget
{
    protected static string $view = 'filament.teacher.widgets.welcome-header-widget';

    protected int | string | array $columnSpan = 'full';

    public function getUserName(): string
    {
        return Auth::user()->name ?? 'Teacher';
    }
}

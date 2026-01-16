<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class TeacherDashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $routePath = '/';
    protected static ?string $title = 'Dashboard';

    public function getHeading(): string
    {
        $teacher = auth()->user()->teacher;
        $name = $teacher ? $teacher->name : auth()->user()->name;
        
        return 'Welcome back, ' . $name . '!';
    }

    public function getSubheading(): ?string
    {
        return 'Manage your students\' marks and academic records';
    }
}

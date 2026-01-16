<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::count())
                ->description('Active students')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Dummy trend for visual appeal

            Stat::make('Total Teachers', Teacher::count())
                ->description('Faculty members')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),

            Stat::make('Total Courses', Course::count())
                ->description('Available courses')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('info'),

            Stat::make('Total Classes', SchoolClass::count())
                ->description('Active classes')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('warning'),
        ];
    }
}

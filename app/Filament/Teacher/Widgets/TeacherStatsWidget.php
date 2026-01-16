<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Mark;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TeacherStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $teacher = auth()->user()->teacher;
        $teacherId = $teacher?->id;

        $totalMarks = Mark::when($teacherId, fn($q) => $q->where('teacher_id', $teacherId))->count();
        $pendingSubmissions = Mark::when($teacherId, fn($q) => $q->where('teacher_id', $teacherId))
            ->where('is_submitted', false)
            ->count();
        $submittedMarks = Mark::when($teacherId, fn($q) => $q->where('teacher_id', $teacherId))
            ->where('is_submitted', true)
            ->count();
        $totalStudents = Student::count();

        return [
            Stat::make('Total Marks Entered', $totalMarks)
                ->description('All assessment records')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('knowledge')  // Emerald Green - Knowledge Acquisition
                ->chart([7, 3, 4, 5, 6, 3, 5, 8]),

            Stat::make('Pending Submissions', $pendingSubmissions)
                ->description('Awaiting submission')
                ->descriptionIcon('heroicon-m-clock')
                ->color('attention')  // Amber Gold - Attention Required (with pulse animation in CSS)
                ->chart([3, 5, 7, 4, 6, 8, 5, 4]),

            Stat::make('Submitted Marks', $submittedMarks)
                ->description('Finalized records')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('knowledge')  // Emerald Green - Knowledge Mastery/Completion
                ->chart([5, 4, 6, 7, 8, 9, 10, 12]),

            Stat::make('Total Students', $totalStudents)
                ->description('Enrolled students')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('engagement'),  // Coral Pink - Student Engagement
        ];
    }
}

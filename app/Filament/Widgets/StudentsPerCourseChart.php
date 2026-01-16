<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

use App\Models\Course;

class StudentsPerCourseChart extends ChartWidget
{
    protected ?string $heading = 'Students per Course';

    protected function getData(): array
    {
        $data = Course::withCount('enrollments')
            ->pluck('enrollments_count', 'name')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Students',
                    'data' => array_values($data),
                    'backgroundColor' => '#3b82f6', // Blue
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

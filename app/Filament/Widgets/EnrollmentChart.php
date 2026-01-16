<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

class EnrollmentChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Enrollments';

    protected function getData(): array
    {
        $data = Enrollment::select(DB::raw("strftime('%Y-%m', created_at) as month"), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Enrollments',
                    'data' => array_values($data),
                    'borderColor' => '#9333ea',
                    'fill' => 'start',
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

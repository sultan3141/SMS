<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Mark;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentMarksWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Recent Marking Activity';

    public function table(Table $table): Table
    {
        $teacher = auth()->user()->teacher;
        $teacherId = $teacher?->id;

        return $table
            ->query(
                Mark::query()
                    ->when($teacherId, fn($q) => $q->where('teacher_id', $teacherId))
                    ->with(['student', 'subject', 'semester', 'academicYear'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Subject')
                    ->sortable(),
                Tables\Columns\TextColumn::make('assessment_type')
                    ->label('Assessment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Midterm' => 'info',
                        'Test' => 'warning',
                        'Assignment' => 'gray',
                        'Final' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->formatStateUsing(fn (Mark $record) => $record->score . '/' . $record->max_score),
                Tables\Columns\IconColumn::make('is_submitted')
                    ->label('Submitted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->paginated(false);
    }
}

<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\MarkResource\Pages;
use App\Models\AcademicYear;
use App\Models\Mark;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class MarkResource extends Resource
{
    protected static ?string $model = Mark::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-clipboard-document-check';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Academic';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Academic Context')
                    ->description('Select the academic period and class details')
                    ->schema([
                        Forms\Components\Select::make('academic_year_id')
                            ->label('Academic Year')
                            ->options(AcademicYear::pluck('name', 'id'))
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('semester_id', null)),

                        Forms\Components\Select::make('semester_id')
                            ->label('Semester')
                            ->options(fn (Get $get): Collection => 
                                Semester::where('academic_year_id', $get('academic_year_id'))
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->live()
                            ->disabled(fn (Get $get): bool => !$get('academic_year_id')),

                        Forms\Components\Select::make('school_class_id')
                            ->label('Grade/Class')
                            ->options(SchoolClass::pluck('name', 'id'))
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('section_id', null)),

                        Forms\Components\Select::make('section_id')
                            ->label('Section')
                            ->options(fn (Get $get): Collection => 
                                Section::where('school_class_id', $get('school_class_id'))
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->live()
                            ->disabled(fn (Get $get): bool => !$get('school_class_id'))
                            ->afterStateUpdated(fn (Set $set) => $set('student_id', null)),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Assessment Details')
                    ->description('Enter the subject and assessment information')
                    ->schema([
                        Forms\Components\Select::make('subject_id')
                            ->label('Subject')
                            ->options(Subject::pluck('name', 'id'))
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('assessment_type')
                            ->label('Assessment Type')
                            ->options(Mark::ASSESSMENT_TYPES)
                            ->required(),

                        Forms\Components\Select::make('student_id')
                            ->label('Student')
                            ->options(fn (Get $get): Collection => 
                                Student::query()
                                    ->when($get('school_class_id'), fn($q, $classId) => 
                                        $q->where('school_class_id', $classId)
                                    )
                                    ->when($get('section_id'), fn($q, $sectionId) => 
                                        $q->where('section_id', $sectionId)
                                    )
                                    ->get()
                                    ->pluck('full_info', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->disabled(fn (Get $get): bool => !$get('section_id')),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Score')
                    ->schema([
                        Forms\Components\TextInput::make('score')
                            ->label('Score')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(fn (Get $get) => $get('max_score') ?? 100)
                            ->step(0.01),

                        Forms\Components\TextInput::make('max_score')
                            ->label('Maximum Score')
                            ->numeric()
                            ->default(100)
                            ->required()
                            ->minValue(1),

                        Forms\Components\Textarea::make('remarks')
                            ->label('Remarks')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Hidden::make('teacher_id')
                    ->default(fn () => auth()->user()->teacher?->id),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.student_id')
                    ->label('Student ID')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Subject')
                    ->sortable(),
                Tables\Columns\TextColumn::make('schoolClass.name')
                    ->label('Grade')
                    ->sortable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->label('Section')
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.name')
                    ->label('Semester')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('assessment_type')
                    ->label('Assessment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Midterm' => 'instruction',    // Sapphire Blue - Instructional
                        'Test' => 'attention',         // Amber Gold - Attention/Assessment
                        'Assignment' => 'analytics',   // Royal Purple - Analytical work
                        'Final' => 'knowledge',        // Emerald Green - Knowledge Mastery
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->formatStateUsing(fn (Mark $record) => $record->score . '/' . $record->max_score)
                    ->sortable(),
                Tables\Columns\TextColumn::make('percentage')
                    ->label('%')
                    ->formatStateUsing(fn (Mark $record) => number_format($record->percentage, 1) . '%')
                    ->badge()
                    ->color(fn (Mark $record): string => match (true) {
                        $record->percentage >= 90 => 'knowledge',    // 90%+ Excellent - Emerald
                        $record->percentage >= 80 => 'success',      // 80-89% Good - Success gradient
                        $record->percentage >= 70 => 'instruction',  // 70-79% Satisfactory - Blue
                        $record->percentage >= 60 => 'attention',    // 60-69% Needs attention - Amber
                        default => 'danger',                         // <60% Critical - Red
                    }),
                Tables\Columns\IconColumn::make('is_submitted')
                    ->label('Submitted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('academic_year_id')
                    ->label('Academic Year')
                    ->options(AcademicYear::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('semester_id')
                    ->label('Semester')
                    ->options(Semester::with('academicYear')->get()->pluck('full_name', 'id')),
                Tables\Filters\SelectFilter::make('school_class_id')
                    ->label('Grade')
                    ->options(SchoolClass::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label('Subject')
                    ->options(Subject::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('assessment_type')
                    ->label('Assessment Type')
                    ->options(Mark::ASSESSMENT_TYPES),
                Tables\Filters\TernaryFilter::make('is_submitted')
                    ->label('Submission Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('submit')
                    ->label('Submit')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Submit Mark')
                    ->modalDescription('Once submitted, this mark will be finalized and visible to students/administrators. Are you sure?')
                    ->visible(fn (Mark $record) => !$record->is_submitted)
                    ->action(function (Mark $record) {
                        $record->update([
                            'is_submitted' => true,
                            'submitted_at' => now(),
                        ]);
                    }),
                Tables\Actions\Action::make('audit')
                    ->label('History')
                    ->icon('heroicon-o-clock')
                    ->color('gray')
                    ->modalHeading('Mark Change History')
                    ->modalContent(fn (Mark $record) => view('filament.teacher.mark-audit-log', [
                        'logs' => $record->auditLogs()->with('teacher')->latest()->get()
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('submitSelected')
                    ->label('Submit Selected')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Submit Selected Marks')
                    ->modalDescription('This will finalize all selected marks. Continue?')
                    ->action(function (Collection $records) {
                        $records->each(fn (Mark $record) => $record->update([
                            'is_submitted' => true,
                            'submitted_at' => now(),
                        ]));
                    }),
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => false), // Disable bulk delete
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $teacher = auth()->user()->teacher;
        
        return parent::getEloquentQuery()
            ->when($teacher, fn (Builder $query) => $query->where('teacher_id', $teacher->id));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarks::route('/'),
            'create' => Pages\CreateMark::route('/create'),
            'edit' => Pages\EditMark::route('/{record}/edit'),
        ];
    }
}

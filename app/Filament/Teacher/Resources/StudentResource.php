<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\StudentResource\Pages;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-user-group';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Academic';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student_id')
                    ->label('Student ID')
                    ->searchable()
                    ->badge()
                    ->color('instruction'),  // Sapphire Blue - Instructional context
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('schoolClass.name')
                    ->label('Grade')
                    ->sortable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->label('Section')
                    ->sortable(),
                Tables\Columns\TextColumn::make('marks_count')
                    ->label('Marks')
                    ->counts('marks')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('school_class_id')
                    ->label('Grade')
                    ->options(SchoolClass::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('section_id')
                    ->label('Section')
                    ->options(Section::with('schoolClass')->get()->pluck('full_name', 'id')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}

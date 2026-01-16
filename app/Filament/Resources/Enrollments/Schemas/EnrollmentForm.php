<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class EnrollmentForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('student_id')
                    ->required()
                    ->numeric(),
                TextInput::make('course_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}

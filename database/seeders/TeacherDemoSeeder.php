<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create a demo teacher user
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'John Smith',
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]
        );

        // Create teacher profile
        Teacher::firstOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'John Smith',
                'phone' => '+1234567890',
                'specialization' => 'Mathematics & Science',
                'user_id' => $teacherUser->id,
            ]
        );

        // Create academic year
        $academicYear = AcademicYear::firstOrCreate(
            ['name' => '2025-2026'],
            [
                'start_date' => '2025-09-01',
                'end_date' => '2026-06-30',
                'is_current' => true,
            ]
        );

        // Create semesters
        Semester::firstOrCreate(
            ['name' => 'Semester 1', 'academic_year_id' => $academicYear->id],
            [
                'start_date' => '2025-09-01',
                'end_date' => '2026-01-31',
            ]
        );

        Semester::firstOrCreate(
            ['name' => 'Semester 2', 'academic_year_id' => $academicYear->id],
            [
                'start_date' => '2026-02-01',
                'end_date' => '2026-06-30',
            ]
        );

        // Create subjects
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH101'],
            ['name' => 'English', 'code' => 'ENG101'],
            ['name' => 'Science', 'code' => 'SCI101'],
            ['name' => 'History', 'code' => 'HIST101'],
            ['name' => 'Geography', 'code' => 'GEO101'],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(
                ['code' => $subject['code']],
                $subject
            );
        }

        // Create sections for existing school classes
        $classes = SchoolClass::all();
        foreach ($classes as $class) {
            Section::firstOrCreate(
                ['name' => 'A', 'school_class_id' => $class->id]
            );
            Section::firstOrCreate(
                ['name' => 'B', 'school_class_id' => $class->id]
            );
        }

        $this->command->info('Demo teacher seeded: teacher@school.com / password');
    }
}

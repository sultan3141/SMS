<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mark extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'academic_year_id',
        'school_class_id',
        'section_id',
        'semester_id',
        'teacher_id',
        'assessment_type',
        'score',
        'max_score',
        'remarks',
        'is_submitted',
        'submitted_at',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'is_submitted' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public const ASSESSMENT_TYPES = [
        'Midterm' => 'Midterm',
        'Test' => 'Test',
        'Assignment' => 'Assignment',
        'Final' => 'Final',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(MarkAuditLog::class);
    }

    public function getPercentageAttribute(): float
    {
        return $this->max_score > 0 ? ($this->score / $this->max_score) * 100 : 0;
    }

    public function getGradeLetterAttribute(): string
    {
        $percentage = $this->percentage;
        
        return match (true) {
            $percentage >= 90 => 'A+',
            $percentage >= 85 => 'A',
            $percentage >= 80 => 'A-',
            $percentage >= 75 => 'B+',
            $percentage >= 70 => 'B',
            $percentage >= 65 => 'B-',
            $percentage >= 60 => 'C+',
            $percentage >= 55 => 'C',
            $percentage >= 50 => 'C-',
            $percentage >= 45 => 'D',
            default => 'F',
        };
    }

    protected static function booted(): void
    {
        static::created(function (Mark $mark) {
            MarkAuditLog::create([
                'mark_id' => $mark->id,
                'teacher_id' => $mark->teacher_id,
                'old_score' => null,
                'new_score' => $mark->score,
                'action' => 'created',
            ]);
        });

        static::updating(function (Mark $mark) {
            if ($mark->isDirty('score')) {
                MarkAuditLog::create([
                    'mark_id' => $mark->id,
                    'teacher_id' => $mark->teacher_id,
                    'old_score' => $mark->getOriginal('score'),
                    'new_score' => $mark->score,
                    'action' => $mark->is_submitted ? 'submitted' : 'updated',
                ]);
            }
        });
    }
}

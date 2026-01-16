<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'student_id',
        'date_of_birth',
        'phone',
        'address',
        'school_class_id',
        'section_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function getFullInfoAttribute(): string
    {
        $info = $this->name . ' (' . $this->student_id . ')';
        if ($this->schoolClass) {
            $info .= ' - ' . $this->schoolClass->name;
        }
        if ($this->section) {
            $info .= ' ' . $this->section->name;
        }
        return $info;
    }
}

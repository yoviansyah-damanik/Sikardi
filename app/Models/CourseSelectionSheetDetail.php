<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class CourseSelectionSheetDetail extends Model
{
    protected $guarded = ['id'];

    public function css(): BelongsTo
    {
        return $this->belongsTo(CourseSelectionSheet::class, 'course_selection_sheet_id', 'id');
    }

    public function student(): HasOneThrough
    {
        return $this->hasOneThrough(Student::class, CourseSelectionSheet::class);
    }

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class)
            ->orderBy('name', 'asc');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class)
            ->orderBy('semester', 'asc')
            ->orderBy('name', 'asc');
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }
}

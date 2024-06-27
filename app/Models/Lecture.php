<?php

namespace App\Models;

use App\Enums\CssStatus;
use App\Enums\DayChoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Lecture extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['day_name', 'course_name', 'room_name'];

    public function courseName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->course->name
        );
    }

    public function roomName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->room->name
        );
    }

    public function dayName(): Attribute
    {
        return new Attribute(
            get: fn () => __(DayChoice::getName($this->day)->value)
        );
    }

    public function choosen(): Attribute
    {
        return new Attribute(
            get: fn () => $this->css->filter(fn ($q) => $q->css->status == CssStatus::approved->name && $q->css->year == \Carbon\Carbon::now()->year)->count() ?? 0
        );
    }

    public function remainder(): Attribute
    {
        return new Attribute(
            get: fn () => $this->limit - $this->choosen
        );
    }

    // public function css_2(): HasMany
    // {
    //     return $this->hasMany(CourseSelectionSheetDetail::class, 'id', 'lecture_id')
    //         ->whereHas('css', fn ($q) => $q->where('status', '!=', CssStatus::revision->name));
    // }

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

    public function curriculum(): HasOneThrough
    {
        return $this->hasOneThrough(Curriculum::class, Course::class, 'id', 'id', 'course_id', 'curriculum_id');
    }

    public function css(): HasMany
    {
        return $this->hasMany(CourseSelectionSheetDetail::class, 'lecture_id', 'id');
    }

    public function cssThrough(): HasOneThrough
    {
        return $this->hasOneThrough(CourseSelectionSheet::class, CourseSelectionSheetDetail::class, 'lecture_id', 'id', 'id', 'course_selection_sheet_id');
    }
}

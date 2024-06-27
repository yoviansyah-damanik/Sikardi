<?php

namespace App\Models;

use App\Enums\CssStatus;
use App\Helpers\GeneralHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Student extends Model
{
    use HasFactory;
    const CALLED = 'student';

    protected $guarded = ['created_at'];
    protected $primaryKey = 'id';
    protected $routeKeyName = 'id';
    public $incrementing = false;

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    protected function semester(): Attribute
    {
        return new Attribute(
            get: fn () => $this->passed ? $this->passed->semester : GeneralHelper::semester($this->stamp)
        );
    }

    protected function cssNow(): Attribute
    {
        return new Attribute(
            get: fn () => $this->css->where('semester', $this->semester)
                ->first()
        );
    }

    protected function genderFull(): Attribute
    {
        return new Attribute(
            get: fn () => $this->gender == 'L' ? 'Laki-laki' : 'Perempuan'
        );
    }

    public function userable(): MorphOne
    {
        return $this->morphOne(UserType::class, 'userable');
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            UserType::class,
            'userable_id',
            'id',
            'id',
            'user_id'
        )
            ->where('userable_type', \App\Models\Student::class);
    }

    public function supervisorThrough(): HasOne
    {
        return $this->hasOne(Supervisor::class);
    }

    public function supervisor(): HasOneThrough
    {
        return $this->hasOneThrough(Lecturer::class, Supervisor::class, 'student_id', 'id', 'id', 'lecturer_id');
    }

    public function css(): HasMany
    {
        return $this->hasMany(CourseSelectionSheet::class);
    }

    public function lectures(): HasManyThrough
    {
        return $this->hasManyThrough(CourseSelectionSheetDetail::class, CourseSelectionSheet::class, 'student_id', 'course_selection_sheet_id', 'id', 'id')
            ->where('course_selection_sheets.type', GeneralHelper::currentSemester())
            ->where('course_selection_sheets.status', CssStatus::approved->name);
    }

    public function passed(): HasOne
    {
        return $this->hasOne(StudentPassed::class);
    }
}

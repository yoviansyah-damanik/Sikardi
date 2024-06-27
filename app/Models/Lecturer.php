<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Lecturer extends Model
{
    use HasFactory;

    const CALLED = 'lecturer';

    protected $guarded = ['created_at'];
    protected $primaryKey = 'id';

    public $routeKeyName = 'id';
    public $incrementing = false;

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
            ->where('userable_type', \App\Models\Lecturer::class);
    }

    public function supervisors(): HasMany
    {
        return $this->hasMany(Supervisor::class);
    }

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(Student::class, Supervisor::class, 'lecturer_id', 'id', 'id', 'student_id')
            ->orderBy('stamp', 'asc')
            ->orderBy('name', 'asc');
    }
}

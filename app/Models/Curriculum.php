<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Curriculum extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function lectures(): HasManyThrough
    {
        return $this->hasManyThrough(Lecture::class, Course::class, 'curriculum_id', 'course_id', 'id', 'id');
    }
}

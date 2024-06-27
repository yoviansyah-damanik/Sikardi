<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Staff extends Model
{
    use HasFactory;
    const CALLED = 'staff';
    protected $guarded = ['created_at'];
    protected $primaryKey = 'id';
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
            ->where('userable_type', \App\Models\Staff::class);
    }
}

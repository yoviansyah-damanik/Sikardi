<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'is_suspended'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function role(): Attribute
    {
        return new Attribute(
            get: fn () => $this->type->userable_type == \App\Models\Lecturer::class ? 'lecturer' : ($this->type->userable_type == \App\Models\Staff::class ? 'staff' : 'student')
        );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'id', 'user_id');
    }

    public function data(): HasOneThrough
    {
        if ($this->role == 'staff')
            return $this->hasOneThrough(Staff::class, UserType::class, 'user_id', 'id', 'id', 'userable_id');
        else if ($this->role == 'lecturer')
            return $this->hasOneThrough(Lecturer::class, UserType::class, 'user_id', 'id', 'id', 'userable_id');
        else
            return $this->hasOneThrough(Student::class, UserType::class, 'user_id', 'id', 'id', 'userable_id');
    }
}

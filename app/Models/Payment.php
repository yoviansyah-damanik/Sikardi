<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $guarded = ['id'];

    public function storageFile(bool $isFull = false)
    {
        return $isFull ? url(Storage::url($this->file_url)) : Storage::url($this->file_url);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

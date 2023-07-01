<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Option extends Model
{
    use HasFactory;

    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
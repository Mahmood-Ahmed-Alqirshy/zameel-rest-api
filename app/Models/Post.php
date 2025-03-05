<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'publisher_id',
        'subject_id',
        'taggable_id',
        'taggable_type',
        'content',
    ];

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

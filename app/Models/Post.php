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
        'taggable_id',
        'taggable_type',
        'content',
        'has_attachment',
    ];

    protected $casts = [
        'id' => 'integer',
        'publisher_id' => 'integer',
        'taggable_id' => 'integer',
        'has_attachment' => 'boolean',
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
        return $this->belongsTo(User::class, 'publisher_id');
    }
}

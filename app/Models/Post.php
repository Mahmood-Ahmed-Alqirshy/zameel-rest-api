<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function scopeTaggable($query)
    {
        $groups = Auth::user()->groups();
        $groupsIDs = $groups->pluck('id')->toArray();
        $majors = $groups->pluck('major_id')->toArray();
        $colleges = Major::whereIn('id', $majors)->pluck('college_id')->toArray();

        $query->where(function ($query) use ($colleges) {
            $query->where('taggable_type', 'App\\Models\\College')
                ->whereIn('taggable_id', $colleges);
        })->orWhere(function ($query) use ($majors) {
            $query->where('taggable_type', 'App\\Models\\Major')
                ->whereIn('taggable_id', $majors);
        })->orWhere(function ($query) use ($groupsIDs) {
            $query->where('taggable_type', 'App\\Models\\Group')
                ->whereIn('taggable_id', $groupsIDs);
        })->orWhereNull('taggable_type');
    }
}

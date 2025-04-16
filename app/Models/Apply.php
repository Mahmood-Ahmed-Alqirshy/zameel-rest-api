<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Apply extends Pivot
{
    use HasFactory;

    protected $table = 'group_user_applies';

    protected $fillable = [
        'group_id',
        'user_id',
        'status_id',
        'note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);;
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}

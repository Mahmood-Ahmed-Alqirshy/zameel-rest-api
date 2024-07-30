<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'user_id',
        'status_id',
        'note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'group_id' => 'integer',
        'user_id' => 'integer',
        'status_id' => 'integer',
    ];

    public function group(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function user(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }

    public function status(): BelongsToMany
    {
        return $this->BelongsToMany(Status::class);
    }
}

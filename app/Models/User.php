<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'group_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'group_id' => 'integer',
        'role_id' => 'integer',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    public function group(): belongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->using(Invite::class)
            ->as('invite')
            ->withPivot('status_id', 'note')
            ->withTimestamps();
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

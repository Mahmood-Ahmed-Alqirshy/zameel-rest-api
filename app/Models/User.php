<?php

namespace App\Models;

use App\Authorization\Abilities;
use App\Authorization\AuthorizationRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'group_id',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'id' => 'integer',
        'group_id' => 'integer',
        'role_id' => 'integer',
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function group(): belongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user_members');
    }

    public function applies(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user_applies')
            ->using(Apply::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'publisher_id');
    }

    public function abilities()
    {
        return Abilities::getAbilities(AuthorizationRole::from($this->role_id));
    }
}

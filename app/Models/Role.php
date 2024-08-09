<?php

namespace App\Models;

use App\Authorization\Abilities;
use App\Authorization\AuthorizationRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function abilities()
    {
        return Abilities::getAbilities(AuthorizationRole::from($this->id));
    }
}

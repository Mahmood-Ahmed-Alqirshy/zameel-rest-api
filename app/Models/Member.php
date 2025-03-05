<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Member extends Pivot
{
    use HasFactory;

    protected $table = 'group_user_members';

    protected $fillable = [
        'group_id',
        'user_id',
        'is_representer',
    ];

    protected $casts = [
        'is_representer' => 'boolean',
    ];
}

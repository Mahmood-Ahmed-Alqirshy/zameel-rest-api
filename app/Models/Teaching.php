<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Teaching extends Pivot
{
    use HasFactory;

    protected $table = 'group_subject_user';

    protected $fillable = [
        'group_id',
        'user_id',
        'subject_id',
    ];
}

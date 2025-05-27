<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AssistantChat extends Model
{
    use HasUuids;

    protected $fillable = [
        'messages',
    ];

    protected $casts = [
        'messages' => 'array',
    ];
}

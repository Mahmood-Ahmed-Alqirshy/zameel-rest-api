<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AssistantChat extends Model
{
    use HasUuids;

    protected $fillable = [
        'messages',
        'books',
    ];

    protected $casts = [
        'messages' => 'array',
        'books' => 'array',
    ];
}

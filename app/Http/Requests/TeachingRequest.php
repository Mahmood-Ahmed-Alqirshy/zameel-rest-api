<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class TeachingRequest extends Request
{
    public function storeRules(): array
    {
        return [
            'user_id' => 'required|integer|numeric|exists:users,id',
            'group_id' => 'required|integer|numeric|exists:groups,id',
            'subject_id' => 'required|integer|numeric|exists:subjects,id',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class SubjectRequest extends Request
{
    public function updateRules(): array
    {
        return [
            'name' => 'sometimes|string|max:75|unique:subjects,name',
        ];
    }

    public function storeRules(): array
    {
        return [
            'name' => 'required|string|max:75|unique:subjects,name',
        ];
    }
}

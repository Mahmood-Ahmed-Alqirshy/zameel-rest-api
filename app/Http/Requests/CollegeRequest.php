<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class CollegeRequest extends Request
{
    public function updateRules(): array
    {
        return [
            'name' => 'sometimes|string|max:45|regex:/^[\p{L}\p{M}\s]+$/u|unique:colleges,name',
        ];
    }

    public function storeRules(): array
    {
        return [
            'name' => 'required|string|max:45|regex:/^[\p{L}\p{M}\s]+$/u|unique:colleges,name',
        ];
    }
}

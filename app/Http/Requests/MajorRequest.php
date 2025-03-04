<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class MajorRequest extends Request
{
    public function storeRules(): array
    {
        return [
            'name' => 'required|string|regex:/^[\\p{L}\\p{M}\\s]+$/u|max:45|unique:majors,name',
            'years' => 'required|integer|between:1,8',
            'college_id' => 'required|integer|numeric|exists:colleges,id',
            'degree_id' => 'required|integer|numeric|exists:degrees,id',
        ];
    }

    public function updateRules(): array
    {
        return [
            'name' => 'sometimes|string|regex:/^[\\p{L}\\p{M}\\s]+$/u|max:45|unique:majors,name',
            'years' => 'sometimes|integer|between:1,8',
            'college_id' => 'sometimes|integer|numeric|exists:colleges,id',
            'degree_id' => 'sometimes|integer|numeric|exists:degrees,id',
        ];
    }
}

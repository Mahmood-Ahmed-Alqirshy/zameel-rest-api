<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class GroupRequest extends Request
{
    public function storeRules(): array
    {
        return [
            'join_year' => 'required|digits:4|integer|min:2015|max:'.date('Y'),
            'division' => 'required|string|size:1|regex:/^[A-Z]$/',
            'major_id' => 'required|integer|exists:majors,id',
        ];
    }
}

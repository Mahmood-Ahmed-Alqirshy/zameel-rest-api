<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class SubjectRequest extends Request
{
    public function commonRules(): array
    {
        return [
            'name' => 'required|string|max:70|regex:/^\p{L}[\p{L}\p{M}0-9\s():,!&#\-"\'.]*$/u|unique:subjects,name',
        ];
    }
}

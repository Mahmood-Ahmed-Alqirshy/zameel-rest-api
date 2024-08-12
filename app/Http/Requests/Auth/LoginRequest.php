<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    protected $map = [
        'data.attributes.email' => 'email',
        'data.attributes.password' => 'password',
        'meta.deviceName' => 'deviceName',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.email' => 'required|string|email|max:255',
            'data.attributes.password' => 'required|string',
            'meta.deviceName' => 'required|string|max:45',
        ];
    }
}

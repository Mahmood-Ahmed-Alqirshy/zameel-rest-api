<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends BaseRequest
{
    protected $map = [
        'data.atttibutes.email' => 'email',
        'data.atttibutes.password' => 'password',
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
            'data.atttibutes.email' => 'required|string|email|max:255',
            'data.atttibutes.password' => 'required|string',
            'meta.deviceName' => 'required|string|max:45',
        ];
    }
}

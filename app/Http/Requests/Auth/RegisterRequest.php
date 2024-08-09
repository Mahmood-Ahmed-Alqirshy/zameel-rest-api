<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends BaseRequest
{
    protected $map = [
        'data.atttibutes.name' => 'model.name',
        'data.atttibutes.email' => 'model.email',
        'data.atttibutes.password' => 'model.password',
        // 'data.relationships.group.data.id' =>'model.group_id',
        // 'data.relationships.role.data.id' =>  'model.role_id',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.atttibutes.name' => 'required|string|regex:/^[\p{L}\p{M}\s]+$/u|max:255',
            'data.atttibutes.email' => 'required|string|max:255|email',
            'data.atttibutes.password' => ['required', 'confirmed', Password::defaults()],
            // 'data.relationships.group.data.id' => 'required_with:data.relationships.group|integer|numeric|exists:groups,id',
            // 'data.relationships.role.data.id' => 'required|integer|numeric|exists:roles,id',
        ];
    }
}
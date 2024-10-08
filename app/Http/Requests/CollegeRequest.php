<?php

namespace App\Http\Requests;

class CollegeRequest extends BaseRequest
{
    protected $map = [
        'data.attributes.name' => 'model.name',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.name' => 'required|string|max:45|regex:/^[\p{L}\p{M}\s]+$/u|unique:colleges,name',
        ];
    }
}

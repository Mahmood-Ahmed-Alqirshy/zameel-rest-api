<?php

namespace App\Http\Requests;

class MajorRequest extends BaseRequest
{
    protected $map = [
        'data.attributes.name' => 'model.name',
        'data.attributes.years' => 'model.years',
        'data.relationships.college.data.id' => 'model.college_id',
        'data.relationships.degree.data.id' => 'model.degree_id',
    ];

    public function rules(): array
    {
        $requiredOrMissing = ($this->isMethod('patch') ? 'missing|' : 'required|');
        $requiredOrSometimes = ($this->isMethod('patch') ? 'sometimes|' : 'required|');

        return [
            'data.attributes.name' => $requiredOrMissing . 'string|regex:/^[\\p{L}\\p{M}\\s]+$/u|max:45|unique:majors,name',
            'data.attributes.years' => $requiredOrSometimes . 'integer|between:1,8',
            'data.relationships.college.data.id' => $requiredOrSometimes . 'integer|numeric|exists:colleges,id',
            'data.relationships.degree.data.id' => $requiredOrMissing . 'integer|numeric|exists:degrees,id',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\File;
use Orion\Http\Requests\Request;

class BookRequest extends Request
{
    private $fileTypes = ['pdf', 'docx', 'pptx', 'ppt'];

    public function storeRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'path' => ['required', 'file', File::types($this->fileTypes)->max(50 * 1024)],
            'subject_id' => 'required|integer|numeric|exists:subjects,id',
            'group_id' => 'sometimes|integer|numeric|exists:groups,id',
            'is_practical' => 'required|boolean',
            'year' => 'required|min:1|max:10',
            'semester' => 'required|min:1|max:2',
        ];
    }

    public function updateRules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'subject_id' => 'sometimes|integer|numeric|exists:subjects,id',
            'group_id' => 'sometimes|integer|numeric|exists:groups,id',
            'is_practical' => 'sometimes|boolean',
            'year' => 'sometimes|min:1|max:10',
            'semester' => 'sometimes|min:1|max:2',
        ];
    }
}

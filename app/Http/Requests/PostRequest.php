<?php

namespace App\Http\Requests;

use App\Models\College;
use App\Models\Group;
use App\Models\Major;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Orion\Http\Requests\Request;

class PostRequest extends Request
{
    private $models = [College::class, Major::class, Group::class];

    private $fileTypes = ['pdf', 'zip', 'rar', 'docx', 'pptx', 'ppt', 'psd', 'mpp', 'ai', 'm', 'mat', 'ino', 'h'];

    public function storeRules(): array
    {
        return [
            'subject_id' => 'nullable|integer|numeric|exists:subjects,id',
            'taggable_type' => [
                'string',
                Rule::in($this->models),
            ],
            'taggable_id' => [
                'required_with:taggable_type',
                'integer',
                'numeric',
                function ($attribute, $value, $fail) {
                    if (is_null($this->input('taggable_type'))) {
                        return $fail('Must provide taggable type with the ID.');
                    }

                    $model = $this->input('taggable_type');

                    if (! in_array($model, $this->models, true)) {
                        return $fail('Invalid taggable type.');
                    }

                    if (is_null($model::find($value))) {
                        return $fail('Invalid taggable ID.');
                    }
                },
            ],
            'content' => 'nullable|string',
            'attachment' => 'array',
            'attachment.type' => [
                'required_with:attachment',
                Rule::in(['images', 'file']),
            ],
            'attachment.images' => 'array|min:1|required_if:attachment.type,image',
            'attachment.images.*' => 'image|max:10240',
            'attachment.file' => [
                'required_if:attachment.type,file',
                File::types($this->fileTypes)
                    ->max(50 * 1024),
            ],
        ];
    }
}

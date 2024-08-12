<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class BaseRequest extends FormRequest
{
    protected $map = null;

    public function formattedData()
    {
        if ($this->map === null) {
            throw new Exception('unspecified $map', 3);
        }

        $formattedData = [];
        $validatedData = $this->validated();
        foreach ($this->map as $sourcePath => $destinationPath) {
            //if request method is not PATCH always true
            //if request method is PATCH check if field exiest in validated data before mapping
            if (! $this->isMethod('PATCH') || Arr::has($validatedData, $sourcePath)) {
                starMapping($validatedData, $sourcePath, $formattedData, $destinationPath);
            }
        }

        return $formattedData;
    }
}

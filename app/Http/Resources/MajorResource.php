<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MajorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'major',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'years' => $this->years,
            ],
            'relationships' => [
                'college' => [
                    'data' => [
                        'type' => 'college',
                        'id' => $this->college_id,
                    ]
                ],
                'degree' => [
                    'data' => [
                        'type' => 'degree',
                        'id' => $this->degree_id,
                    ]
                ]
            ]
        ];
    }
}

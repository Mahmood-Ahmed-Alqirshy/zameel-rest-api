<?php

dataset('updateColleges', function () {
    return [
        [
            [
                'model' => ['name' => 'ABC'],
                'request' => [
                    'data' => [
                        'type' => 'college',
                        'attributes' => [
                            'name' => 'Springfield College',
                        ],
                    ],
                ],
                'target' => 'data.attributes.name',
            ],
        ],
    ];
});

<?php

dataset('invalidColleges', function () {
    return [
        [
            [
                'data' => [
                    'type' => 'college',
                    'attributes' => [
                        'name' => '123 Springfield College!!!!',
                    ],
                ],
            ],
        ],
        [
            [
                'data' => [
                    'type' => 'college',
                    'attributes' => [
                        'name' => 'Springfield College with a Name that is Far Too Long for the Field',
                    ],
                ],
            ],
        ],
    ];
});

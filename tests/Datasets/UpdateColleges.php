<?php

dataset('updateColleges', function () {
    return [
        [
            [
                'model' => ['name' => 'ABC'],
                'request' => [
                    'name' => 'Springfield College',
                ],
                'target' => 'name',
            ],
        ],
    ];
});

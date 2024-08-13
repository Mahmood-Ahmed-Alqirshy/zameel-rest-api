<?php

dataset('incompleteCredentials', function () {
    return [
        [[
            'data' => [
                'attributes' => [
                    'email' => 'Mahmoud@gmail.com',
                ],
            ],
            'meta' => [
                'deviceName' => 'IPhone 13',
            ],
        ]],
        [[
            'data' => [
                'attributes' => [
                    'password' => 'password',
                ],
            ],
            'meta' => [
                'deviceName' => 'IPhone 13',
            ],
        ]],
        [[
            'data' => [
                'attributes' => [
                    'email' => 'Mahmoud@gmail.com',
                    'password' => 'password',
                ],
            ],
            'meta' => [],
        ]],
        [[
            'data' => [
                'attributes' => [],
            ],
            'meta' => [],
        ]],
    ];
});

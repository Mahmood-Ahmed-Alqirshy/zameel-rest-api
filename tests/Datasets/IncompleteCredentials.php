<?php

dataset('incompleteCredentials', function () {
    return [
        [[
            'data' => [
                'atttibutes' => [
                    'email' => 'Mahmoud@gmail.com',
                ],
            ],
            'meta' => [
                'deviceName' => 'IPhone 13',
            ],
        ]],
        [[
            'data' => [
                'atttibutes' => [
                    'password' => 'password',
                ],
            ],
            'meta' => [
                'deviceName' => 'IPhone 13',
            ],
        ]],
        [[
            'data' => [
                'atttibutes' => [
                    'email' => 'Mahmoud@gmail.com',
                    'password' => 'password',
                ],
            ],
            'meta' => [
            ],
        ]],
        [[
            'data' => [
                'atttibutes' => [
                ],
            ],
            'meta' => [
            ],
        ]],
    ];
});

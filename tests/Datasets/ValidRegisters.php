<?php

dataset('vaildRegisters', function () {
    return [
        [[
            'data' => [
                'type' => 'user',
                'attributes' => [
                    'name' => 'أحمد',
                    'email' => 'Ahmed@email.com',
                    'password' => '12(Mn)Up',
                    'password_confirmation' => '12(Mn)Up',
                ],
            ],
        ]],
        [[
            'data' => [
                'type' => 'user',
                'attributes' => [
                    'name' => 'أحمد',
                    'email' => 'Ahmed@email.com',
                    'password' => '12(Mn)34',
                    'password_confirmation' => '12(Mn)34',
                ],
            ],
        ]],
    ];
});

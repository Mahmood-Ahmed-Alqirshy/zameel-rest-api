<?php

dataset('vaildRegisters', function () {
    return [
        [[
            'data' => [
                'type' => 'major',
                'atttibutes' => [
                    'name' => 'أحمد',
                    'email' => 'Ahmed@email.com',
                    'password' => '12(Mn)Up',
                    'password_confirmation' => '12(Mn)Up',
                ],
            ],
        ]],
        [[
            'data' => [
                'type' => 'major',
                'atttibutes' => [
                    'name' => 'أحمد',
                    'email' => 'Ahmed@email.com',
                    'password' => '12(Mn)34',
                    'password_confirmation' => '12(Mn)34',
                ],
            ],
        ]],
    ];
});

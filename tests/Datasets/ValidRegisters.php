<?php

dataset('vaildRegisters', function () {
    return [
        [[
            "data" => [
                "type" => "major",
                "atttibutes" => [
                    "name" => "أحمد",
                    "email" => "Ahmed@email.com",
                    "password" => "12(Mn)Up",
                    "password_confirmation" => "12(Mn)Up",
                ],
                "relationships" => [
                    "class" => [
                        "data" => [
                            "type" => "class",
                            "id" => 1
                        ]
                    ],
                    "role" => [
                        "data" => [
                            "type" => "role",
                            "id" => "1"
                        ]
                    ]
                ]
            ]
        ]],
        [[
            "data" => [
                "type" => "major",
                "atttibutes" => [
                    "name" => "أحمد",
                    "email" => "Ahmed@email.com",
                    "password" => "12(Mn)34",
                    "password_confirmation" => "12(Mn)34"
                ],
                "relationships" => [
                    "role" => [
                        "data" => [
                            "type" => "role",
                            "id" => "1"
                        ]
                    ]
                ]
            ]
        ]],
    ];
});

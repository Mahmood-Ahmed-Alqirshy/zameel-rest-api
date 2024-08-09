<?php

dataset('invalidRegisters', function () {
    return [
        // [[
        //     "data" => [
        //         "type" => "major",
        //         "atttibutes" => [
        //             "name" => "أحمد",
        //             "email" => "Ahmed@email.com",
        //             "password" => "12(Mn)Up",
        //             "password_confirmation" => "12(Mn)Up",
        //         ],
        //         "relationships" => [
        //             "groups" => [
        //                 "data" => [
        //                     "type" => "group",
        //                     "id" => 1
        //                 ],
        //             "role" => [
        //                 "data" => [
        //                     "type" => "role",
        //                     "id" => 1
        //                 ]
        //             ]
        //         ],
                
        //         ]
        //     ]
        // ]],
        [[
            "data" => [
                "type" => "major",
                "atttibutes" => [
                    "name" => "كلام طووووووووووووووووووووووووووووووووووووييييييييييييييييييييييييل اكثر من 45 حرف",
                    "email" => "Ahmed@email.com",
                    "password" => "12(Mn)34"
                ],
                "relationships" => [
                    "role" => [
                        "data" => [
                            "type" => "role",
                            "id" => 1
                        ]
                    ]
                ]
            ]
        ]],
        [[
            "data" => [
                "type" => "major",
                "atttibutes" => [
                    "name" => 'احمد',
                    "email" => "Ahmedemail.com",
                    "password" => "12(Mn)34",
                    "password_confirmation" => "12(Mn)34"
                ],
                "role" => [
                    "data" => [
                        "type" => "role",
                        "id" => 1
                    ]
                ]
            ]
        ]],
        // [[
        //     "data" => [
        //         "type" => "major",
        //         "atttibutes" => [
        //             "name" => "أحمد",
        //             "email" => "Ahmed@email.com",
        //             "password" => "1234",
        //             "password_confirmation" => "1234"
        //         ],
        //         "relationships" => [
        //             "role" => [
        //                 "data" => [
        //                     "type" => "role",
        //                     "id" => "1"
        //                 ]
        //             ]
        //         ]
        //     ]
        // ]],

    ];
});

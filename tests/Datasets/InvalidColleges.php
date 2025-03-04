<?php

dataset('invalidColleges', function () {
    return [
        [
            [
                'name' => '123 Springfield College!!!!',
            ],
        ],
        [
            [
                'name' => 'Springfield College with a Name that is Far Too Long for the Field',
            ],
        ],
    ];
});

<?php

it('it can map with paths contain single star', function () {

    $json = <<< 'text'
    {
  "data": {
    "type": "major",
    "atttibutes": {
        "name": "a",
        "email": "email@example.com",
      "password": "1234"
    },
    "relationships": {
      "class": {
        "data": [
            {
            "type": "class",
            "id": 1
            },
            {
            "type": "class",
            "id": 4
            },
            {
            "type": "class",
            "id": 5
            },
            {
            "type": "class",
            "id": 7
            }
        ]
      },
      "role": {
        "data": {
          "type": "role",
          "id": 6
        }
      }
    }
  }
}
text;

    $source = json_decode($json, true);
    $map = [
        'data.atttibutes.name' => 'model.name',
        'data.atttibutes.email' => 'model.email',
        'data.atttibutes.password' => 'model.password',
        'data.relationships.class.data.*.id' => 'relationships.class.*',
        'data.relationships.role.data.id' => 'model.role_id',
    ];

    $result = [];

    foreach ($map as $path => $field) {
        starMapping($source, $path, $result, $field);
    }

    $match = [
        'model' => [
            'name' => 'a',
            'email' => 'email@example.com',
            'password' => '1234',
            'role_id' => 6,
        ],
        'relationships' => [
            'class' => [1, 4, 5, 7],
        ],
    ];

    expect(count($result))->toEqual(count($match));
    expect($result)->toMatchArray($match);
});

it('it can map with paths contain multiple star', function () {

    $json = <<< 'text'
{
    "data": {
        "type": "major",
        "atttibutes": {
            "name": "a",
            "email": "email@example.com",
            "password": "1234"
        },
        "relationships": {
            "class": {
                "data": [
                    {
                        "type": "class",
                        "id": 1,
                        "relationships": {
                            "students": {
                                "data": [
                                    {
                                        "type": "stu",
                                        "id": 98,
                                        "relationships": {
                                            "posts": {
                                                "data": [
                                                    { "type": "stu", "id": 45 },
                                                    { "type": "stu", "id": 32 },
                                                    { "type": "stu", "id": 12 }
                                                ]
                                            }
                                        }
                                    }
                                ]
                            }
                        }
                    },
                    {
                        "type": "class",
                        "id": 1,
                        "relationships": {
                            "students": {
                                "data": [
                                    {
                                        "type": "stu",
                                        "id": 98,
                                        "relationships": {
                                            "posts": {
                                                "data": [
                                                    { "type": "stu", "id": 45 },
                                                    { "type": "stu", "id": 32 },
                                                    { "type": "stu", "id": 12 }
                                                ]
                                            }
                                        }
                                    }
                                ]
                            }
                        }
                    },
                    {
                        "type": "class",
                        "id": 1,
                        "relationships": {
                            "students": {
                                "data": [
                                    {
                                        "type": "stu",
                                        "id": 98,
                                        "relationships": {
                                            "posts": {
                                                "data": [
                                                    { "type": "stu", "id": 45 },
                                                    { "type": "stu", "id": 32 },
                                                    { "type": "stu", "id": 12 }
                                                ]
                                            }
                                        }
                                    }
                                ]
                            }
                        }
                    }
                ]
            },
            "role": {
                "data": {
                    "type": "role",
                    "id": 6
                }
            }
        }

    }
}
text;

    $source = json_decode($json, true);

    $map = [
        'data.atttibutes.name' => 'model.name',
        'data.atttibutes.email' => 'model.email',
        'data.atttibutes.password' => 'model.password',
        'data.relationships.class.data.*.id' => 'relationships.class.*.id',
        'data.relationships.class.data.*.relationships.students.data.*.id' => 'relationships.class.*.students.*.id',
        'data.relationships.class.data.*.relationships.students.data.*.relationships.posts.data.*.id' => 'relationships.class.*.students.*.posts.*',
        'data.relationships.role.data.id' => 'model.role_id',
    ];

    $result = [];

    foreach ($map as $path => $field) {
        starMapping($source, $path, $result, $field);
    }

    $match = [
        'model' => [
            'name' => 'a',
            'email' => 'email@example.com',
            'password' => '1234',
            'role_id' => 6,
        ],
        'relationships' => [
            'class' => [
                [
                    'id' => 1,
                    'students' => [
                        [
                            'id' => 98,
                            'posts' => [45, 32, 12],
                        ],
                    ],
                ],
                [
                    'id' => 1,
                    'students' => [
                        [
                            'id' => 98,
                            'posts' => [45, 32, 12],
                        ],
                    ],
                ],
                [
                    'id' => 1,
                    'students' => [
                        [
                            'id' => 98,
                            'posts' => [45, 32, 12],
                        ],
                    ],
                ],

            ],
        ],
    ];

    expect(count($result))->toEqual(count($match));
    expect($result)->toMatchArray($match);
});

it('throw exception when unequal number of stars', function () {
    $d = [];
    starMapping([], 'data.relationships.class.data.*.relationships.students.data.*.relationships.posts.data.*.id', $d, 'relationships.class.*.students.posts.*');
})->throws(Exception::class, 'unequal number of stars in $sourcePath and $destinationPath');

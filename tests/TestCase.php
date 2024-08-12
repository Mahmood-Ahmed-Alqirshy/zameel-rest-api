<?php

namespace Tests;

use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use function Pest\Laravel\postJson;

abstract class TestCase extends BaseTestCase
{
    protected $seeder = TestSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();
        $this->makeToken();
    }

    public function makeToken()
    {
        $response = postJson('/api/login', $this->adminCredentials);
        $this->adminToken = $response->json()['token'];

        $response = postJson('/api/login', $this->managerCredentials);
        $this->managerToken = $response->json()['token'];

        $response = postJson('/api/login', $this->academicCredentials);
        $this->academicToken = $response->json()['token'];

        $response = postJson('/api/login', $this->representerCredentials);
        $this->representerToken = $response->json()['token'];

        $response = postJson('/api/login', $this->studentCredentials);
        $this->studentToken = $response->json()['token'];
    }

    public $adminToken = '';

    public $managerToken = '';

    public $academicToken = '';

    public $representerToken = '';

    public $studentToken = '';

    public $adminCredentials = [
        'data' => [
            'attributes' => [
                'email' => 'admin@example.com',
                'password' => 'password',
            ],
        ],
        'meta' => [
            'deviceName' => 'IPhone 13',
        ],
    ];

    public $managerCredentials = [
        'data' => [
            'attributes' => [
                'email' => 'manager@example.com',
                'password' => 'password',
            ],
        ],
        'meta' => [
            'deviceName' => 'IPhone 13',
        ],
    ];

    public $academicCredentials = [
        'data' => [
            'attributes' => [
                'email' => 'academic@example.com',
                'password' => 'password',
            ],
        ],
        'meta' => [
            'deviceName' => 'IPhone 13',
        ],
    ];

    public $representerCredentials = [
        'data' => [
            'attributes' => [
                'email' => 'representer@example.com',
                'password' => 'password',
            ],
        ],
        'meta' => [
            'deviceName' => 'IPhone 13',
        ],
    ];

    public $studentCredentials = [
        'data' => [
            'attributes' => [
                'email' => 'student@example.com',
                'password' => 'password',
            ],
        ],
        'meta' => [
            'deviceName' => 'IPhone 13',
        ],
    ];
}

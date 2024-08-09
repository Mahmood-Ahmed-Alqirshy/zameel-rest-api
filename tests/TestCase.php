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
        $response = postJson('/api/login', $this->credentials, ['Accept' => 'application/json']);
        $this->token = $response->json()['token'];
    }

    public $token = '';

    public $credentials = [
        'data' => [
            'atttibutes' => [
                'email' => 'Mahmoud@gmail.com',
                'password' => 'password',
            ],
        ],
        'meta' => [
            'deviceName' => 'IPhone 13',
        ],
    ];
}

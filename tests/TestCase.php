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
        self::$adminToken = $response->json()['data']['token'];

        $response = postJson('/api/login', $this->managerCredentials);
        self::$managerToken = $response->json()['data']['token'];

        $response = postJson('/api/login', $this->academicCredentials);
        self::$academicToken = $response->json()['data']['token'];

        $response = postJson('/api/login', $this->representerCredentials);
        self::$representerToken = $response->json()['data']['token'];

        $response = postJson('/api/login', $this->studentCredentials);
        self::$studentToken = $response->json()['data']['token'];
    }

    public static $adminToken = '';

    public static $managerToken = '';

    public static $academicToken = '';

    public static $representerToken = '';

    public static $studentToken = '';

    public $adminCredentials = [

        'email' => 'admin@example.com',
        'password' => 'password',

        'deviceName' => 'IPhone 13',
    ];

    public $managerCredentials = [

        'email' => 'manager@example.com',
        'password' => 'password',

        'deviceName' => 'IPhone 13',
    ];

    public $academicCredentials = [

        'email' => 'academic@example.com',
        'password' => 'password',

        'deviceName' => 'IPhone 13',
    ];

    public $representerCredentials = [

        'email' => 'representer@example.com',
        'password' => 'password',

        'deviceName' => 'IPhone 13',
    ];

    public $studentCredentials = [

        'email' => 'student@example.com',
        'password' => 'password',

        'deviceName' => 'IPhone 13',
    ];
}

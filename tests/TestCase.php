<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->makeToken();
    }

    public function makeToken()
    {
        $response = $this->postJson('/api/login', $this->credentials, ['Accept' => 'application/json']);
        $this->token = $response->json()['token'];
    }

    public $token = '';

    public $credentials = ['email' => 'Mahmoud@gmail.com', 'password' => 'password', 'deviceName' => 'IPhone 13'];
}

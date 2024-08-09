<?php

use App\Models\Group;

use function Pest\Laravel\postJson;

it('can login', function () {
    postJson('/api/login', $this->credentials)
        ->assertOK()
        ->assertJsonStructure(['token']);
});

it('rejects wrong credentials', function ($email, $password) {
    $invalidCredentials = [
        'data' => [
            'atttibutes' => [
                'email' => $email,
                'password' => $password,
            ]
        ],
        'meta' => [
            'deviceName' => 'IPhone 13'
        ]
    ];

    postJson('/api/login', $invalidCredentials)
        ->assertUnauthorized();

})->with([
    ['Ahmed@gmail.com', 'password'],
    ['Mahmoud@gmail.com', '1234'],
    ['Ahmed@gmail.com', '1234'],
]);

it('rejects incomplete credentials', function ($credentials) {
    postJson('/api/login', $credentials)
    ->assertUnprocessable();
    
})->with('incompleteCredentials');

it('can logout', function () {
    postJson('/api/logout', [], ['Authorization' => "Bearer $this->token"])
        ->assertOK();
});

it("can't logout without token", function () {
    postJson('/api/logout')
        ->assertUnauthorized();
});

it("can register user with valid data", function ($data) {
    postJson('/api/register', $data)
        ->assertOK();
})->with('vaildRegisters');

it("can't register user with invalid data", function ($data) {
    postJson('/api/register', $data)
        ->assertUnprocessable();
})->with('invalidRegisters');


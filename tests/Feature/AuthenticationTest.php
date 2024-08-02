<?php

use function Pest\Laravel\postJson;

it('can login', function () {
    postJson('/api/login', $this->credentials)
        ->assertOK()
        ->assertJsonStructure(['token']);
});

it('rejects wrong credentials', function ($email, $password) {
    $invalidCredentials = ['email' => $email, 'password' => $password, 'deviceName' => 'IPhone 13'];

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

})->with([
    [['email' => 'Mahmoud@gmail.com', 'deviceName' => 'IPhone 13']],
    [['password' => 'password', 'deviceName' => 'IPhone 13']],
    [['email' => 'Mahmoud@gmail.com', 'password' => 'password']],
    [[]],
]);

it('can logout', function () {
    postJson('/api/logout', [], ['Authorization' => "Bearer $this->token"])
        ->assertOK();
});

it("can't logout without token", function () {
    postJson('/api/logout')
        ->assertUnauthorized();
});

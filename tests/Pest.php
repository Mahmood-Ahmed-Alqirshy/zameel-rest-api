<?php

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patch;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Dotenv\Parser\Value;
use Illuminate\Support\Arr;
use Tests\TestCase;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature', 'Endpoint');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

expect()->extend('toBeProtectedAgainstUnauthenticated', function (array $except = []) {
    if (!in_array('index', $except))
        getJson($this->value)
            ->assertUnauthorized();

    if (!in_array('show', $except))
        getJson($this->value . '/1')
            ->assertUnauthorized();

    if (!in_array('destroy', $except))
        deleteJson($this->value . '/1')
            ->assertUnauthorized();

    if (!in_array('store', $except))
        postJson($this->value)
            ->assertUnauthorized();

    if (!in_array('update', $except))
        patchJson($this->value . '/1')
            ->assertUnauthorized();
});

expect()->extend('toBeProtectedAgainstRoles', function (array $roles = [], array $except = []) {
    $nonAdminTokens = array_map(fn($e) => $e . "Token", $roles);

    foreach ($nonAdminTokens as $tokenName) {
        if (!in_array('index', $except))
            getJson($this->value, ['Authorization' => 'Bearer ' . TestCase::$$tokenName])
                ->assertForbidden();

        if (!in_array('show', $except))
            getJson($this->value . '/1', ['Authorization' => 'Bearer ' . TestCase::$$tokenName])
                ->assertForbidden();

        if (!in_array('store', $except))
            postJson($this->value, [], ['Authorization' => 'Bearer ' . TestCase::$$tokenName])
                ->assertForbidden();

        if (!in_array('update', $except))
            patchJson($this->value . '/1', [], ['Authorization' => 'Bearer ' . TestCase::$$tokenName])
                ->assertForbidden();

        if (!in_array('destroy', $except))
            deleteJson($this->value . '/1', [], ['Authorization' => 'Bearer ' . TestCase::$$tokenName])
                ->assertForbidden();
    }
});

expect()->extend('indexToHaveExactJsonStructure', function (string $model, array $structure) {
    getJson($this->value, ['Authorization' => "Bearer " . TestCase::$adminToken])
        ->assertOK()
        ->assertJsonCount($model::count(), 'data')
        ->assertExactJsonStructure($structure);
});

expect()->extend('showToHaveExactJsonStructure', function (array $structure) {
    getJson($this->value . '/1', ['Authorization' => "Bearer " . TestCase::$adminToken])
        ->assertOK()
        ->assertExactJsonStructure($structure);
});

expect()->extend('toDelete', function (string $model, $query = null) {
    $resource = $query ?? $model::first();
    deleteJson($this->value . "/{$resource->id}", [], ['Authorization' => "Bearer " . TestCase::$adminToken])
        ->assertOK();

    expect($model::find($resource->id))->toBeNull();
});

expect()->extend('toStore', function ($data) {
    $response = postJson($this->value, $data, ['Authorization' => "Bearer " . TestCase::$adminToken])
        ->assertCreated();

    $createdResource = $response->json();
    $createdResourceID = Arr::get($createdResource, 'data.id');

    getJson($this->value . "/$createdResourceID", ['Authorization' => "Bearer " . TestCase::$adminToken])
        ->assertExactJson($createdResource);
});

expect()->extend('toUpdate', function (string $class, $data) {
    $resource = $class::create($data['model']);
    $response = patchJson($this->value . "/$resource->id", $data['request'], ['Authorization' => "Bearer " . TestCase::$adminToken])
        ->assertOK();

    $updatedResource = $response->json();

    $updatedResourceID = Arr::get($updatedResource, 'data.id');

    expect(Arr::get($updatedResource, $data['target']))->toEqual(Arr::get($data['request'], $data['target']));

    getJson($this->value . "/$updatedResourceID", ['Authorization' => "Bearer " . TestCase::$adminToken])
        ->assertExactJson($updatedResource);
});

expect()->extend('toNotOperateOnUnexistingResources', function (array $except = []) {
    if (!in_array('show', $except))
        getJson($this->value . '/1000000000', ['Authorization' => "Bearer " . TestCase::$adminToken])
            ->assertNotFound();
    if (!in_array('update', $except))
        patchJson($this->value . '/1000000000', [], ['Authorization' => "Bearer " . TestCase::$adminToken])
            ->assertNotFound();
    if (!in_array('destroy', $except))
        deleteJson($this->value . '/1000000000', [], ['Authorization' => "Bearer " . TestCase::$adminToken])
            ->assertNotFound();
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

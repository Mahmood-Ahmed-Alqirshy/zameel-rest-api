<?php

use App\Models\College;
use App\Models\Major;
use Illuminate\Support\Arr;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;

it('can retrieve all colleges', function () {
    getJson('/api/colleges', ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertJsonCount(College::count(), 'data')
        ->assertExactJsonStructure(
            [
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'atttibutes' => [
                            'name',
                        ],
                    ],
                ],
            ]
        );
});

it('can retrieve single college', function () {
    getJson('/api/colleges/1', ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertExactJsonStructure(
            [
                'data' => [
                    'type',
                    'id',
                    'atttibutes' => [
                        'name',
                    ],
                ],
            ]
        );
});

it('can delete college', function () {
    deleteJson('/api/colleges/1', [], ['Authorization' => "Bearer $this->token"])
        ->assertOK();

    expect(College::find(1))->toBeNull();
});

it("can't delete college that have majors", function () {
    $college = College::find(1);
    $majorsIDs = Major::factory()->create(['college_id' => $college->id])->pluck('id')->toArray();
    $college->majors()->sync($majorsIDs);

    deleteJson('/api/colleges/1', [], ['Authorization' => "Bearer $this->token"])
        ->assertUnprocessable();
});

it('can store college', function ($data) {
    $response = postJson('/api/colleges', $data, ['Authorization' => "Bearer $this->token"])
        ->assertCreated();

    $createdResource = $response->json();
    $createdResourceID = Arr::get($createdResource, 'data.id');

    getJson("/api/colleges/$createdResourceID", ['Authorization' => "Bearer $this->token"])
        ->assertExactJson($createdResource);
})->with('validColleges');

it('can update college', function ($request) {
    $college = College::create(['name' => 'ABC']);

    $response = patchJson("/api/colleges/$college->id", $request, ['Authorization' => "Bearer $this->token"])
        ->assertOK();

    $updatedResource = $response->json();

    $updatedResourceID = Arr::get($updatedResource, 'data.id');

    expect(Arr::get($updatedResource, 'data.attributes.name'))->toEquel('Springfield College');

    getJson("/api/colleges/$updatedResourceID", ['Authorization' => "Bearer $this->token"])
        ->assertExactJson($updatedResource);

})->with([
    [[
        'data' => [
            'type' => 'college',
            'attributes' => [
                'name' => 'Springfield College',
            ],
        ],
    ]],
]);

it("can't store invalid college", function ($data) {
    postJson('/api/colleges', $data, ['Authorization' => "Bearer $this->token"])
        ->assertUnprocessable();
})->with('invalidColleges');

it("can't delete unexisting college", function () {
    deleteJson('/api/colleges/6579839', [], ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it("can't update unexisting college", function () {
    patchJson('/api/colleges/6579839', [], ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it("can't retrieve unexisting college", function () {
    getJson('/api/colleges/999999', ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it('protect Contact endpoints', function () {
    getJson('/api/colleges')
        ->assertUnauthorized();

    getJson('/api/colleges/1')
        ->assertUnauthorized();

    deleteJson('/api/colleges/1')
        ->assertUnauthorized();

    postJson('/api/colleges')
        ->assertUnauthorized();

    patchJson('/api/colleges/1')
        ->assertUnauthorized();
});

it('prevents non-admin roles from performing CRUD operations on colleges', function () {
    $newCollege = ['data' => ['attributes' => ['name' => 'New College']]];
    $updateData = ['data' => ['attributes' => ['name' => 'Updated College']]];

    $nonAdminTokens = [
        'managerToken', 'academicToken', 'representerToken', 'studentToken',
    ];

    foreach ($nonAdminTokens as $tokenName) {
        getJson('/api/colleges', ['Authorization' => "Bearer $this->$tokenName"])
            ->assertForbidden();

        postJson('/api/colleges', $newCollege, ['Authorization' => "Bearer $this->$tokenName"])
            ->assertForbidden();

        patchJson('/api/colleges/1', $updateData, ['Authorization' => "Bearer $this->$tokenName"])
            ->assertForbidden();

        deleteJson('/api/colleges/1', [], ['Authorization' => "Bearer $this->$tokenName"])
            ->assertForbidden();
    }
});

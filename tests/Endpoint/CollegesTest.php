<?php

use App\Models\College;
use App\Models\Major;
use Illuminate\Support\Str;

use function Pest\Laravel\deleteJson;

$pluralName = 'colleges';
$singularName = Str::singular($pluralName);
beforeEach(function () {
    $this->pluralName = 'colleges';
    $this->singularName = Str::singular($this->pluralName);
    $this->endpoint = '/api/colleges';
    $this->except = [];
    $this->authorizedActionsForAll = [...$this->except, 'show', 'index'];
    $this->unauthorizedRoles = ['manager', 'academic', 'representer', 'student'];
    $this->model = College::class;
    $this->authenticateAllExcept = [];
    $this->softDelete = true;
    $this->forceDeleteCheck = true;
    $this->parent = null;
    $this->relationship = null;
    $this->authorize = [
        'index' => [
            'allow' => ['*'],
        ],
        'search' => [
            'allow' => ['*'],

        ],
        'show' => [
            'allow' => ['*'],

        ],
        'destroy' => [
            'allow' => ['admin'],

        ],
        'store' => [
            'allow' => ['admin'],

        ],
        'update' => [
            'allow' => ['admin'],

        ],
        'restore' => [
            'allow' => ['admin'],

        ],
        'force' => [
            'allow' => ['admin'],

        ],
    ];
    $this->validSample = function () {
        return [
            'name' => fake()->unique()->word(),
        ];
    };
    $this->invalidSample = [
        'name' => 'a College 123',
    ];
    $this->indexStructure = [
        'data' => [
            '*' => [
                'id',
                'name',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
        ],
    ];
    $this->showStructure = [
        'data' => [
            'id',
            'name',
            'created_at',
            'updated_at',
            'deleted_at',
        ],
    ];
});

it("protect $pluralName endpoints", function () {
    expect($this->endpoint)->toBeProtectedAgainstUnauthenticated($this);
});

it("controls access for admin in CRUD operations on $pluralName", function () {
    expect($this->endpoint)->toBeProtectedAgainstRoles($this, 'admin');
})->only();

it("controls access for manager in CRUD operations on $pluralName", function () {
    expect($this->endpoint)->toBeProtectedAgainstRoles($this, 'manager');
})->only();

it("controls access for academic in CRUD operations on $pluralName", function () {
    expect($this->endpoint)->toBeProtectedAgainstRoles($this, 'academic');
})->only();

it("controls access for representer in CRUD operations on $pluralName", function () {
    expect($this->endpoint)->toBeProtectedAgainstRoles($this, 'representer');
})->only();

it("controls access for student in CRUD operations on $pluralName", function () {
    expect($this->endpoint)->toBeProtectedAgainstRoles($this, 'student');
})->only();

it("can retrieve all $pluralName", function () {
    expect($this->endpoint)->indexToHaveExactJsonStructure($this);
});

it("can retrieve single $singularName", function () {
    expect($this->endpoint)->showToHaveExactJsonStructure($this);
});

it("can delete $singularName", function () {
    $model = $this->model::create($this->validSample);
    expect($this->endpoint.'/'.$model->id)->toDelete($this);
});

it("can store $singularName", function () {
    expect($this->endpoint)->toStore($this);
});

it("can update $singularName", function () {
    expect($this->endpoint.'/1')->toUpdate($this);
});

it("can't force delete college that have majors", function () {
    $college = College::find(1);
    Major::factory()->create(['college_id' => $college->id]);

    deleteJson('/api/colleges/1?force=true', [], ['Authorization' => 'Bearer '.$this::$adminToken])
        ->assertUnprocessable();

    $major = $college->majors()->first();
    deleteJson('/api/majors/'.$major->id.'/college?force=true', [], ['Authorization' => 'Bearer '.$this::$adminToken])
        ->assertUnprocessable();
});

it('can soft delete college that have majors', function () {
    $college = College::find(2);
    Major::factory()->create(['college_id' => $college->id]);

    deleteJson('/api/colleges/1', [], ['Authorization' => 'Bearer '.$this::$adminToken])
        ->assertOK();

    $major = $college->majors()->first();
    deleteJson('/api/majors/'.$major->id.'/college', [], ['Authorization' => 'Bearer '.$this::$adminToken])
        ->assertOK();
});

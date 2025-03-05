<?php

use App\Models\College;
use App\Models\Major;
use Illuminate\Support\Str;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;

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
    $this->validSample = [
        'name' => 'a College',
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

it("can retrieve all $pluralName", function () {
    if (! in_array('index', $this->except)) {
        expect($this->endpoint)->indexToHaveExactJsonStructure(
            $this->model,
            $this->indexStructure
        );
    }
});

it("can retrieve single $singularName", function () {
    if (! in_array('show', $this->except)) {
        expect($this->endpoint)->showToHaveExactJsonStructure(
            $this->showStructure
        );
    }
});

it("can delete $singularName", function () {
    if (! in_array('destroy', $this->except)) {
        expect($this->endpoint)->toDelete($this->model, College::query()->doesntHave('majors')->first());
    }
});

it("can store $singularName", function ($data) {
    if (! in_array('store', $this->except)) {
        expect($this->endpoint)->toStore($data);
    }
})->with(Str::camel("valid $pluralName"));

it("can update $singularName", function ($data) {
    if (! in_array('update', $this->except)) {
        expect($this->endpoint)->toUpdate($this->model, $data);
    }
})->with(Str::camel("update $pluralName"));

it("can't store invalid $singularName", function ($data) {
    if (! in_array('store', $this->except)) {
        postJson($this->endpoint, $data, ['Authorization' => 'Bearer '.$this::$adminToken])
            ->assertUnprocessable();
    }
})->with(Str::camel("invalid $pluralName"));

it("can't operate on unexisting $singularName", function () {
    expect($this->endpoint)->toNotOperateOnUnexistingResources($this->validSample, $this->except);
});

it("protect $pluralName endpoints", function () {
    expect($this->endpoint)->toBeProtectedAgainstUnauthenticated($this->except);
});

it("prevents some roles from performing CRUD operations on $pluralName", function () {
    expect($this->endpoint)->toBeProtectedAgainstRoles($this->validSample, $this->unauthorizedRoles, $this->authorizedActionsForAll);
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

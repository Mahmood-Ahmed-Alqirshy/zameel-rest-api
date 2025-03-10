<?php

use Tests\TestCase;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
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

use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

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

expect()->extend('toBeProtectedAgainstUnauthenticated', function ($testCase) {
    if (! in_array('index', $testCase->authenticateAllExcept)) {
        getJson($this->value)
            ->assertUnauthorized();
    }

    if (! in_array('search', $testCase->authenticateAllExcept)) {
        patchJson($this->value.'/search')
            ->assertUnauthorized();
    }

    if (! in_array('show', $testCase->authenticateAllExcept)) {
        getJson($this->value.'/1')
            ->assertUnauthorized();
    }

    if (! in_array('destroy', $testCase->authenticateAllExcept)) {
        deleteJson($this->value.'/1')
            ->assertUnauthorized();
    }

    if (! in_array('store', $testCase->authenticateAllExcept)) {
        postJson($this->value)
            ->assertUnauthorized();
    }

    if (! in_array('update', $testCase->authenticateAllExcept)) {
        patchJson($this->value.'/1')
            ->assertUnauthorized();
    }

    if ($testCase->softDelete) {
        if (! in_array('restore', $testCase->authenticateAllExcept)) {
            postJson($this->value.'/1/restore')
                ->assertUnauthorized();
        }

        if (! in_array('force', $testCase->authenticateAllExcept)) {
            deleteJson($this->value.'/1?force=true')
                ->assertUnauthorized();
        }
    }

    if ($testCase->relationship === 'OneToMany') {
        if (! in_array('associate', $testCase->authenticateAllExcept)) {
            postJson($this->value.'/associate')
                ->assertUnauthorized();
        }

        if (! in_array('dissociate', $testCase->authenticateAllExcept)) {
            deleteJson($this->value.'/1/dissociate')
                ->assertUnauthorized();
        }
    }

    if ($testCase->relationship === 'ManyToMany') {
        if (! in_array('attach', $testCase->authenticateAllExcept)) {
            postJson($this->value.'/attach')
                ->assertUnauthorized();
        }

        if (! in_array('detach', $testCase->authenticateAllExcept)) {
            deleteJson($this->value.'/detach')
                ->assertUnauthorized();
        }

        if (! in_array('sync', $testCase->authenticateAllExcept)) {
            patchJson($this->value.'/sync')
                ->assertUnauthorized();
        }

        if (! in_array('toggle', $testCase->authenticateAllExcept)) {
            patchJson($this->value.'/toggle')
                ->assertUnauthorized();
        }

        if (! in_array('pivot', $testCase->authenticateAllExcept)) {
            patchJson($this->value.'/1/pivot')
                ->assertUnauthorized();
        }
    }
});

expect()->extend('toBeProtectedAgainstRoles', function ($testCase, $role) {
    $tokenName = $role.'Token';
    $isActionRoleAuthorize = function ($action) use ($role, $testCase) {
        return ! empty(array_intersect(['*', $role], $testCase->authorize[$action]['allow']));
    };

    $isAuthorize = $isActionRoleAuthorize('index');
    $request = getJson($this->value, ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
    if ($isAuthorize) {
        $request->assertOk();
    } else {
        $request->assertForbidden();
    }

    $isAuthorize = $isActionRoleAuthorize('search');
    $request = getJson($this->value, ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
    if ($isAuthorize) {
        $request->assertOk();
    } else {
        $request->assertForbidden();
    }

    $isAuthorize = $isActionRoleAuthorize('show');
    $request = getJson($this->value.'/1', ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
    if ($isAuthorize) {
        $request->assertOk();
    } else {
        $request->assertForbidden();
    }

    $isAuthorize = $isActionRoleAuthorize('destroy');
    $model = $testCase->model::create(call_user_func($testCase->validSample));
    $request = deleteJson($this->value.'/'.$model->id, [], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
    if ($isAuthorize) {
        $request->assertOk();
    } else {
        $request->assertForbidden();
    }

    $isAuthorize = $isActionRoleAuthorize('store');
    $request = postJson($this->value, call_user_func($testCase->validSample), ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
    if ($isAuthorize) {
        $request->assertCreated();
    } else {
        $request->assertForbidden();
    }

    $isAuthorize = $isActionRoleAuthorize('update');
    $request = putJson($this->value.'/1', call_user_func($testCase->validSample), ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
    if ($isAuthorize) {
        $request->assertOk();
    } else {
        $request->assertForbidden();
    }

    if ($testCase->softDelete) {
        $isAuthorize = $isActionRoleAuthorize('restore');
        $request = postJson($this->value.'/'.$model->id.'/restore', [], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
        if ($isAuthorize) {
            $request->assertOk();
        } else {
            $request->assertForbidden();
        }

        if ($testCase->forceDeleteCheck) {
            $isAuthorize = $isActionRoleAuthorize('force');
            $request = deleteJson($this->value.'/'.$model->id.'?force=1', [], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
            if ($isAuthorize) {
                $request->assertOk();
            } else {
                $request->assertForbidden();
            }
        }
    }

    if ($testCase->relationship === 'OneToMany') {
        $isAuthorize = $isActionRoleAuthorize('associate');
        $request = postJson($this->value.'/associate', ['related_key' => 1], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
        if ($isAuthorize) {
            $request->assertOk();
        } else {
            $request->assertForbidden();
        }

        $isAuthorize = $isActionRoleAuthorize('dissociate');
        $request = deleteJson($this->value.'/1/dissociate', [], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
        if ($isAuthorize) {
            $request->assertOk();
        } else {
            $request->assertForbidden();
        }
    }

    if ($testCase->relationship === 'ManyToMany') {
        $isAuthorize = $isActionRoleAuthorize('associate');
        $request = postJson($this->value.'/attach', [[1 => call_user_func($testCase->validSample)]], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
        if ($isAuthorize) {
            $request->assertOk();
        } else {
            $request->assertForbidden();
        }

        $isAuthorize = $isActionRoleAuthorize('detach');
        $request = deleteJson($this->value.'/detach', [1], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
        if ($isAuthorize) {
            $request->assertOk();
        } else {
            $request->assertForbidden();
        }

        $isAuthorize = $isActionRoleAuthorize('sync');
        $request = patchJson($this->value.'/sync', [[1 => call_user_func($testCase->validSample)]], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
        if ($isAuthorize) {
            $request->assertOk();
        } else {
            $request->assertForbidden();
        }

        $isAuthorize = $isActionRoleAuthorize('toggle');
        $request = patchJson($this->value.'/toggle', [1], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
        if ($isAuthorize) {
            $request->assertOk();
        } else {
            $request->assertForbidden();
        }

        $isAuthorize = $isActionRoleAuthorize('pivot');
        $request = patchJson($this->value.'/1/pivot', [call_user_func($testCase->validSample)], ['Authorization' => 'Bearer '.TestCase::$$tokenName]);
        if ($isAuthorize) {
            $request->assertOk();
        } else {
            $request->assertForbidden();
        }
    }

    // }
});

expect()->extend('indexToHaveExactJsonStructure', function ($testCase) {
    if (! in_array('index', $testCase->except)) {
        getJson($this->value, ['Authorization' => 'Bearer '.TestCase::$adminToken])
            ->assertOK()
            ->assertExactJsonStructure($testCase->indexStructure);
    }
});

expect()->extend('showToHaveExactJsonStructure', function ($testCase) {
    if (! in_array('show', $testCase->except)) {
        getJson($this->value.'/1', ['Authorization' => 'Bearer '.TestCase::$adminToken])
            ->assertOK()
            ->assertExactJsonStructure($testCase->showStructure);
    }
});

expect()->extend('toDelete', function ($testCase) {
    if (! in_array('destroy', $testCase->except)) {
        deleteJson($this->value, [], ['Authorization' => 'Bearer '.TestCase::$adminToken])
            ->assertOK();
    }
});

expect()->extend('toStore', function ($testCase) {
    if (! in_array('store', $testCase->except)) {
        postJson($this->value, call_user_func($testCase->validSample), ['Authorization' => 'Bearer '.TestCase::$adminToken])
            ->assertCreated();

        if ($testCase->invalidSample !== null) {
            postJson($this->value, $testCase->invalidSample, ['Authorization' => 'Bearer '.TestCase::$adminToken])
                ->assertUnprocessable();
        }
    }
});

expect()->extend('toUpdate', function ($testCase) {
    if (! in_array('update', $testCase->except)) {
        putJson($this->value, call_user_func($testCase->validSample), ['Authorization' => 'Bearer '.TestCase::$adminToken])
            ->assertOK();

        if ($testCase->invalidSample !== null) {
            putJson($this->value, $testCase->invalidSample, ['Authorization' => 'Bearer '.TestCase::$adminToken])
                ->assertUnprocessable();
        }
    }
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

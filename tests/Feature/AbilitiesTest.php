<?php

use App\Authorization\AuthorizationRole;
use App\Models\Role;
use App\Models\User;

use function Laravel\Prompts\password;

it('register abilities to the roles', function () {

    expect(AuthorizationRole::MANAGER->abilities())->toContain('user:promote_to_representer');
    
    User::factory()->create(['name' => 'ludwig','role_id' => 2]);
    $user = User::where('name', 'ludwig')->first();
    expect($user->abilities())->toContain('user:promote_to_representer');

    $role = Role::find(AuthorizationRole::MANAGER->id());
    expect($role->abilities())->toContain('user:promote_to_representer');
});

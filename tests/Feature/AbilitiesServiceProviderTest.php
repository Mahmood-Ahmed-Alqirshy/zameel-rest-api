<?php

use App\Authorization\Role;

it('register abilities to the roles', function () {

    expect(Role::MANAGER->abilities())->toContain('user:promote_to_representer');
});

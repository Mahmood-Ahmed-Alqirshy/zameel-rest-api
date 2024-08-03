<?php

namespace App\Authorization\Abilities;

use App\Authorization\Abilities;
use App\Authorization\Role;

class User extends Abilities
{

    const PromoteToRepresenter = 'user:promote_to_representer';

    public function grant() : array
    {
        return [
            Role::MANAGER->value => [ self::PromoteToRepresenter ],
            Role::ACADEMIC->value => [],
            Role::REPRESENTER->value => [],
            Role::STUDENT->value => [],
        ];
    }
}

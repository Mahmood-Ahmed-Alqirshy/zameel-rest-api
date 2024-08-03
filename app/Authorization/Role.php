<?php

namespace App\Authorization;

enum Role: int
{
    case SUPERADMIN = 1;
    case MANAGER = 2;
    case ACADEMIC = 3;
    case REPRESENTER = 4;
    case STUDENT = 5;

    public function id()
    {
        return $this->value;
    }

    public function abilities()
    {
        return match ($this) {
            Role::SUPERADMIN => Abilities::getAbilities(Role::SUPERADMIN),
            Role::MANAGER => Abilities::getAbilities(Role::MANAGER),
            Role::ACADEMIC => Abilities::getAbilities(Role::ACADEMIC),
            Role::REPRESENTER => Abilities::getAbilities(Role::REPRESENTER),
            Role::STUDENT => Abilities::getAbilities(Role::STUDENT),
        };
    }
}

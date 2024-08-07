<?php

namespace App\Authorization;

enum AuthorizationRole: int
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
            AuthorizationRole::SUPERADMIN => Abilities::getAbilities(AuthorizationRole::SUPERADMIN),
            AuthorizationRole::MANAGER => Abilities::getAbilities(AuthorizationRole::MANAGER),
            AuthorizationRole::ACADEMIC => Abilities::getAbilities(AuthorizationRole::ACADEMIC),
            AuthorizationRole::REPRESENTER => Abilities::getAbilities(AuthorizationRole::REPRESENTER),
            AuthorizationRole::STUDENT => Abilities::getAbilities(AuthorizationRole::STUDENT),
        };
    }
}

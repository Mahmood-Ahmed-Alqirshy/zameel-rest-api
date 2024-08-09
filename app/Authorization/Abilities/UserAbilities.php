<?php

namespace App\Authorization\Abilities;

use App\Authorization\Abilities;
use App\Authorization\AuthorizationRole;

class UserAbilities extends Abilities
{
    const PromoteToRepresenter = 'user:promote_to_representer';

    public function grant(): array
    {
        return [
            AuthorizationRole::MANAGER->value => [self::PromoteToRepresenter],
            AuthorizationRole::ACADEMIC->value => [],
            AuthorizationRole::REPRESENTER->value => [],
            AuthorizationRole::STUDENT->value => [],
        ];
    }
}

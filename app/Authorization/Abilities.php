<?php

namespace App\Authorization;

abstract class Abilities
{
    abstract public function grant(): array;

    public static function grantAbilities(array $grantedAbilities)
    {
        foreach (array_keys($grantedAbilities) as $role) {
            self::$Abilities[$role] = array_merge(self::$Abilities[$role], $grantedAbilities[$role]);
        }
    }

    public static function getAbilities(AuthorizationRole $role)
    {
        return self::$Abilities[$role->value];
    }

    public static $Abilities = [
        AuthorizationRole::SUPERADMIN->value => ['*'],
        AuthorizationRole::MANAGER->value => [],
        AuthorizationRole::ACADEMIC->value => [],
        AuthorizationRole::REPRESENTER->value => [],
        AuthorizationRole::STUDENT->value => [],
    ];
}

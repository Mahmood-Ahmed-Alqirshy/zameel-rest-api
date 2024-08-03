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

    public static function getAbilities(Role $role)
    {
        return self::$Abilities[$role->value];
    }

    public static $Abilities = [
        Role::SUPERADMIN->value => ['*'],
        Role::MANAGER->value => [],
        Role::ACADEMIC->value => [],
        Role::REPRESENTER->value => [],
        Role::STUDENT->value => [],
    ];
}

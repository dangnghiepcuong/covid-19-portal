<?php

namespace App\Enums;

class Role
{
    public const ROLE_ADMIN = 1;
    public const ROLE_BUSINESS = 2;
    public const ROLE_USER = 3;

    public static function allCases()
    {
        $object = new Role();
        $array = [];
        foreach ($object as $properties => $value) {
            array_push($array, $value);
        }
    }
}

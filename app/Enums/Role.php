<?php

namespace App\Enums;

use ReflectionClass;

class Role
{
    public const ROLE_ADMIN = 1;
    public const ROLE_BUSINESS = 2;
    public const ROLE_USER = 3;

    private static function getConstants()
    {
        $oClass = new ReflectionClass(self::class);

        return $oClass->getConstants();
    }

    public static function allCases()
    {
        $consts = self::getConstants();
        $array = [];
        foreach ($consts as $properties => $value) {
            array_push($array, $value);
        }

        return $array;
    }
}

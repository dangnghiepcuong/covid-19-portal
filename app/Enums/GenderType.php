<?php

namespace App\Enums;

use ReflectionClass;

class GenderType
{
    public const FEMALE = 'Nữ';
    public const MALE = 'Nam';
    public const OTHER = 'Khác';

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

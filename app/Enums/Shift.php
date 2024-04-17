<?php

namespace App\Enums;

use ReflectionClass;

class Shift
{
    public const DAY_SHIFT = 'day_shift';
    public const NOON_SHIFT = 'noon_shift';
    public const NIGHT_SHIFT = 'night_shift';

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

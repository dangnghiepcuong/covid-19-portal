<?php

namespace App\Enums;

use ReflectionClass;

class ActionStatus
{
    public const WARNING = 'warning';
    public const ERROR = 'error';
    public const SUCCESS = 'success';

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

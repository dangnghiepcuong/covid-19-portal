<?php

namespace App\Enums;

use ReflectionClass;

class ScheduleTime
{
    public const OLD = 'old';
    public const TODAY = 'today';
    public const ONWARD = 'onward';

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

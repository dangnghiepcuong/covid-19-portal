<?php

namespace App\Enums;

use ReflectionClass;

class RegistrationStatusRule
{
    public const REGISTERED = [RegistrationStatus::CHECKED_IN, RegistrationStatus::CANCELED];
    public const CHECKED_IN = [RegistrationStatus::SHOT, RegistrationStatus::CANCELED];
    public const SHOT = [];
    public const CANCELED = [];

    public static function statusRule($status)
    {
        $statusRule = [
            RegistrationStatus::REGISTERED => self::REGISTERED,
            RegistrationStatus::CHECKED_IN => self::CHECKED_IN,
            RegistrationStatus::SHOT => self::SHOT,
            RegistrationStatus::CANCELED => self::CANCELED,

        ];

        return $statusRule[$status];
    }

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

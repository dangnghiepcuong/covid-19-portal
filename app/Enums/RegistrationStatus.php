<?php

namespace App\Enums;

class RegistrationStatus
{
    public const REGISTERED = 'registered';
    public const CHECKED_IN = 'checked_in';
    public const SHOT = 'shot';
    public const CANCELED = 'canceled';

    public static function allCases()
    {
        $object = new RegistrationStatus();
        $array = [];
        foreach ($object as $properties => $value) {
            array_push($array, $value);
        }
    }
}

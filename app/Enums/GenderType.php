<?php

namespace App\Enums;

class GenderType
{
    public const FEMALE = 'Nữ';
    public const MALE = 'Nam';
    public const OTHER = 'Khác';

    public static function allCases()
    {
        $object = new GenderType();
        $array = [];
        foreach ($object as $properties => $value) {
            array_push($array, $value);
        }
    }
}

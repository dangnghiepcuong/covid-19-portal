<?php

namespace App\Enums;

class ShotType
{
    public const FIRST_SHOT = 'Mũi đầu tiên';
    public const SECOND_SHOT = 'Mũi thứ hai';
    public const BOOSTER_SHOT = 'Mũi tăng cường';

    public static function allCases()
    {
        $object = new ShotType();
        $array = [];
        foreach ($object as $properties => $value) {
            array_push($array, $value);
        }
    }
}

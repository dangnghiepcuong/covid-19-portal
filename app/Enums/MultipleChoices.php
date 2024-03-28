<?php

namespace App\Enums;

class MultipleChoices
{
    public const A = 'A';
    public const B = 'B';
    public const C = 'C';
    public const D = 'D';

    public static function allCases()
    {
        $object = new MultipleChoices();
        $array = [];
        foreach ($object as $properties => $value) {
            array_push($array, $value);
        }
    }
}

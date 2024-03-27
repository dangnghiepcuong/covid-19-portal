<?php

namespace App\Enums;

class QuestionType
{
    public const TRUE_FALSE = 'Đúng/Sai';
    public const MULTIPLE_CHOICES = 'Nhiều lựa chọn';
    public const TEXT = 'Đoạn văn bản';

    public static function allCases()
    {
        $object = new QuestionType();
        $array = [];
        foreach ($object as $properties => $value) {
            array_push($array, $value);
        }
    }
}

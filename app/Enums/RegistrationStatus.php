<?php

namespace App\Enums;

class RegistrationStatus
{
    public const REGISTERED = 'Đã đăng ký';
    public const CHECKED_IN = 'Đã điểm danh';
    public const SHOT = 'Đã tiêm';
    public const CANCELED = 'Đã hủy';

    public static function allCases()
    {
        $object = new RegistrationStatus();
        $array = [];
        foreach ($object as $properties => $value) {
            array_push($array, $value);
        }
    }
}

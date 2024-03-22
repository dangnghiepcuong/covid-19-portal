<?php

namespace App\Models;

enum GenderType: string
{
    case Male = 'Male';
    case Female = 'Female';
    case Other = 'Other';
}

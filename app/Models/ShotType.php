<?php
namespace App\Models;

enum ShotType: string
{
    case FirstShot = 'Mũi đầu tiên';
    case SecondShot = 'Mũi thứ hai';
    case Booster = 'Mũi tăng cường';
}
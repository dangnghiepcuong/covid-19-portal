<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'shot_name' => ShotType::class
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Registration extends Pivot
{
    use HasFactory;

    protected $table = 'registrations';
    public $incrementing = true;

    protected $guarded = [
        'id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccineLot extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function vaccine()
    {
        return $this->belongsTo('App\Vaccine');
    }

    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }
}

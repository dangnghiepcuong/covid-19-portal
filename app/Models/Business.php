<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function vaccineLots()
    {
        return $this->hasMany('App\VaccineLot');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }
}

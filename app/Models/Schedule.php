<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    public function vaccineLot()
    {
        return $this->belongsTo('App\VaccineLot');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')
        ->using('App\Registration')
        ->withPivot(['created_at', 'updated_at', 'number_order', 'status']);
    }

    public function vaccinations()
    {
        return $this->hasMany('App\Vaccination');
    }
}

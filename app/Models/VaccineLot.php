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

    protected $with = ['vaccine:name,id'];

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}

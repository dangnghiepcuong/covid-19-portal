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
        return $this->belongsTo(Business::class);
    }

    public function vaccineLot()
    {
        return $this->belongsTo(VaccineLot::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using('App\Registration')
            ->withPivot(['created_at', 'updated_at', 'number_order', 'status']);
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }
}

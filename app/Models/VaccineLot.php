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

    public function setExpiryDateAttribute($value)
    {
        $expiryDate = date_add(
            date_create($this->import_date),
            date_interval_create_from_date_string($value . ' days')
        );
        $expiryDate = $expiryDate->format('Y-m-d');

        $this->attributes['expiry_date'] = $expiryDate;
    }

    public function getDteAttribute()
    {
        $dte = date_diff(date_create($this->import_date), date_create($this->expiry_date));

        return $dte->format('%a');
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0)
            ->where('expiry_date', '>', date('Y-m-d'));
    }
}

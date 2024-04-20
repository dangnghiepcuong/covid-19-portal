<?php

namespace App\Models;

use App\Enums\Shift;
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

    protected $with = [
        'vaccineLot:id,lot,vaccine_id',
        'vaccineLot.vaccine:id,name',
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
        return $this->belongsToMany(User::class, 'registrations', 'schedule_id', 'user_id')
            ->withPivot(['id', 'created_at', 'updated_at', 'shift', 'number_order', 'status']);
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    public function getDayShiftAttribute()
    {
        return "{$this->day_shift_registration} / {$this->day_shift_limit}";
    }

    public function getNoonShiftAttribute()
    {
        return "{$this->noon_shift_registration} / {$this->noon_shift_limit}";
    }

    public function getNightShiftAttribute()
    {
        return "{$this->night_shift_registration} / {$this->night_shift_limit}";
    }

    public function scopeIsAvailable($query)
    {
        return $query->where('on_date', '>', date('Y-m-d'));
    }

    public function decreaseRegistration($shift)
    {
        switch ($shift) {
            case Shift::DAY_SHIFT:
                $this->day_shift_registration--;

                break;
            case Shift::NOON_SHIFT:
                $this->noon_shift_registration--;

                break;
            case Shift::NIGHT_SHIFT:
                $this->night_shift_registration--;

                break;
            default:
                return false;
        }

        return $this->save();
    }
}

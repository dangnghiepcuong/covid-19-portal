<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'registrations', 'user_id', 'schedule_id')
            ->withPivot(['id', 'created_at', 'updated_at', 'shift', 'number_order', 'status']);
    }

    public function getFullNameAttribute($value)
    {
        return "{$this->last_name} {$this->first_name}";
    }
}

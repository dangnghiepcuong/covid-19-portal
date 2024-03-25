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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function forms()
    {
        return $this->hasMany('App\Form');
    }

    public function schedules()
    {
        return $this->belongsToMany('App\Schedule')->using('App\Registration')->withPivot(['created_at', 'updated_at', 'number_order', 'status']);
    }

    public function vaccinations()
    {
        return $this->hasMany('App\Vaccination');
    }
}

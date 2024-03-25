<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsTo('App\Role');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function business()
    {
        return $this->hasOne('App\Business');
    }
}

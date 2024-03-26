<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Enums\Role;

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
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function scopeIsAdmin($query)
    {
        return $query->where('role', Role::ROLE['role_admin']);
    }
}

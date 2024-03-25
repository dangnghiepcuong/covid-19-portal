<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [
        'id',
    ];

    public function formAnswers()
    {
        return $this->hasMany('App\FormAnswer');
    }
}

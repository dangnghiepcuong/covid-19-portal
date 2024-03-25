<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function form()
    {
        return $this->belongsTo('App\Form');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}

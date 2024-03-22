<?php

namespace App\Models;

use App\Model\MultipleChoices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'answer_multiple_choices' => MultipleChoices::class,
        ];
    }
}

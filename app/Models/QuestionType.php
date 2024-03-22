<?php

namespace App\Models;

enum QuestionType: string
{
    case TrueFalse = 'True or False';
    case MultipleChoices = 'Multiple choices';
    case Text = 'Text';
}

<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetScheduleApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_date' => ['date', Rule::when($this->to_date, 'before_or_equal:to_date')],
            'to_date' => ['date', Rule::when($this->from_date, 'after_or_equal:from_date')],
        ];
    }
}

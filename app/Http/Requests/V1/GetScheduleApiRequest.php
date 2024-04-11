<?php

namespace App\Http\Requests\V1;

use App\Models\Vaccine;
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
        $vaccineIds = Vaccine::isAllow()->pluck('id');

        return [
            'from_date' => ['date', Rule::when($this->to_date, 'before_or_equal:to_date')],
            'to_date' => ['date', Rule::when($this->from_date, 'after_or_equal:from_date')],
            // 'vaccine_id' => ['numeric', Rule::in($vaccineIds)],
            'shift' => [Rule::in(['day', 'noon', 'night'])],
        ];
    }
}

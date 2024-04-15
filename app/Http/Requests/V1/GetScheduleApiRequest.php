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
        $vaccineIds = Vaccine::pluck('id')->toArray();

        return [
            'from_date' => [Rule::when($this->from_date && $this->to_date, ['date', 'before_or_equal:' . $this->to_date])],
            'to_date' => [Rule::when($this->from_date && $this->to_date, ['date', 'after_or_equal:' . $this->from_date])],
            'vaccine_id' => [Rule::when($this->vaccine_id !== null, ['numeric', Rule::in($vaccineIds)])],
        ];
    }
}

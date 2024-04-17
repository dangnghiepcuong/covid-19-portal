<?php

namespace App\Http\Requests;

use App\Enums\Shift;
use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VaccinationRequest extends FormRequest
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
        $shifts = Shift::allCases();
        $scheduleId = Schedule::pluck('id');

        return [
            'schedule_id' => ['required', Rule::in($scheduleId)],
            'shift' => ['required', Rule::in($shifts)],
        ];
    }
}

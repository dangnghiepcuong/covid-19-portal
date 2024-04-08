<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ScheduleRequest extends FormRequest
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
        $vaccineLotIds = Auth::user()->business
            ->vaccineLots()
            ->inStock()
            ->pluck('id');

        return [
            'on_date' => ['required', 'date', 'after:today'],
            'vaccine_lot_id' => ['required', Rule::in($vaccineLotIds)],
            'day_shift_limit' => ['required', 'numeric', 'gte:0'],
            'noon_shift_limit' => ['required', 'numeric', 'gte:0'],
            'night_shift_limit' => ['required', 'numeric', 'gte:0'],
        ];
    }
}

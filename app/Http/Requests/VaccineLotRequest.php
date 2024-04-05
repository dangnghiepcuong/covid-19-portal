<?php

namespace App\Http\Requests;

use App\Models\Vaccine;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VaccineLotRequest extends FormRequest
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
        $vaccineIds = Vaccine::pluck('id');

        return [
            'vaccine_id' => ['required', 'numeric', Rule::in($vaccineIds)],
            'lot' => ['required', 'string', 'max:30'],
            'quantity' => ['required', 'numeric'],
            'import_date' => ['required', 'date'],
            'dte' => ['required', 'numeric', 'gte:0'],
            'expiry_date' => [],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VaccineRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:30'],
            'supplier' => ['required', 'string', 'max:50'],
            'technology' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:50'],
            'is_allow' => ['required', 'boolean'],
        ];
    }
}

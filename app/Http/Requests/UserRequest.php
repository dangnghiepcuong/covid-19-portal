<?php

namespace App\Http\Requests;

use App\Enums\GenderType;
use App\Http\Controllers\LocalRegionController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $provinceList = LocalRegionController::getProvinceCodeList();
        $districtList = LocalRegionController::getDistrictCodeList($this);
        $wardList = LocalRegionController::getWardCodeList($this);

        return [
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'pid' => ['required', 'string', 'regex:/^[0-9]+$/'],
            'birthday' => ['required', 'date'],
            'gender' => ['required', Rule::in(GenderType::allCases())],
            'addr_province' => ['required', Rule::in($provinceList)],
            'addr_district' => ['required', Rule::in($districtList)],
            'addr_ward' => ['required', Rule::in($wardList)],
        ];
    }
}

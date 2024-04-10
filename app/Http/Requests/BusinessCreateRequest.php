<?php

namespace App\Http\Requests;

use App\Http\Controllers\LocalRegionController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BusinessCreateRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:accounts'],
            'password' => ['required', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
            'tax_id' => ['required', 'string', 'regex:/^[0-9]+$/'],
            'addr_province' => ['required', Rule::in($provinceList)],
            'addr_district' => ['required', Rule::in($districtList)],
            'addr_ward' => ['required', Rule::in($wardList)],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Controllers\LocalRegionController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BusinessSearchRequest extends FormRequest
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
            'addr_province' => [Rule::in($provinceList)],
            'addr_district' => [Rule::in($districtList)],
            'addr_ward' => [Rule::in($wardList)],
        ];
    }
}

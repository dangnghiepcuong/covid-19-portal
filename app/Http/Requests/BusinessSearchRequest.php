<?php

namespace App\Http\Requests;

use App\Helpers\LocalRegionHelper;
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
        $provinceList = LocalRegionHelper::getProvinceList(true);
        $districtList = LocalRegionHelper::getDistrictList($this->addr_province, true);
        $wardList = LocalRegionHelper::getWardList($this->addr_province, $this->addr_district, true);

        return [
            'addr_province' => [Rule::in($provinceList)],
            'addr_district' => [Rule::in($districtList)],
            'addr_ward' => [Rule::in($wardList)],
        ];
    }
}

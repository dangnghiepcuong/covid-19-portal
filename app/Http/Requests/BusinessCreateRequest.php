<?php

namespace App\Http\Requests;

use App\Helpers\LocalRegionHelper;
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
        $provinceList = LocalRegionHelper::getProvinceList(true);
        $districtList = LocalRegionHelper::getDistrictList($this->addr_province, true);
        $wardList = LocalRegionHelper::getWardList($this->addr_province, $this->addr_district, true);

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

<?php

namespace App\Http\Controllers;

use App\Helpers\LocalRegionHelper;
use Illuminate\Http\Request;

class LocalRegionController extends Controller
{
    public static function getProvinceList()
    {
        $list = LocalRegionHelper::getProvinceList();

        return response()->json($list, 200);
    }

    public static function getDistrictList(Request $request)
    {
        $list = LocalRegionHelper::getDistrictList($request->addr_province);

        return response()->json($list, 200);
    }

    public static function getWardList(Request $request)
    {
        $list = LocalRegionHelper::getWardList($request->addr_province, $request->addr_district);

        return response()->json($list, 200);
    }

    public static function getProvinceCodeList()
    {
        $list = LocalRegionHelper::getProvinceList(true);

        return response()->json($list, 200);
    }

    public static function getDistrictCodeList($provinceCode)
    {
        $list = LocalRegionHelper::getDistrictList($provinceCode, true);

        return response()->json($list, 200);
    }

    public static function getWardCodeList($provinceCode, $districtCode)
    {
        $list = LocalRegionHelper::getWardList($provinceCode, $districtCode, true);

        return response()->json($list, 200);
    }
}

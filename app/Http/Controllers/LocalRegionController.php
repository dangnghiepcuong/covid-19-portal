<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocalRegionController extends Controller
{
    public static function getProvinceList()
    {
        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        $provinceList = [];
        foreach ($local as $province) {
            array_push($provinceList, $province['name']);
        }

        return $provinceList;
    }

    public static function getDistrictList(Request $request)
    {
        if ($request->addr_province === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addrProvince = (int) $request->addr_province;
            $districts = $local[$addrProvince]['districts'];
        } catch (ErrorException $e) {
            return [];
        }

        $districtList = [];
        foreach ($districts as $district) {
            array_push($districtList, $district['name']);
        }

        return $districtList;
    }

    public static function getWardList(Request $request)
    {
        if ($request->addr_province === null || $request->addr_district === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addrProvince = (int) $request->addr_province;
            $addrDistrict = (int) substr($request->addr_district, 2);
            $wards = $local[$addrProvince]['districts'][$addrDistrict]['wards'];
        } catch (ErrorException $e) {
            return [];
        }

        $wards = $local[$addrProvince]['districts'][$addrDistrict]['wards'];
        $wardList = [];
        foreach ($wards as $ward) {
            array_push($wardList, $ward['name']);
        }

        return $wardList;
    }

    public static function getProvinceCodeList()
    {
        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        $provinceList = [];
        $i = 0;
        foreach ($local as $province) {
            array_push($provinceList, str_pad($i, 2, '0', STR_PAD_LEFT));
            $i++;
        }

        return $provinceList;
    }

    public static function getDistrictCodeList(Request $request)
    {
        if ($request->addr_province === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addrProvince = (int) $request->addr_province;
            $districts = $local[$addrProvince]['districts'];
        } catch (ErrorException $e) {
            return [];
        }

        $districtList = [];
        $i = 0;
        foreach ($districts as $district) {
            array_push($districtList, $request->addr_province . str_pad($i, 2, '0', STR_PAD_LEFT));
            $i++;
        }

        return $districtList;
    }

    public static function getWardCodeList(Request $request)
    {
        if ($request->addr_province === null || $request->addr_district === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addrProvince = (int) $request->addr_province;
            $addrDistrict = (int) substr($request->addr_district, 2);
            $wards = $local[$addrProvince]['districts'][$addrDistrict]['wards'];
        } catch (ErrorException $e) {
            return [];
        }

        $wards = $local[$addrProvince]['districts'][$addrDistrict]['wards'];
        $wardList = [];
        $i = 0;
        foreach ($wards as $ward) {
            array_push($wardList, $request->addr_district . str_pad($i, 2, '0', STR_PAD_LEFT));
            $i++;
        }

        return $wardList;
    }

    public static function getProvinceName($code): string
    {
        if ($code === null) {
            return '';
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addrProvince = (int) $code;
            $name = $local[$addrProvince]['name'];
        } catch (ErrorException $e) {
            return '';
        }

        return $name;
    }

    public static function getDistrictName($code): string
    {
        if ($code === null) {
            return '';
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addrProvince = (int) substr($code, 0, 2);
            $addrDistrict = (int) substr($code, 2);
            $name = $local[$addrProvince]['districts'][$addrDistrict]['name'];
        } catch (ErrorException $e) {
            return '';
        }

        return $name;
    }

    public static function getWardName($code): string
    {
        if ($code === null) {
            return '';
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addrProvince = (int) substr($code, 0, 2);
            $addrDistrict = (int) substr($code, 2, 2);
            $addrWard = (int) substr($code, 4);
            $name = $local[$addrProvince]['districts'][$addrDistrict]['wards'][$addrWard]['name'];
        } catch (ErrorException $e) {
            return '';
        }

        return $name;
    }
}

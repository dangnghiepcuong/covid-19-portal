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

        $province_list = [];
        foreach ($local as $province) {
            array_push($province_list, $province['name']);
        }

        return $province_list;
    }

    public static function getDistrictList(Request $request)
    {
        if ($request->addr_province === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addr_province = (int) $request->addr_province;
            $districts = $local[$addr_province]['districts'];
        } catch (ErrorException $e) {
            return [];
        }

        $district_list = [];
        foreach ($districts as $district) {
            array_push($district_list, $district['name']);
        }

        return $district_list;
    }

    public static function getWardList(Request $request)
    {
        if ($request->addr_province === null || $request->addr_district === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addr_province = (int) $request->addr_province;
            $addr_district = (int) substr($request->addr_district, 2);
            $wards = $local[$addr_province]['districts'][$addr_district]['wards'];
        } catch (ErrorException $e) {
            return [];
        }

        $wards = $local[$addr_province]['districts'][$addr_district]['wards'];
        $ward_list = [];
        foreach ($wards as $ward) {
            array_push($ward_list, $ward['name']);
        }

        return $ward_list;
    }

    public static function getProvinceCodeList()
    {
        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        $province_list = [];
        $i = 0;
        foreach ($local as $province) {
            array_push($province_list, str_pad($i, 2, '0', STR_PAD_LEFT));
            $i++;
        }

        return $province_list;
    }

    public static function getDistrictCodeList(Request $request)
    {
        if ($request->addr_province === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addr_province = (int) $request->addr_province;
            $districts = $local[$addr_province]['districts'];
        } catch (ErrorException $e) {
            return [];
        }

        $district_list = [];
        $i = 0;
        foreach ($districts as $district) {
            array_push($district_list, $request->addr_province . str_pad($i, 2, '0', STR_PAD_LEFT));
            $i++;
        }

        return $district_list;
    }

    public static function getWardCodeList(Request $request)
    {
        if ($request->addr_province === null || $request->addr_district === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addr_province = (int) $request->addr_province;
            $addr_district = (int) substr($request->addr_district, 2);
            $wards = $local[$addr_province]['districts'][$addr_district]['wards'];
        } catch (ErrorException $e) {
            return [];
        }

        $wards = $local[$addr_province]['districts'][$addr_district]['wards'];
        $ward_list = [];
        $i = 0;
        foreach ($wards as $ward) {
            array_push($ward_list, $request->addr_district . str_pad($i, 2, '0', STR_PAD_LEFT));
            $i++;
        }

        return $ward_list;
    }

    public static function getProvinceName($code): string
    {
        if ($code === null) {
            return '';
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $addr_province = (int) $code;
            $name = $local[$addr_province]['name'];
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
            $addr_province = (int) substr($code, 0, 2);
            $addr_district = (int) substr($code, 2);
            $name = $local[$addr_province]['districts'][$addr_district]['name'];
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
            $addr_province = (int) substr($code, 0, 2);
            $addr_district = (int) substr($code, 2, 2);
            $addr_ward = (int) substr($code, 4);
            $name = $local[$addr_province]['districts'][$addr_district]['wards'][$addr_ward]['name'];
        } catch (ErrorException $e) {
            return '';
        }

        return $name;
    }
}

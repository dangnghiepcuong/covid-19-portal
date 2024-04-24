<?php

namespace App\Helpers;

use ErrorException;
use Illuminate\Support\Facades\Storage;

class LocalRegionHelper
{
    public static function getProvinceList($getCodeOnly = false)
    {
        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        $provinceList = [];
        if ($getCodeOnly) {
            foreach ($local as $province) {
                array_push($provinceList, $province['id']);
            }
        } else {
            foreach ($local as $province) {
                $provinceList[$province['id']] = $province['name'];
            }
        }

        return $provinceList;
    }

    public static function getDistrictList($addrProvince, $getCodeOnly = false)
    {
        if ($addrProvince === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $districts = [];
            foreach ($local as $province) {
                if ($province['id'] === $addrProvince) {
                    $districts = $province['districts'];

                    break;
                }
            }
        } catch (ErrorException $e) {
            return [];
        }

        $districtList = [];
        if ($getCodeOnly) {
            foreach ($districts as $district) {
                array_push($districtList, $district['id']);
            }
        } else {
            foreach ($districts as $district) {
                $districtList[$district['id']] = $district['name'];
            }
        }

        return $districtList;
    }

    public static function getWardList($addrProvince, $addrDistrict, $getCodeOnly = false)
    {
        if ($addrProvince === null || $addrDistrict === null) {
            return [];
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $districts = [];
            $wards = [];
            foreach ($local as $province) {
                if ($province['id'] === $addrProvince) {
                    $districts = $province['districts'];

                    break;
                }
            }

            foreach ($districts as $district) {
                if ($district['id'] === $addrDistrict) {
                    $wards = $district['wards'];

                    break;
                }
            }
        } catch (ErrorException $e) {
            return [];
        }

        $wardList = [];
        if ($getCodeOnly) {
            foreach ($wards as $ward) {
                array_push($wardList, $ward['id']);
            }
        } else {
            foreach ($wards as $ward) {
                $wardList[$ward['id']] = $ward['name'];
            }
        }

        return $wardList;
    }

    public static function getProvinceName($provinceCode): string
    {
        if ($provinceCode === null) {
            return '';
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            foreach ($local as $province) {
                if ($province['id'] === $provinceCode) {
                    return $province['name'];
                }
            }
        } catch (ErrorException $e) {
            return '';
        }

        return '';
    }

    public static function getDistrictName($provinceCode, $districtCode): string
    {
        if ($provinceCode === null || $districtCode === null) {
            return '';
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $districts = [];
            foreach ($local as $province) {
                if ($province['id'] === $provinceCode) {
                    $districts = $province['districts'];

                    break;
                }
            }

            foreach ($districts as $district) {
                if ($district['id'] === $districtCode) {
                    return $district['name'];
                }
            }
        } catch (ErrorException $e) {
            return '';
        }

        return '';
    }

    public static function getWardName($provinceCode, $districtCode, $wardCode): string
    {
        if ($provinceCode === null || $districtCode === null || $wardCode === null) {
            return '';
        }

        $data = Storage::disk('local')->get('local.json');
        $local = json_decode($data, true);

        try {
            $districts = [];
            $wards = [];
            foreach ($local as $province) {
                if ($province['id'] === $provinceCode) {
                    $districts = $province['districts'];

                    break;
                }
            }

            foreach ($districts as $district) {
                if ($district['id'] === $districtCode) {
                    $wards = $district['wards'];

                    break;
                }
            }

            foreach ($wards as $ward) {
                if ($ward['id'] === $wardCode) {
                    return $ward['name'];
                }
            }
        } catch (ErrorException $e) {
            return '';
        }

        return '';
    }
}

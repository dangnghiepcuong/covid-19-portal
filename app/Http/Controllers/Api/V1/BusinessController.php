<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $businesses = Business::with([
            'schedules' => function ($query) {
                $query->isAvailable();
            },
        ]);

        if ($request->addr_province !== null) {
            $businesses = $businesses->where('addr_province', $request->addr_province);
        }

        if ($request->addr_district !== null) {
            $businesses = $businesses->where('addr_district', $request->addr_district);
        }

        if ($request->addr_ward !== null) {
            $businesses = $businesses->where('addr_ward', $request->addr_ward);
        }

        $businesses = $businesses->orderBy('addr_province', 'ASC');

        return $businesses->paginate();
    }

    public function show(Business $business)
    {
    }
}

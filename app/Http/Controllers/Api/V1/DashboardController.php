<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;

class DashboardController extends Controller
{
    public function getTotalDoses()
    {
        $result = Registration::where('status', RegistrationStatus::SHOT)->count();

        return response()->json($result, 200);
    }

    public function getTotalPeopleWithOnlyFirstDose()
    {
        $result = Registration::where('status', RegistrationStatus::SHOT)->groupBy('user_id')->count();

        return response()->json($result, 200);
    }

    public function getTotalPeopleWithOverOneDose()
    {
        $result = Registration::selectRaw('user_id, COUNT(*)')->where('status', RegistrationStatus::SHOT)
            ->groupBy('user_id')
            ->having('COUNT(*)', '>', '1')
            ->count();

        return response()->json($result, 200);
    }

    public function getTotalPeopleWithNoDose()
    {
        $result = User::whereNotIn(
            'id',
            Registration::select('user_id')
                ->where('status', RegistrationStatus::SHOT)
                ->groupBy('user_id')
                ->pluck('user_id')
        )->count();

        return response()->json($result, 200);
    }
}

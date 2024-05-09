<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Models\Vaccine;

class DashboardController extends Controller
{
    public function getTotalDoses()
    {
        $result = Registration::where('status', RegistrationStatus::SHOT)->count();

        return response()->json($result, 200);
    }

    public function getTotalPeopleWithOnlyFirstDose()
    {
        $result = Registration::selectRaw('user_id, COUNT(*)')->where('status', RegistrationStatus::SHOT)
            ->groupBy('user_id')
            ->having('COUNT(*)', '=', '1')
            ->count();

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

    public function getMonthlyVaccinationData()
    {
        $result = Registration::selectRaw(
            'YEAR(`schedules`.`on_date`) AS `year`, MONTH(`schedules`.`on_date`) AS `month`, COUNT(*) AS `data`'
        )
            ->join('schedules', 'schedules.id', '=', 'registrations.schedule_id')
            ->where('status', RegistrationStatus::SHOT)
            ->groupByRaw('YEAR(`schedules`.`on_date`), MONTH(`schedules`.`on_date`)')
            ->orderByRaw('YEAR(`schedules`.`on_date`) DESC, MONTH(`schedules`.`on_date`) DESC')
            ->limit(6)
            ->get();

        return response()->json($result, 200);
    }

    public function getVaccinationUsageData()
    {
        $result = Vaccine::selectRaw('`vaccines`.`id`, `vaccines`.`name`, COUNT(*) AS `usage`')
            ->join('vaccine_lots', 'vaccine_lots.vaccine_id', '=', 'vaccines.id')
            ->join('schedules', 'vaccine_lots.id', '=', 'schedules.vaccine_lot_id')
            ->join('registrations', 'schedules.id', '=', 'registrations.schedule_id')
            ->where('status', RegistrationStatus::SHOT)
            ->groupBy(['vaccines.id', 'vaccines.name'])
            ->get();

        return response()->json($result, 200);
    }
}

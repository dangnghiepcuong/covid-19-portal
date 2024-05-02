<?php

namespace App\Repositories\Schedule;

use App\Repositories\RepositoryInterface;

interface ScheduleRepositoryInterface extends RepositoryInterface
{
    public function getSchedulesOfABusiness(
        int $businessId,
        ?string $fromDate,
        ?string $toDate,
        ?int $vaccineId,
        ?string $time
    );

    public function storeSchedule(
        int $businessId,
        int $vaccineLotId,
        string $onDate,
        int $dayShiftLimit,
        int $noonShiftLimit,
        int $nightShiftLimit
    );

    public function updateSchedule(
        int $businessId,
        int $scheduleId,
        int $vaccineLotId,
        string $onDate,
        int $dayShiftLimit,
        int $noonShiftLimit,
        int $nightShiftLimit
    );

    public function destroySchedule(int $businessId, int $scheduleId);

    public function getRegistrations(
        int $businessId,
        int $scheduleId,
        ?string $shift,
        ?string $status
    );

    public function getTrashed(
        int $businessId,
        ?string $fromDate,
        ?string $toDate,
        ?int $vaccineId
    );

    public function restore(int $businessId, int $scheduleId);

    public function forceDelete(int $businessId, int $scheduleId);
}

<?php

namespace App\Repositories\Schedule;

use App\Enums\ActionStatus;
use App\Enums\RegistrationStatus;
use App\Enums\ScheduleTime;
use App\Models\Business;
use App\Models\Schedule;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{
    public function getModel()
    {
        return Schedule::class;
    }

    public function getSchedulesOfABusiness(
        int $businessId,
        ?string $fromDate,
        ?string $toDate,
        ?int $vaccineId,
        ?string $time
    ) {
        $business = Business::findOrFail($businessId);
        $schedules = $business->schedules();

        switch ($time) {
            case ScheduleTime::OLD:
                $schedules = $schedules->whereDate('on_date', '<', now());

                break;
            case ScheduleTime::TODAY:
                $schedules = $schedules->whereDate('on_date', '=', now());

                break;
            case ScheduleTime::ONWARD:
                $schedules = $schedules->isAvailable();

                break;
            default:
        }

        if ($fromDate !== null) {
            $schedules = $schedules->whereDate('on_date', '>=', $fromDate);
        }

        if ($toDate !== null) {
            $schedules = $schedules->whereDate('on_date', '<=', $toDate);
        }

        if ($vaccineId !== null) {
            $schedules = $schedules->whereRelation('vaccineLot', 'vaccine_id', $vaccineId);
        }

        $schedules = $schedules->orderBy('on_date', 'desc')
            ->paginate(config('parameters.DEFAULT_PAGINATING_NUMBER'));

        return $schedules;
    }

    public function storeSchedule(
        int $businessId,
        int $vaccineLotId,
        string $onDate,
        int $dayShiftLimit,
        int $noonShiftLimit,
        int $nightShiftLimit
    ) {
        DB::beginTransaction();

        try {
            $business = Business::findOrFail($businessId);
            $vaccineLot = $business->vaccineLots()->findOrFail($vaccineLotId);

            $vaccineLot->quantity = $vaccineLot->quantity
                - ($dayShiftLimit
                    + $noonShiftLimit
                    + $nightShiftLimit);

            if ($vaccineLot->quantity < 0) {
                DB::rollBack();

                return [
                    'status' => ActionStatus::WARNING,
                    'message' => __('schedule.total_limit'),
                ];
            }

            $vaccineLot->save();

            Schedule::create([
                'business_id' => $businessId,
                'vaccine_lot_id' => $vaccineLotId,
                'on_date' => $onDate,
                'day_shift_limit' => $dayShiftLimit,
                'noon_shift_limit' => $noonShiftLimit,
                'night_shift_limit' => $nightShiftLimit,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => ActionStatus::ERROR,
                'message' => __('message.failed'),
            ];
        }

        DB::commit();

        return [
            'status' => ActionStatus::SUCCESS,
            'message' => __(
                'message.success',
                [
                    'action' => __('btn.create', [
                        'object' => __('schedule.schedule'),
                    ]),
                ],
            ),
        ];
    }

    public function updateSchedule(
        int $businessId,
        int $scheduleId,
        int $vaccineLotId,
        string $onDate,
        int $dayShiftLimit,
        int $noonShiftLimit,
        int $nightShiftLimit
    ) {
        DB::beginTransaction();
        try {
            $business = Business::findOrFail($businessId);
            $schedule = $business->schedules()->findOrFail($scheduleId);

            $vaccineLot = $business->vaccineLots()->findOrFail($schedule->vaccine_lot_id);
            $vaccineLot->quantity = $vaccineLot->quantity
                + ($schedule->day_shift_limit
                    + $schedule->noon_shift_limit
                    + $schedule->night_shift_limit);
            $vaccineLot->save();

            if (
                $dayShiftLimit < $schedule->day_shift_registration
                || $noonShiftLimit < $schedule->noon_shift_registration
                || $nightShiftLimit < $schedule->night_shift_registration
            ) {
                DB::rollBack();

                return [
                    'status' => ActionStatus::WARNING,
                    'message' => __('schedule.over_limit'),
                ];
            }

            $vaccineLot = $business->vaccineLots()->findOrFail($vaccineLotId);
            $vaccineLot->quantity = $vaccineLot->quantity
                - ($dayShiftLimit
                    + $noonShiftLimit
                    + $nightShiftLimit);

            if ($vaccineLot->quantity < 0) {
                DB::rollBack();

                return [
                    'status' => ActionStatus::WARNING,
                    'message' => __('schedule.total_limit'),
                ];
            }

            $vaccineLot->save();
            $schedule->vaccine_lot_id = $vaccineLotId;
            $schedule->on_date = $onDate;
            $schedule->day_shift_limit = $dayShiftLimit;
            $schedule->noon_shift_limit = $noonShiftLimit;
            $schedule->night_shift_limit = $nightShiftLimit;
            $schedule->save();
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => ActionStatus::ERROR,
                'message' => $e->getMessage(),
            ];
        }

        DB::commit();

        return [
            'status' => ActionStatus::SUCCESS,
            'message' => __(
                'message.success',
                [
                    'action' => __('btn.update', [
                        'object' => __('schedule.schedule'),
                    ]),
                ],
            ),
        ];
    }

    public function destroySchedule(int $businessId, int $scheduleId)
    {
        DB::beginTransaction();
        try {
            $business = Business::findOrFail($businessId);
            $schedule = $business->schedules()->findOrFail($scheduleId);

            $schedule->users()->update([
                'status' => RegistrationStatus::CANCELED,
            ]);

            $vaccineLot = $business->vaccineLots()->findOrFail($schedule->vaccine_lot_id);
            $vaccineLot->quantity = $vaccineLot->quantity
                + ($schedule->day_shift_limit
                    + $schedule->noon_shift_limit
                    + $schedule->night_shift_limit);
            $vaccineLot->save();

            $schedule->day_shift_registration = 0;
            $schedule->noon_shift_registration = 0;
            $schedule->night_shift_registration = 0;
            $schedule->day_shift_limit = 0;
            $schedule->noon_shift_limit = 0;
            $schedule->night_shift_limit = 0;
            $schedule->save();

            $business->schedules()->findOrFail($scheduleId)->delete();
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => ActionStatus::ERROR,
                'message' => __('message.failed'),
            ];
        }

        DB::commit();

        return [
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.delete')]),
        ];
    }

    public function getRegistrations(
        int $businessId,
        int $scheduleId,
        ?string $shift,
        ?string $status
    ) {
        $business = Business::findOrFail($businessId);
        $schedule = $business->schedules()->findOrfail($scheduleId);
        $registrations = $schedule->users();

        if ($shift !== null) {
            $registrations = $registrations->wherePivot('shift', $shift);
        }

        if ($status !== null) {
            $registrations = $registrations->wherePivot('status', $status);
        } else {
            $registrations = $registrations->wherePivotNotIn('status', [RegistrationStatus::CANCELED]);
        }

        $registrations = $registrations->orderBy('number_order', 'DESC')
            ->paginate(config('parameters.DEFAULT_PAGINATING_NUMBER'));

        return $registrations;
    }

    public function getTrashed(int $businessId, ?string $fromDate, ?string $toDate, ?int $vaccineId)
    {
        $business = Business::findOrFail($businessId);
        $schedules = $business->schedules()->onlyTrashed();

        if ($fromDate !== null) {
            $schedules = $schedules->whereDate('on_date', '>=', $fromDate);
        }

        if ($toDate !== null) {
            $schedules = $schedules->whereDate('on_date', '<=', $toDate);
        }

        if ($vaccineId !== null) {
            $schedules = $schedules->whereRelation('vaccineLot', 'vaccine_id', $vaccineId);
        }

        $schedules = $schedules->orderBy('on_date', 'desc')
            ->paginate(config('parameters.DEFAULT_PAGINATING_NUMBER'));

        return $schedules;
    }

    public function restore(int $businessId, int $scheduleId)
    {
        $business = Business::findOrFail($businessId);
        $business->schedules()->onlyTrashed()->findOrFail($scheduleId)->restore();

        return [
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.restore')]),
        ];
    }

    public function forceDelete(int $businessId, int $scheduleId)
    {
        $schedule = $this->model->onlyTrashed()->findOrFail($scheduleId);
        $schedule->forceDelete();

        return [
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.delete')]),
        ];
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\GetScheduleApiRequest;
use App\Http\Resources\V1\ScheduleCollection;
use App\Http\Resources\V1\ScheduleResource;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index(GetScheduleApiRequest $request)
    {
        $request->validated();

        $schedules = Schedule::where('business_id', $request->business_id)
            ->isAvailable();

        if ($request->from_date !== null) {
            $schedules = $schedules->whereDate('on_date', '>=', $request->from_date);
        }

        if ($request->to_date !== null) {
            $schedules = $schedules->whereDate('on_date', '<=', $request->to_date);
        }

        if ($request->vaccine_id !== null) {
            $schedules = $schedules->whereRelation('vaccineLot', 'vaccine_id', $request->vaccine_id);
        }

        $schedules = $schedules->orderBy('on_date', 'ASC')
            ->paginate(config('parameters.DEFAULT_PAGINATING_NUMBER'));
        $schedules = new ScheduleCollection($schedules);

        return response()->json($schedules, 200);
    }

    public function show(Schedule $schedule)
    {
        return new ScheduleResource($schedule);
    }
}

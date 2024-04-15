<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ScheduleCollection;
use App\Http\Resources\V1\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::where('business_id', $request->business_id)
            ->isAvailable()->orderBy('on_date', 'ASC')->paginate();

        $schedules = new ScheduleCollection($schedules);

        return response()->json($schedules, 200);
    }

    public function show(Schedule $schedule)
    {
        return new ScheduleResource($schedule);
    }
}

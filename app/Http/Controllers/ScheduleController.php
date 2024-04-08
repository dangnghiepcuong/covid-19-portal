<?php

namespace App\Http\Controllers;

use App\Enums\RegistrationStatus;
use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use App\Models\VaccineLot;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Auth::user()->business->schedules()->isAvailable()->get();

        return view('schedule.index', ['schedules' => $schedules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vaccineLots = Auth::user()->business->vaccineLots()->inStock()->get();

        return view('schedule.create', ['vaccineLots' => $vaccineLots]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            $vaccineLot = VaccineLot::findOrFail($request->vaccine_lot_id);
            $vaccineLot->quantity = $vaccineLot->quantity
                - ($request->day_shift_limit
                    + $request->noon_shift_limit
                    + $request->night_shift_limit);

            if ($vaccineLot->quantity < 0) {
                DB::rollBack();

                return redirect()->back()->withErrors(['total_limit' => __('schedule.total_limit')]);
            }

            $vaccineLot->save();

            Schedule::create([
                'business_id' => Auth::user()->business->id,
                'vaccine_lot_id' => $request->vaccine_lot_id,
                'on_date' => $request->on_date,
                'day_shift_limit' => $request->day_shift_limit,
                'noon_shift_limit' => $request->noon_shift_limit,
                'night_shift_limit' => $request->night_shift_limit,
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['db' => __('message.failed')]);
        }

        DB::commit();

        return redirect()->back()->with('success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $vaccineLots = Auth::user()->business->vaccineLots()->inStock()->get();

        return view('schedule.edit', ['schedule' => $schedule, 'vaccineLots' => $vaccineLots]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, $id)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            $schedule = Schedule::findOrFail($id);

            $vaccineLot = VaccineLot::findOrFail($schedule->vaccine_lot_id);
            $vaccineLot->quantity = $vaccineLot->quantity
                + ($schedule->day_shift_limit
                    + $schedule->noon_shift_limit
                    + $schedule->night_shift_limit);
            $vaccineLot->save();

            if (
                $request->day_shift_limit < $schedule->day_shift_registration
                || $request->noon_shift_limit < $schedule->noon_shift_registration
                || $request->night_shift_limit < $schedule->night_shift_registration
            ) {
                DB::rollBack();

                return redirect()->back()->withErrors(['limits' => __('schedule.over_limit')]);
            }

            $vaccineLot = VaccineLot::findOrFail($request->vaccine_lot_id);
            $vaccineLot->quantity = $vaccineLot->quantity
                - ($request->day_shift_limit
                    + $request->noon_shift_limit
                    + $request->night_shift_limit);

            if ($vaccineLot->quantity < 0) {
                DB::rollBack();

                return redirect()->back()->withErrors(['total_limit' => __('schedule.total_limit')]);
            }

            $vaccineLot->save();
            $schedule->vaccine_lot_id = $request->vaccine_lot_id;
            $schedule->on_date = $request->on_date;
            $schedule->day_shift_limit = $request->day_shift_limit;
            $schedule->noon_shift_limit = $request->noon_shift_limit;
            $schedule->night_shift_limit = $request->night_shift_limit;
            $schedule->save();
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['db' => __('message.failed')]);
        }

        DB::commit();

        return redirect()->back()->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $schedule = Schedule::findOrFail($id);

            $schedule->users()->update([
                'status' => RegistrationStatus::CANCELED,
            ]);

            $vaccineLot = VaccineLot::findOrFail($schedule->vaccine_lot_id);
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

            Schedule::destroy($id);
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['db' => __('message.failed')]);
        }

        DB::commit();

        return redirect()->back()->with(['success' => true, 'action' => 'delete']);
    }

    public function trashed()
    {
        $schedules = Schedule::onlyTrashed()->get();

        return view('schedule.trashed', ['schedules' => $schedules]);
    }

    public function restore($id)
    {
        Schedule::withTrashed($id)
            ->restore();

        return redirect()->back()->with(['success' => true, 'action' => 'restore']);
    }

    public function delete($id)
    {
        $schedule = Schedule::onlyTrashed()->findOrFail($id);
        $schedule->forceDelete();

        return redirect()->back()->with(['success' => true, 'action' => 'delete']);
    }
}

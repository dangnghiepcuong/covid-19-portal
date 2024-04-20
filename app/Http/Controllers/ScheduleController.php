<?php

namespace App\Http\Controllers;

use App\Enums\ActionStatus;
use App\Enums\RegistrationStatus;
use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schedules = Auth::user()->business->schedules()->isAvailable();
        $vaccines = Vaccine::isAllow()->get();

        if ($request->from_date !== null) {
            $schedules = $schedules->whereDate('on_date', '>=', $request->from_date);
        }

        if ($request->to_date !== null) {
            $schedules = $schedules->whereDate('on_date', '<=', $request->to_date);
        }

        if ($request->vaccine_id !== null) {
            $schedules = $schedules->whereRelation('vaccineLot', 'vaccine_id', $request->vaccine_id);
        }

        $schedules = $schedules->orderBy('on_date', 'desc')
            ->paginate(config('parameters.DEFAULT_PAGINATING_NUMBER'));

        return view('schedule.index', [
            'schedules' => $schedules,
            'vaccines' => $vaccines,
            'attributes' => $request,
        ]);
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
            $business = Auth::user()->business;
            $vaccineLot = $business->vaccineLots()->findOrFail($request->vaccine_lot_id);

            $vaccineLot->quantity = $vaccineLot->quantity
                - ($request->day_shift_limit
                    + $request->noon_shift_limit
                    + $request->night_shift_limit);

            if ($vaccineLot->quantity < 0) {
                DB::rollBack();

                return redirect()->back()->with([
                    'status' => ActionStatus::WARNING,
                    'message' => __('schedule.total_limit'),
                ])->withInput();
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
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'status' => ActionStatus::ERROR,
                'message' => __('message.failed'),
                // 'message' => $e->getMessage(),
            ])->withInput();
        }

        DB::commit();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __(
                'message.success',
                [
                    'action' => __('btn.create', [
                        'object' => __('schedule.schedule'),
                    ]),
                ],
            ),
        ]);
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
            $business = Auth::user()->business;
            $schedule = $business->schedules()->findOrFail($id);

            $vaccineLot = $business->vaccineLots()->findOrFail($schedule->vaccine_lot_id);
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

                return redirect()->back()->with([
                    'status' => ActionStatus::WARNING,
                    'message' => __('schedule.over_limit'),
                ])->withInput();
            }

            $vaccineLot = $business->vaccineLots()->findOrFail($request->vaccine_lot_id);
            $vaccineLot->quantity = $vaccineLot->quantity
                - ($request->day_shift_limit
                    + $request->noon_shift_limit
                    + $request->night_shift_limit);

            if ($vaccineLot->quantity < 0) {
                DB::rollBack();

                return redirect()->back()->with([
                    'status' => ActionStatus::WARNING,
                    'message' => __('schedule.total_limit'),
                ])->withInput();
            }

            $vaccineLot->save();
            $schedule->vaccine_lot_id = $request->vaccine_lot_id;
            $schedule->on_date = $request->on_date;
            $schedule->day_shift_limit = $request->day_shift_limit;
            $schedule->noon_shift_limit = $request->noon_shift_limit;
            $schedule->night_shift_limit = $request->night_shift_limit;
            $schedule->save();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'status' => ActionStatus::ERROR,
                'message' => __('message.failed'),
                // 'message' => $e->getMessage(),
            ])->withInput();
        }

        DB::commit();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __(
                'message.success',
                [
                    'action' => __('btn.update', [
                        'object' => __('schedule.schedule'),
                    ]),
                ],
            ),
        ]);
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
            $business = Auth::user()->business;
            $schedule = $business->schedules()->findOrFail($id);

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

            $business->schedules()->findOrFail($id)->delete();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'status' => ActionStatus::ERROR,
                'message' => __('message.failed'),
                // 'message' => $e->getMessage(),
            ])->withInput();
        }

        DB::commit();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.delete')]),
        ]);
    }

    public function trashed(Request $request)
    {
        $business = Auth::user()->business;
        $schedules = $business->schedules()->onlyTrashed();
        $vaccines = Vaccine::isAllow()->get();

        if ($request->from_date !== null) {
            $schedules = $schedules->whereDate('on_date', '>=', $request->from_date);
        }

        if ($request->to_date !== null) {
            $schedules = $schedules->whereDate('on_date', '<=', $request->to_date);
        }

        if ($request->vaccine_id !== null) {
            $schedules = $schedules->whereRelation('vaccineLot', 'vaccine_id', $request->vaccine_id);
        }

        $schedules = $schedules->orderBy('on_date', 'desc')
            ->paginate(config('parameters.DEFAULT_PAGINATING_NUMBER'));

        return view('schedule.trashed', [
            'schedules' => $schedules,
            'vaccines' => $vaccines,
            'attributes' => $request,
        ]);
    }

    public function restore($id)
    {
        $business = Auth::user()->business;
        $business->schedules()->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.restore')]),
        ]);
    }

    public function delete($id)
    {
        $schedule = Schedule::onlyTrashed()->findOrFail($id);
        $schedule->forceDelete();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', ['action' => __('btn.delete')]),
        ]);
    }
}

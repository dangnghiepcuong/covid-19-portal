<?php

namespace App\Http\Controllers;

use App\Enums\ActionStatus;
use App\Enums\RegistrationStatus;
use App\Enums\RegistrationStatusRule;
use App\Http\Requests\UpdateRegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleRegsitrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    protected function checkStatus($currentStatus, $status)
    {
        // if the updating status is exist in the current status valid value array
        // then the updating status is valid!
        if (in_array($status, RegistrationStatusRule::statusRule($currentStatus))) {
            return [
                'check' => true,
                'message' => __('message.success'),
            ];
        }

        // else it's invalid
        return [
            'check' => false,
            'message' => __('registation.message.action_not_allow'),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegistrationRequest $request, $id)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            // Retrieve model schedule
            $schedule = Auth::user()->business->schedules()->findOrFail($request->schedule_id);

            // If today is not the on_date of schedule,
            // then business is not allow to update registrations
            if (strtotime('now') < strtotime($schedule->on_date)) {
                DB::rollBack();

                return redirect()->back()->with([
                    'status' => ActionStatus::WARNING,
                    'message' => __('registration.message.action_not_allowed_at_the_momment'),
                ], 200);
            }

            // Retrieve user's registration record.
            $registration = $schedule->users()->wherePivot('id', $id)->first();

            // Check if the updating status is valid from the current status
            $checkStatus = $this->checkStatus($registration->pivot->status, $request->status);
            if ($checkStatus['check'] === false) {
                DB::rollBack();

                return redirect()->back()->with([
                    'status' => ActionStatus::WARNING,
                    'message' => $checkStatus['message'],
                ], 200);
            }

            // If the updating status is canceled,
            // then decrease the schedule registration number
            if ($request->status === RegistrationStatus::CANCELED) {
                $dec = $schedule->decreaseRegistration($registration->pivot->shift);
                if ($dec === false) {
                    return redirect()->back()->with([
                        'status' => ActionStatus::ERROR,
                        'message' => __('vaccination.message.invalid_shift'),
                    ], 200);
                }
            }

            // Update the registration status of the user
            $registration->pivot->status = $request->status;
            $registration->pivot->save();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with([
                'status' => ActionStatus::ERROR,
                'message' => __('message.failed'),
            ]);
        }

        DB::commit();

        return redirect()->back()->with([
            'status' => ActionStatus::SUCCESS,
            'message' => __('message.success', [
                'action' => __('btn.update', ['object' => __('registration.status.status')]),
            ]),
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
        //
    }
}

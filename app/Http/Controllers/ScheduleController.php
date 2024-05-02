<?php

namespace App\Http\Controllers;

use App\Enums\ActionStatus;
use App\Http\Requests\ScheduleRequest;
use App\Models\Vaccine;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    protected $scheduleRepo;

    public function __construct(ScheduleRepositoryInterface $scheduleRepo)
    {
        $this->scheduleRepo = $scheduleRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $account = Auth::user();
        $businessId = $account->business->id;
        $schedules = $this->scheduleRepo->getSchedulesOfABusiness(
            $businessId,
            $request->from_date,
            $request->to_date,
            $request->vaccine_id,
            $request->time
        );
        $vaccines = Vaccine::isAllow()->get();

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

        $result = $this->scheduleRepo->storeSchedule(
            Auth::user()->business->id,
            $request->vaccine_lot_id,
            $request->on_date,
            $request->day_shift_limit,
            $request->noon_shift_limit,
            $request->night_shift_limit
        );

        switch ($result['status']) {
            case ActionStatus::WARNING:
            case ActionStatus::ERROR:
                return redirect()->back()->with($result)->withInput();
            case ActionStatus::SUCCESS:
                return redirect()->back()->with($result);
            default:
                return redirect()->back()->with([
                    'status' => ActionStatus::ERROR,
                    'message' => __('message.failed'),
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $registrations = $this->scheduleRepo->getRegistrations(
            Auth::user()->business->id,
            $id,
            $request->shift,
            $request->status
        );

        return view('schedule.registration.index', [
            'schedule' => $this->scheduleRepo->findOrFail($id),
            'registrations' => $registrations,
            'attributes' => $request,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = $this->scheduleRepo->findOrFail($id);
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

        $result = $this->scheduleRepo->updateSchedule(
            Auth::user()->business->id,
            $id,
            $request->vaccine_lot_id,
            $request->on_date,
            $request->day_shift_limit,
            $request->noon_shift_limit,
            $request->night_shift_limit
        );

        switch ($result['status']) {
            case ActionStatus::WARNING:
            case ActionStatus::ERROR:
                return redirect()->back()->with($result)->withInput();
            case ActionStatus::SUCCESS:
                return redirect()->back()->with($result);
            default:
                return redirect()->back()->with([
                    'status' => ActionStatus::ERROR,
                    'message' => __('message.failed'),
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->scheduleRepo->destroySchedule(Auth::user()->business->id, $id);

        switch ($result['status']) {
            case ActionStatus::WARNING:
            case ActionStatus::ERROR:
                return redirect()->back()->with($result)->withInput();
            case ActionStatus::SUCCESS:
                return redirect()->back()->with($result);
            default:
                return redirect()->back()->with([
                    'status' => ActionStatus::ERROR,
                    'message' => __('message.failed'),
                ]);
        }
    }

    public function trashed(Request $request)
    {
        $schedules = $this->scheduleRepo->getTrashed(
            Auth::user()->business->id,
            $request->from_date,
            $request->to_date,
            $request->vaccine_id
        );
        $vaccines = Vaccine::isAllow()->get();

        return view('schedule.trashed', [
            'schedules' => $schedules,
            'vaccines' => $vaccines,
            'attributes' => $request,
        ]);
    }

    public function restore($id)
    {
        return redirect()->back()->with($this->scheduleRepo->restore(
            Auth::user()->business->id,
            $id
        ));
    }

    public function delete($id)
    {
        return redirect()->back()->with($this->scheduleRepo->forceDelete(
            Auth::user()->business->id,
            $id
        ));
    }
}

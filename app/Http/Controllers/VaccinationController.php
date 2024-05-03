<?php

namespace App\Http\Controllers;

use App\Enums\ActionStatus;
use App\Enums\RegistrationStatus;
use App\Enums\Shift;
use App\Http\Requests\BusinessSearchRequest;
use App\Http\Requests\VaccinationRequest;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Vaccine;
use App\Notifications\VaccinationRegistered as VaccinationRegisteredNoti;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class VaccinationController extends Controller
{
    public function index(BusinessSearchRequest $request)
    {
        $request->validated();
        $vaccines = Vaccine::isAllow()->get();

        return view('vaccination.index', [
            'vaccines' => $vaccines,
        ]);
    }

    protected function checkSchedule(VaccinationRequest $request, Schedule $schedule)
    {
        switch ($request->shift) {
            case Shift::DAY_SHIFT:
                if ($schedule->day_shift_registration >= $schedule->day_shift_limit) {
                    return [
                        'check' => false,
                        'message' => __('vaccination.message.full_slot'),
                    ];
                }

                break;
            case Shift::NOON_SHIFT:
                if ($schedule->noon_shift_registration >= $schedule->night_shift_limit) {
                    return [
                        'check' => false,
                        'message' => __('vaccination.message.full_slot'),
                    ];
                }

                break;
            case Shift::NIGHT_SHIFT:
                if ($schedule->night_shift_registration >= $schedule->night_shift_limit) {
                    return [
                        'check' => false,
                        'message' => __('vaccination.message.full_slot'),
                    ];
                }

                break;
            default:
                return [
                    'check' => false,
                    'message' => __('vaccination.message.invalid_shift'),
                ];
        }

        return [
            'check' => true,
            'message' => __('message.success'),
        ];
    }

    protected function checkRegistrationLog(?Registration $registration)
    {
        // If this is not the first time of registering
        if ($registration !== null) {
            // If the last registration has not been done yet (REGISTERED or CHECKED_IN)
            if (
                $registration->status === RegistrationStatus::REGISTERED
                || $registration->status === RegistrationStatus::CHECKED_IN
            ) {
                return [
                    'check' => false,
                    'message' => __('vaccination.message.must_complete'),
                ];
            }

            // If the last registration has been done then check the time of that vaccination
            if ($registration->status === RegistrationStatus::SHOT) {
                $diffDays = date_diff(date_create($registration->updated_at), date_create(date('Y-m-d')))->format('%a');
                // If it's less than 2 months, then not allow for this registering
                if ($diffDays < 28) {
                    return [
                        'check' => false,
                        'message' => __('vaccination.message.vaccinated_recently', ['days' => $diffDays]),
                    ];
                }
            }
        }

        return [
            'check' => true,
            'message' => __('message.success'),
        ];
    }

    public function register(VaccinationRequest $request)
    {
        DB::beginTransaction();
        try {
            // Check if the registering shift on schedule was full of slots => return
            $schedule = Schedule::findOrFail($request->schedule_id);
            $checkSchedule = $this->checkSchedule($request, $schedule);

            if ($checkSchedule['check'] === false) {
                DB::rollBack();

                return response()->json(['status' => 'warning', 'message' => $checkSchedule['message']], 200);
            }

            // Retrieve user
            $account = $request->user();
            $user = User::where('account_id', $account->id)->first();

            // Retrieve last registration for checking some conditions
            $lastReg = Registration::where('user_id', $user->id)
                ->orderBy('updated_at', 'DESC')->first();
            $checkRegistration = $this->checkRegistrationLog($lastReg);

            if ($checkRegistration['check'] === false) {
                DB::rollBack();

                return response()->json(['status' => 'warning', 'message' => $checkRegistration['message']], 200);
            }

            // Else (the first time of registering vaccination) => allow registering
            // attach user-schedule through pivot table registrations,
            // then update schedule's number of registration base on registered shift

            switch ($request->shift) {
                case Shift::DAY_SHIFT:
                    $numberOrder = $schedule->day_shift_registration + 1;
                    $schedule->day_shift_registration++;

                    break;
                case Shift::NOON_SHIFT:
                    $numberOrder = $schedule->noon_shift_registration + 1;
                    $schedule->noon_shift_registration++;

                    break;
                case Shift::NIGHT_SHIFT:
                    $numberOrder = $schedule->night_shift_registration + 1;
                    $schedule->night_shift_registration++;

                    break;
                default:
                    $response = [
                        'status' => 'warning',
                        'message' => __('vaccination.message.invalid_shift'),
                    ];

                    return response()->json($response, 200);
            }

            $user->schedules()->attach($schedule->id, [
                'number_order' => $numberOrder,
                'shift' => $request->shift,
                'status' => RegistrationStatus::REGISTERED,
            ]);

            $schedule->save();
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 'failed',
                'message' => __('message.failed'),
            ];

            return response()->json($response, 200);
        }

        DB::commit();

        $options = [
            'cluster' => 'ap1',
            'encrypted' => true,
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger('account.' . $account->id, 'vaccination-registered', [
            'status' => ActionStatus::SUCCESS,
            'title' => __('vaccination.message.registered_successfully'),
            'content' => __('schedule.schedule_info', [
                'on_date' => $schedule->on_date,
                'vaccine' => $schedule->vaccineLot->vaccine->name,
                'vaccine-lot' => $schedule->vaccineLot->lot,
            ]) . '. ' . __('registration.info', [
                'shift' => __('schedule.' . $request->shift),
                'number_order' => $numberOrder,
                'status' => __('registration.status.' . RegistrationStatus::REGISTERED),
            ]),
        ]);

        $account->notify(new VaccinationRegisteredNoti(
            $schedule,
            $numberOrder,
            $request->shift,
            RegistrationStatus::REGISTERED
        ));

        $response = [
            'status' => 'success',
            'message' => __('message.success', ['action' => __('btn.register')]),
        ];

        return response()->json($response, 200);
    }
}

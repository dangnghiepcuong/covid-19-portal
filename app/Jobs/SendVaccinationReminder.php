<?php

namespace App\Jobs;

use App\Enums\RegistrationStatus;
use App\Mail\ScheduleReminder;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVaccinationReminder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $schedules = Schedule::where('on_date', now()->addDay()->toDateString())->get();
        foreach ($schedules as $schedule) {
            $users = $schedule->users()->wherePivot('status', RegistrationStatus::REGISTERED)->get();
            foreach ($users as $user) {
                Mail::to($user->account)->send(new ScheduleReminder(
                    $schedule,
                    $user->pivot->number_order,
                    $user->pivot->shift,
                    $user->pivot->status
                ));
            }
        }
    }
}

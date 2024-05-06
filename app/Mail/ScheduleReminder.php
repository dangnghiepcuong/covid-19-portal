<?php

namespace App\Mail;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleReminder extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $schedule;
    protected $numberOrder;
    protected $shift;
    protected $status;

    public function __construct(Schedule $schedule, $numberOrder, $shift, $status)
    {
        $this->schedule = $schedule;
        $this->numberOrder = $numberOrder;
        $this->shift = $shift;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.schedule-reminder')
            ->subject(__('vaccination.reminder.title'))
            ->with([
                'business_name' => $this->schedule->business->name,
                'schedule' => $this->schedule,
                'numberOrder' => $this->numberOrder,
                'shift' => $this->shift,
                'status' => $this->status,
            ]);
    }
}

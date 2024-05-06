<?php

namespace App\Notifications;

use App\Enums\RegistrationStatus;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccinationRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    public $schedule;
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
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Vaccination Registration Receipt')
            ->view('mail.vaccination-registered', [
                'schedule' => $this->schedule,
                'user' => $notifiable->user,
                'numberOrder' => $this->numberOrder,
                'shift' => $this->shift,
                'status' => $this->status,
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => __('vaccination.message.registered_successfully'),
            'content' => __('schedule.schedule_info', [
                'on_date' => $this->schedule->on_date,
                'vaccine' => $this->schedule->vaccineLot->vaccine->name,
                'vaccine-lot' => $this->schedule->vaccineLot->lot,
            ]) . '. ' . __('registration.info', [
                'shift' => __('schedule.' . $this->shift),
                'number_order' => $this->numberOrder,
                'status' => __('registration.status.' . RegistrationStatus::REGISTERED),
            ]),
        ];
    }
}

<h3>{{ __('vaccination.reminder.title') }}</h3>
<div>
    {{ __('vaccination.reminder.message') }}
</div>
<div>
    {{ __('business.business') .
        ': ' .
        __('business.info', [
            'name' => $schedule->business->name,
            'addr_province' => $schedule->business->addr_province_name,
            'addr_district' => $schedule->business->addr_district_name,
            'addr_ward' => $schedule->business->addr_ward_name,
            'address' => $schedule->business->address,
        ]) }}
</div>
<div>
    {{ __('schedule.schedule_info', [
        'on_date' => $schedule->on_date,
        'vaccine' => $schedule->vaccineLot->vaccine->name,
        'vaccine-lot' => $schedule->vaccineLot->lot,
    ]) }}
</div>
<div class="h5">
    {{ __('registration.info', [
        'shift' => __('schedule.' . $shift),
        'number_order' => $numberOrder,
        'status' => __('registration.status.' . $status),
    ]) }}
</div>
<div>
    {{ __('vaccination.reminder.note') }}
</div>

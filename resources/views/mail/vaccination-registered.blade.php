<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/layout.css') }}">
<link rel="stylesheet" href="{{ asset('css/size.css') }}">
<link rel="stylesheet" href="{{ asset('css/color.css') }}">
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<div class="flex justify-center overflow-hidden flex-warp">
    <div class="w-full  mx-2 max-w-30pc">
        <div class="h3">{{ __('registration.receipt') }}</div>
        <div>
            {{ __('vaccination.message.registered_successfully') }}
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
        <div class="h5">
            {{ __('registration.info', [
                'shift' => __('schedule.'.$shift),
                'number_order' => $numberOrder,
                'status' => __('registration.status.'.$status),
            ])}}
        </div>
        <div class="h5">
            {{ __('user.profile') . ': ' }}
        </div>
        <div>
            {{ __('user.full_name') . ': ' . $user->fullName }}
        </div>
        <div>
            {{ __('user.pid') . ': ' . $user->pid }}
        </div>
        <div>
            {{ __('user.birthday') . ': ' . $user->birthday }}
        </div>
        <div>
            {{ __('user.gender') . ': ' . $user->gender }}
        </div>
        <div>
            {{ __('user.address') .
                ': ' .
                __('user.location', [
                    'address' => $user->address,
                    'addr_ward' => $user->addr_ward_name,
                    'addr_district' => $user->addr_district_name,
                    'addr_province' => $user->addr_province_name,
                ]) }}
        </div>
        <div>
            {{ __('user.contact') . ':' . $user->contact }}
        </div>
    </div>
</div>
<script src="{{ asset('js/getLocalRegion.js') }}" defer></script>

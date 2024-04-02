<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('btn.view') . ' ' . __('business.business') }}
        </h2>
    </x-slot>
    <div class="flex justify-between overflow-hidden flex-warp flex-h-full">
        <div class="w-full mx-2 max-w-30pc">
            <!-- Profile -->
            <h3 class="font-med text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('business.business') }}</h3>
            <div class="flex justify-between overflow-hidden flex-warp">
                <div class="w-full mr-2">
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('account.email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$account->email" required />
                    </div>
                    @include('business.partials.profile')
                </div>
            </div>
        </div>

        <div class="w-full mx-2 max-w-65pc">
            <!-- Vaccine -->
            <div class="w-full h-50pc">
                <h3 class="font-med text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('vaccine.vaccine') }}</h3>
                <table class="table-auto w-full min-w-[500px] overflow-x-scroll table table-hover">
                    <tr>
                        <th>#</th>
                        <th>{{ __('vaccine.name') }}</th>
                        <th>{{ __('vaccine.lot') }}</th>
                        <th>{{ __('vaccine.quantity') }}</th>
                        <th>{{ __('vaccine.import_date') }}</th>
                        <th>{{ __('vaccine.expiry_date') }}</th>
                    </tr>
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($vaccineLots as $vaccineLot)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td class="text-center">{{ $vaccineLot->$vaccineLots }}</td>
                        <td class="text-center">{{ $vaccineLot->lot }}</td>
                        <td class="text-center">{{ $vaccineLot->quantity }}</td>
                        <td class="text-center">{{ $vaccineLot->import_date }}</td>
                        <td class="text-center">{{ $vaccineLot->expiry_date }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <div class="h-50pc">
                <h3 class="font-med text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('schedule.schedule') }}</h3>
                <table class="table-auto w-full min-w-[500px] overflow-x-scroll table table-hover">
                    <tr>
                        <th>#</th>
                        <th>{{ __('schedule.on_date') }}</th>
                        <th>{{ __('vaccine.name') }}</th>
                        <th>{{ __('vaccine.lot') }}</th>
                        <th>{{ __('schedule.day_shift_limit') . '/' . __('schedule.day_shift_registration') }}</th>
                        <th>{{ __('schedule.noon_shift_limit') . '/' . __('schedule.noon_shift_registration') }}</th>
                        <th>{{ __('schedule.night_shift_limit') . '/' . __('schedule.night_shift_registration') }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/getLocalRegion.js') }}" defer></script>

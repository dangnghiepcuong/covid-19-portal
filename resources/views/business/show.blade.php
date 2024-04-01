<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('btn.view') . ' ' . __('business.business') }}
        </h2>
    </x-slot>
    <div class="flex justify-between overflow-hidden" style="flex-wrap: wrap; flex-direction: row; height: calc(100vh - 100px);">
        <div class="w-full mx-2" style="max-width: 30%; min-width: 380px">
            <h3 class="font-med text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('business.business') }}</h3>
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('register.email')" />
                <input id="email" type="email" class="block mt-1 w-full" name="email" value="{{ $account->email }}" disabled>
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-label for="business_name" :value="__('business.name')" />
                <input id="business_name" type="text" class="block mt-1 w-full" name="business_name" value="{{ $business->name }}" disabled>
            </div>

            <!-- Tax ID -->
            <div class="mt-4">
                <x-label for="tax_id" :value="__('business.tax_id')" />
                <input id="tax_id" type="text" class="block mt-1 w-full" name="tax_id" value="{{ $business->tax_id }}" disabled>
            </div>

            <div class="flex items-center justify-between mt-4 overflow-hidden" style="flex-wrap: wrap; flex-direction: row;">
                <!-- Province Name -->
                <div class="w-full" style="max-width: 30%;">
                    <x-label for="addr_province" :value="__('register.province')" />
                    <input id="addr_province" type="text" class="block mt-1 w-full" name="addr_province" value="{{ $business->addr_province }}" disabled>
                </div>

                <!-- District Name -->
                <div class="w-full" style="max-width: 30%;">
                    <x-label for="addr_district" :value="__('register.district')" />
                    <input id="addr_district" type="text" class="block mt-1 w-full" name="addr_district" value="{{ $business->addr_district }}" disabled>
                </div>

                <!-- Ward Name -->
                <div class="w-full" style="max-width: 30%;">
                    <x-label for="addr_ward" :value="__('register.ward')" />
                    <input id="addr_ward" type="text" class="block mt-1 w-full" name="addr_ward" value="{{ $business->addr_ward }}" disabled>
                </div>
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-label for="address" :value="__('register.address')" />
                <input id="address" type="text" class="block mt-1 w-full" name="address" value="{{ $business->address }}" disabled>
            </div>

            <!-- Contact -->
            <div class="mt-4">
                <x-label for="contact" :value="__('register.contact')" />
                <input id="contact" type="text" class="block mt-1 w-full" name="contact" value="{{ $business->contact }}" disabled>
            </div>
        </div>

        <div class="w-full mx-2" style="max-width: 65%; min-width: 380px; height: 100%">
            <!-- Vaccine -->
            <div class="w-full" style="height: 50%;">
                <h3 class="font-med text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('vaccine.vaccine') }}</h3>
                <a class="btn btn-secondary my-3" href="#">{{ __('btn.import', ['object' => __('vaccine.vaccine')]) }}</a>
                <table class="table-auto w-full min-w-[500px] overflow-x-scroll" style="border-style: solid; border-width: 2px">
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
                    @foreach ($vaccine_lots as $vaccine_lot)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td style="text-align: center">{{ $vaccine_lot->vaccine_lots }}</td>
                        <td style="text-align: center">{{ $vaccine_lot->lot }}</td>
                        <td style="text-align: center">{{ $vaccine_lots->quantity }}</td>
                        <td style="text-align: center">{{ date_format($vaccine_lot->import_date, 'Y-m-d') }}</td>
                        <td style="text-align: center">{{ date_format($vaccine_lot->expiry_date, 'Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div style="height: 50%;">
                <h3 class="font-med text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('schedule.schedule') }}</h3>
                <table class="table-auto w-full min-w-[500px] overflow-x-scroll" style="border-style: solid; border-width: 2px">
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

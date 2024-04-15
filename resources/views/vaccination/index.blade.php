<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('vaccination.vaccination') }}
        </h2>
    </x-slot>

    <div class="min-w-800px flex justify-center overflow-hidden flex-warp flex-gap-50px">
        <!-- BUSINESSES LIST -->
        <div class="min-w400px max-w-full">
            <!-- FILTER -->
            <div>
                {{ __('component.filter') . ' ' . __('business.business') }}
            </div>
            <div class="min-w-200px flex items-end justify-left overflow-hidden flex-warp flex-gap-10px">
                <!-- Province Name -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="addr_province" :value="__('user.province')" />
                    <select name="addr_province" id="addr_province" class="block mt-1 w-full">
                    </select>
                </div>

                <!-- District Name -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="addr_district" :value="__('user.district')" />
                    <select name="addr_district" id="addr_district" class="block mt-1 w-full">
                    </select>
                </div>

                <!-- Ward Name -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="addr_ward" :value="__('user.ward')" />
                    <select name="addr_ward" id="addr_ward" class="block mt-1 w-full">
                    </select>
                </div>

                {{-- Apply --}}
                <div>
                    <button id="btn_apply_business_filter" class="btn btn-secondary">
                        {{ __('btn.apply') }}
                    </button>
                </div>
            </div>
            <br><br><br>
            <!-- TABLE -->
            <div class="overflow-x-scroll">
                <table id="table_business_list" class="table table-hover">
                    <thead>
                        <tr class="items-center">
                            <th class="text-center text-truncate">
                                #
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('business.name') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('business.province') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('business.district') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('business.ward') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('schedule.schedule') }}
                            </th>
                            <th class="text-center text-truncate">
                                {{ __('btn.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            {{-- PAGINATING --}}
            <div class="row mt-2 justify-content-between">
                <div class="col-md-auto me-auto ">
                    <div class="dt-info" aria-live="polite" id="table_business_list_info" role="status"></div>
                </div>
                <div class="col-md-auto ms-auto">
                    <div class="dt-paging paging_full_numbers">
                        <input id="paginating_current_addr_province" type="hidden" />
                        <input id="paginating_current_addr_district" type="hidden" />
                        <input id="paginating_current_addr_ward" type="hidden" />
                        <ul id="table_business_list_paginating" class="pagination">
                            <li class="dt-paging-button page-item"><a class="page-link first"
                                    aria-controls="table_business_list" aria-label="First" data-dt-idx="first"
                                    tabindex="-1">«</a></li>
                            <li class="dt-paging-button page-item"><a class="page-link previous"
                                    aria-controls="table_business_list" aria-label="Previous" data-dt-idx="previous"
                                    tabindex="-1">‹</a></li>
                            <li class="dt-paging-button page-item"><a class="page-link next"
                                    aria-controls="table_business_list" aria-label="Next" data-dt-idx="next"
                                    tabindex="-1">›</a></li>
                            <li class="dt-paging-button page-item"><a class="page-link last"
                                    aria-controls="table_business_list" aria-label="Last" data-dt-idx="last"
                                    tabindex="-1">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- SCHEDULES LIST -->
        <div class="min-w400px max-w-full">
            <!-- FILTER -->
            <div>
                {{ __('component.filter') . ' ' . __('schedule.schedule') }}
            </div>
            <div class="min-w-200px flex items-end justify-left overflow-hidden flex-warp flex-gap-10px">
                <!-- From date -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="from_date" :value="__('schedule.from_date')" />
                    <x-input id="from_date" class="block mt-1 w-full" type="date" name="from_date" />
                </div>

                <!-- To date -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="to_date" :value="__('schedule.to_date')" />
                    <x-input id="to_date" class="block mt-1 w-full" type="date" name="to_date" />
                </div>

                <!-- Vaccine name -->
                <div class="min-w-150px max-w-30pc">
                    <x-label for="vaccine_id" :value="__('vaccine.vaccine')" />
                    <select name="vaccine_id" id="vaccine_id" class="block mt-1 w-full">
                        <option value=""></option>
                        @foreach ($vaccines as $vaccine)
                            <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <button id="btn_apply_filter" class="btn btn-secondary mt-2">
                    {{ __('btn.apply') }}
                </button>
            </div>
            <br>
            <!-- TABLE -->
            <table id="table_schedule_list" class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">{{ __('schedule.on_date') }}</th>
                        <th class="text-center">{{ __('vaccine.name') }}</th>
                        <th class="text-center">{{ __('vaccine-lot.vaccine_lot') }}</th>
                        <th class="text-center">{{ __('schedule.day_shift') }}</th>
                        <th class="text-center">{{ __('schedule.noon_shift') }}</th>
                        <th class="text-center">{{ __('schedule.night_shift') }}</th>
                        <th class="text-center">{{ __('btn.action') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @if (Session::get('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ __('message.success', ['action' => __('btn.delete')]) }}</li>
            </ul>
        </div>
    @endif
</x-app-layout>
<script>
    window.lang = {!! '"' . ($lang === null ? 'en' : $lang) . '"' !!}
    window.translations = {!! $translation !!}
</script>
<script src="{{ asset('js/getLocalRegion.js') }}" defer></script>
<script src="{{ asset('js/getBusinessList.js') }}" defer></script>

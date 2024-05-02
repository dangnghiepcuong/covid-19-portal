<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('btn.create', ['object' => __('schedule.schedule')]) }}
        </h2>
    </x-slot>

    <div class="w-full">
        <div class="min-w-300px max-w-600px mx-auto">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('schedules.store') }}">
                @csrf
                <!-- on_date -->
                <div class="mt-4">
                    <x-label for="on_date" :value="__('schedule.on_date')" />
                    <x-input id="on_date" class="block mt-1 w-full" type="date" name="on_date" :value="old('on_date') !== null ? old('on_date') : date('Y-m-d')" />
                </div>

                <!-- vaccine_lot -->
                <div class="mt-4">
                    <x-label for="name" :value="__('vaccine-lot.vaccine_lot')" />
                    <select name="vaccine_lot_id" id="vaccine_lot_id" class="w-full">
                        @if (old('vaccine_lot_id') !== null)
                            @foreach ($vaccineLots as $vaccineLot)
                                @if ($vaccineLot->id == old('vaccine_lot_id'))
                                    <option value="{{ $vaccineLot->id }}">
                                        {{ $vaccineLot->vaccine->name .
                                            ' (' .
                                            $vaccineLot->lot .
                                            ', ' .
                                            __('vaccine-lot.quantity') .
                                            ': ' .
                                            $vaccineLot->quantity .
                                            ', ' .
                                            __('vaccine-lot.expiry_date') .
                                            ': ' .
                                            $vaccineLot->expiry_date .
                                            ')' }}
                                    </option>
                                @endif
                            @endforeach
                        @endif
                        @foreach ($vaccineLots as $vaccineLot)
                            @if ($vaccineLot->id != old('vaccine_lot_id'))
                                <option value="{{ $vaccineLot->id }}">
                                    {{ $vaccineLot->vaccine->name .
                                        ' (' .
                                        $vaccineLot->lot .
                                        ', ' .
                                        __('vaccine-lot.quantity') .
                                        ': ' .
                                        $vaccineLot->quantity .
                                        ', ' .
                                        __('vaccine-lot.expiry_date') .
                                        ': ' .
                                        $vaccineLot->expiry_date .
                                        ')' }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- day_shift_limit -->
                <div class="mt-4">
                    <x-label for="day_shift_limit" :value="__('schedule.day_shift_limit')" />
                    <x-input id="day_shift_limit" class="block mt-1 w-full" type="number" name="day_shift_limit"
                        :value="old('day_shift_limit') !== null ? old('day_shift_limit') : 0" />
                </div>

                <!-- noon_shift_limit -->
                <div class="mt-4">
                    <x-label for="noon_shift_limit" :value="__('schedule.noon_shift_limit')" />
                    <x-input id="noon_shift_limit" class="block mt-1 w-full" type="number" name="noon_shift_limit"
                        :value="old('noon_shift_limit') !== null ? old('noon_shift_limit') : 0" />
                </div>

                <!-- night_shift_limit -->
                <div class="mt-4">
                    <x-label for="night_shift_limit" :value="__('schedule.night_shift_limit')" />
                    <x-input id="night_shift_limit" class="block mt-1 w-full" type="number" name="night_shift_limit"
                        :value="old('night_shift_limit') !== null ? old('night_shift_limit') : 0" />
                </div>

                <br>
                <div class="flex justify-center">
                    <!-- Submit -->
                    <x-button id="btn-create" name="btn-create" class="ml-4">
                        {{ __('btn.create', ['object' => __('schedule.schedule')]) }}
                    </x-button>
                </div>
            </form>

            <br>

            @switch (Session::get('status'))
                @case ($actionStatuses::WARNING)
                    <div class="alert alert-warning">
                        <ul>
                            <li>{{ Session::get('message') }}</li>
                        </ul>
                    </div>
                @break

                @case ($actionStatuses::ERROR)
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ Session::get('message') }}</li>
                        </ul>
                    </div>
                @break

                @case ($actionStatuses::SUCCESS)
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ Session::get('message') }}</li>
                        </ul>
                    </div>
                @break
            @endswitch
        </div>
    </div>
</x-app-layout>

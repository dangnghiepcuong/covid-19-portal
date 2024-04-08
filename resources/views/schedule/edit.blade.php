<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('btn.edit', ['object' => __('schedule.schedule')]) }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <div class="flex justify-center">
        <form method="POST" action="{{ route('schedules.update', $schedule->id) }}" class="w-full max-w-50pc">
            @csrf
            @method('patch')
            <!-- on_date -->
            <div class="mt-4">
                <x-label for="on_date" :value="__('schedule.on_date')" />
                <x-input id="on_date" class="block mt-1 w-full" type="date" name="on_date" :value="$schedule->on_date" />
            </div>

            <!-- vaccine_lot -->
            <div class="mt-4">
                <x-label for="name" :value="__('vaccine-lot.vaccine_lot')" />
                <select name="vaccine_lot_id" id="vaccine_lot_id" class="w-full">
                    <option value="{{ $schedule->vaccineLot->id }}">
                        {{ $schedule->vaccineLot->vaccine->name . ' (' . $schedule->vaccineLot->lot . ', ' 
                            . __('vaccine-lot.quantity') . ': ' . $schedule->vaccineLot->quantity . ', '
                            . __('vaccine-lot.expiry_date') . ': ' . $schedule->vaccineLot->expiry_date . ')' }}
                    </option>
                    @foreach($vaccineLots as $vaccineLot)
                        @if ($vaccineLot->id !== $schedule->vaccineLot->id)
                            <option value="{{ $vaccineLot->id }}">
                                {{ $vaccineLot->vaccine->name . ' (' . $vaccineLot->lot . ', '
                                            . __('vaccine-lot.quantity') . ': ' . $vaccineLot->quantity . ', '
                                            . __('vaccine-lot.expiry_date') . ': ' . $vaccineLot->expiry_date . ')' }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <!-- day_shift_limit -->
            <div class="mt-4">
                <x-label for="day_shift_limit" :value="__('schedule.day_shift_limit') . ' (' . $schedule->day_shift_registration . ' registered)'" />
                <x-input id="day_shift_limit" class="block mt-1 w-full" type="number" name="day_shift_limit" :value="$schedule->day_shift_limit" />
            </div>

            <!-- noon_shift_limit -->
            <div class="mt-4">
                <x-label for="noon_shift_limit" :value="__('schedule.noon_shift_limit') . ' (' . $schedule->noon_shift_registration . ' registered)'" />
                <x-input id="noon_shift_limit" class="block mt-1 w-full" type="number" name="noon_shift_limit" :value="$schedule->noon_shift_limit" />
            </div>

            <!-- night_shift_limit -->
            <div class="mt-4">
                <x-label for="night_shift_limit" :value="__('schedule.night_shift_limit') . ' (' . $schedule->night_shift_registration . ' registered)'" />
                <x-input id="night_shift_limit" class="block mt-1 w-full" type="number" name="night_shift_limit" :value="$schedule->night_shift_limit" />
            </div>

            <br>
            <div class="flex justify-center">
                <!-- Submit -->
                <x-button class="ml-4">
                    {{ __('btn.update', ['object' => __('schedule.schedule')]) }}
                </x-button>
            </div>

            @if (Session::get('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ __('message.success', ['action' => __('btn.update', ['object' => __('schedule.schedule')])]) }}</li>
                    </ul>
                </div>
            @endif
        </form>
    </div>
</x-app-layout>

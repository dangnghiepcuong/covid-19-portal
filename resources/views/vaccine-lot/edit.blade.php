<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('btn.edit', ['object' => __('vaccine-lot.vaccine_lot')]) }}
        </h2>
    </x-slot>

    <div class="w-full">
        <div class="mx-auto min-w-300px max-w-400px mx-auto">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('vaccine-lots.update', $vaccineLot->id) }}">
                @csrf
                @method('patch')
                <!-- Vaccine name -->
                <div class="mt-4">
                    <x-label for="vaccine_id" :value="__('vaccine.vaccine')" />
                    <select name="vaccine_id" id="vaccine_id" class="w-full">
                        <option value="{{ $vaccineLot->vaccine->id }}">{{ $vaccineLot->vaccine->name }}</option>
                    </select>
                </div>

                <!-- lot -->
                <div class="mt-4">
                    <x-label for="lot" :value="__('vaccine-lot.lot')" />
                    <x-input id="lot" class="block mt-1 w-full" type="text" name="lot" :value="$vaccineLot->lot" />
                </div>

                <!-- quantity -->
                <div class="mt-4">
                    <x-label for="quantity" :value="__('vaccine-lot.quantity')" />
                    <x-input id="quantity" class="block mt-1 w-full" type="number" name="quantity"
                        :value="$vaccineLot->quantity" />
                </div>

                <!-- import_date -->
                <div class="mt-4">
                    <x-label for="import_date" :value="__('vaccine-lot.import_date')" />
                    <x-input id="import_date" class="block mt-1 w-full" type="date" name="import_date"
                        :value="$vaccineLot->import_date" />
                </div>

                <!-- dte -->
                <div class="mt-4">
                    <x-label for="dte" :value="__('vaccine-lot.dte') . ' (' . $vaccineLot->expiry_date . ')'" />
                    <x-input id="dte" class="block mt-1 w-full" type="number" name="dte" :value="$vaccineLot->dte" />
                </div>

                <br>
                <div class="flex justify-center">
                    <!-- Submit -->
                    <x-button class="ml-4">
                        {{ __('btn.update', ['object' => __('vaccine-lot.vaccine_lot')]) }}
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

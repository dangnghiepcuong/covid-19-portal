<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('btn.create', ['object' => __('vaccine-lot.vaccine')]) }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <div class="flex justify-center">
        <form method="POST" action="{{ route('vaccine-lots.store') }}" class="max-w-80pc">
            @csrf
            <!-- Vaccine name -->
            <div class="mt-4">
                <x-label for="name" :value="__('vaccine-lot.vaccine')" />
                <select name="vaccine_id" id="vaccine_id" class="w-full">
                    @foreach($vaccines as $vaccine)
                        <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                    @endforeach
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
                <x-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="$vaccineLot->quantity" />
            </div>

            <!-- import_date -->
            <div class="mt-4">
                <x-label for="import_date" :value="__('vaccine-lot.import_date')" />
                <x-input id="import_date" class="block mt-1 w-full" type="date" name="import_date" :value="$vaccineLot->import_date" />
            </div>

            <!-- dte -->
            <div class="mt-4">
                <x-label for="dte" :value="__('vaccine-lot.dte')" />
                <x-input id="dte" class="block mt-1 w-full" type="number" name="dte" :value="$vaccineLot->dte" />
            </div>

            <br>
            <div class="flex justify-center">
                <!-- Submit -->
                <x-button class="ml-4">
                    {{ __('btn.import', ['object' => __('vaccine-lot.vaccine_lot')]) }}
                </x-button>
            </div>

            @if (Session::get('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ __('message.success', ['action' => __('btn.import', ['object' => __('vaccine-lot.vaccine_lot')])]) }}</li>
                </ul>
            </div>
            @endif
        </form>
    </div>
</x-app-layout>
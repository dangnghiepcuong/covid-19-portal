<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('btn.create', ['object' => __('vaccine.vaccine')]) }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <div class="flex justify-center">
        <form method="POST" action="{{ route('vaccines.update', $vaccine->id) }}" class="max-w-80pc">
            @csrf
            @method('patch')
            <!-- Vaccine name -->
            <div class="mt-4">
                <x-label for="name" :value="__('vaccine.vaccine')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$vaccine->name" />
            </div>

            <!-- Supplier -->
            <div class="mt-4">
                <x-label for="supplier" :value="__('vaccine.supplier')" />
                <x-input id="supplier" class="block mt-1 w-full" type="text" name="supplier" :value="$vaccine->supplier" />
            </div>

            <!-- technology -->
            <div class="mt-4">
                <x-label for="technology" :value="__('vaccine.technology')" />
                <x-input id="technology" class="block mt-1 w-full" type="text" name="technology" :value="$vaccine->technology" />
            </div>


            <!-- country -->
            <div class="mt-4">
                <x-label for="country" :value="__('vaccine.country')" />
                <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="$vaccine->country" />
            </div>

            <!-- is_allow -->
            <div class="mt-4">
                @php
                $is_allow = $vaccine->is_allow === 'Allowed' ? "checked" : "";
                $not_allow = $vaccine->is_allow === 'Allowed' ? "" : "checked";
                @endphp
                <x-label for="is_allow" :value="__('vaccine.is_allow')" />

                <x-label for="is_allow" :value="__('vaccine.allow')" />
                <input id="is_allow" class="block mt-1" type="radio" name="is_allow" value="1" {{ $is_allow }} />

                <x-label class="mt-2" for="not_allow" :value="__('vaccine.not_allow')" />
                <input id="not_allow" class="block mt-1" type="radio" name="is_allow" value="0" {{ $not_allow }} />
            </div>

            <br>
            <div class="flex justify-center">
                <!-- Submit -->
                <x-button class="ml-4">
                    {{ __('btn.update', ['object' => __('vaccine.vaccine')]) }}
                </x-button>
            </div>

            @if (Session::get('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ __('message.success', ['action' => __('btn.update')]) }}</li>
                </ul>
            </div>
            @endif
        </form>
    </div>
</x-app-layout>
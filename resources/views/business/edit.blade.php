<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('btn.edit', ['object' => __('business.business')]) }}
        </h2>
    </x-slot>

    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="flex justify-center overflow-hidden flex-warp">
            <form method="POST" class="w-full mx-2 max-w-30pc" action="#">
                @csrf
                @method('patch')
                @include('business.partials.account')

                <x-button class="mt-4">
                    {{ __('btn.update') }}
                </x-button>
            </form>

            <form method="POST" class="w-full mx-2 max-w-60pc" action="{{ route('businesses.update', $business->id) }}">
                @csrf
                @method('patch')

                @include('business.partials.profile')

                <x-button class="mt-4">
                    {{ __('btn.update') }}
                </x-button>
            </form>
        </div>
        @if (Session::get('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ __('message.success', ['action' => __('btn.update')]) }}</li>
            </ul>
        </div>
        @endif
    </x-auth-card>

</x-app-layout>
<script src="{{ asset('js/getLocalRegion.js') }}" defer></script>

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
            <div class="w-full  mx-2 max-w-30pc">
                <!-- Change Email -->
                <form method="POST" action="{{ route('accounts.business.update') }}">
                    <div>
                        {{ __('object.change', ['object' => __('account.email')]) }}
                    </div>
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" value="{{ $account->id }}">
                    @include('account.partials.account')

                    <x-button class="mt-4">
                        {{ __('btn.update') }}
                    </x-button>
                </form>

                <!-- Change Password (feature for business role) -->
                @if (Auth::user()->role === $roles::ROLE_BUSINESS)
                <br>
                <form method="POST" action="{{ route('accounts.password.update') }}">
                    <div>
                        {{ __('object.change', ['object' => __('account.password.change')]) }}
                    </div>
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" value="{{ $business->id }}">
                    @include('account.partials.password-change')

                    <x-button class="mt-4">
                        {{ __('btn.update') }}
                    </x-button>
                </form>

                <!-- Reset Business Account Password (feature for admin role) -->
                @else
                <br>
                <form method="POST" action="{{ route('accounts.password.reset') }}">
                    <div>
                        {{ __('object.reset', ['object' => __('account.password.reset')]) }}
                    </div>
                    @csrf
                    @method('patch')

                    @include('account.partials.password-reset')

                    <x-button class="mt-4">
                        {{ __('btn.reset') }}
                    </x-button>
                </form>
                @endif
            </div>

            <form method="POST" class="w-full mx-2 max-w-60pc" action="{{ route('businesses.update', $business->id) }}">
                {{ __('account.profile') }}
                @csrf
                @method('patch')

                @include('business.profile')

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

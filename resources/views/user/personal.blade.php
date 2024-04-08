<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('btn.edit', ['object' => __('user.profile')]) }}
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
                <form method="POST" action="{{ route('accounts.user.update') }}">
                    <div>
                        {{ __('object.change', ['object' => __('account.email')]) }}
                    </div>
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" value="{{ $account->id }}">
                    @include('account.partials.account')

                    <x-button class="mt-4">
                        {{ __('btn.update', ['object' => '']) }}
                    </x-button>
                </form>

                <br>
                <!-- Change Password -->
                <form method="POST" action="{{ route('accounts.password.update') }}">
                    <div>
                        {{ __('object.change', ['object' => __('account.password')]) }}
                    </div>
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    @include('account.partials.password-change')

                    <x-button class="mt-4">
                        {{ __('btn.update', ['object' => '']) }}
                    </x-button>
                </form>
            </div>

            <!-- Profile -->
            <div class="w-full  mx-2 max-w-40pc">
                {{ __('object.change', ['object' => __('user.profile')]) }}
                <form method="POST" action="{{ route('users.update-profile') }}">
                    @csrf
                    @method('patch')
                    @include('user.profile')

                    <x-button class="mt-4">
                        {{ __('btn.update', ['object' => '']) }}
                    </x-button>
                </form>
            </div>
        </div>
        @if (Session::get('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ __('message.success', ['action' => __('btn.update', ['object' => __('user.profile')])]) }}</li>
            </ul>
        </div>
        @endif
    </x-auth-card>
</x-app-layout>
<script src="{{ asset('js/getLocalRegion.js') }}" defer></script>

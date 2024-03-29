<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="flex items-center justify-between overflow-hidden" style="flex-wrap: wrap; flex-direction: row;">
                <div class="w-full mr-2" style="max-width: 33%; min-width: 200px">
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Mật khẩu')" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>


                </div>

                <div class="w-full" style="max-width: 63%; min-width: 380px">
                    <div class="flex items-center justify-center mt-4" style="flex-wrap: wrap; flex-direction: row;">
                        <!-- Last Name -->
                        <div style="width: 65%">
                            <x-label for="last_name" :value="__('Họ và tên đệm')" />
                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
                        </div>

                        <!-- First Name -->
                        <div style="width: 35%">
                            <x-label for="first_name" :value="__('Tên')" />
                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                        </div>
                    </div>

                    <!-- Personal ID -->
                    <div class="mt-4">
                        <x-label for="pid" :value="__('CCCD')" />
                        <x-input id="pid" class="block mt-1 w-full" type="text" name="pid" :value="old('pid')" required autofocus />
                    </div>

                    <!-- Birthday -->
                    <div class="mt-4">
                        <x-label for="birthday" :value="__('Ngày sinh')" />
                        <x-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" required autofocus />
                    </div>

                    <!-- Gender -->
                    <div class="mt-4">
                        <x-label for="gender" :value="__('Giới tính')" />
                        <select name="gender" class="block mt-1 w-full" id="gender">
                            @php
                            $genders = GenderType::allCases();
                            @endphp
                            @foreach ($genders as $properties => $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center justify-between mt-4 overflow-hidden" style="flex-wrap: wrap; flex-direction: row;">
                        <!-- Province Name -->
                        <div class="w-full" style="max-width: 30%;">
                            <x-label for="addr_province" :value="__('Tỉnh/Thành phô')" />
                            <select name="addr_province" id="addr_province" class="block mt-1 w-full">
                            </select>
                        </div>

                        <!-- District Name -->
                        <div class="w-full" style="max-width: 30%;">
                            <x-label for="addr_district" :value="__('Quận/Huyện')" />
                            <select name="addr_district" id="addr_district" class="block mt-1 w-full">
                            </select>
                        </div>

                        <!-- Ward Name -->
                        <div class="w-full" style="max-width: 30%;">
                            <x-label for="addr_ward" :value="__('Xã/Phường/Thị trấn')" />
                            <select name="addr_ward" id="addr_ward" class="block mt-1 w-full">
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-4">
                        <x-label for="address" :value="__('Số nhà, đường')" />
                        <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" autofocus />
                    </div>

                    <!-- Contact -->
                    <div class="mt-4">
                        <x-label for="contact" :value="__('Số điện thoại')" />
                        <x-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact')" autofocus />
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-button class="ml-4">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </x-auth-card>

    <script src="{{ asset('js/getLocalRegion.js') }}" defer></script>
</x-guest-layout>

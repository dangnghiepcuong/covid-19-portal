<div class="flex items-center justify-between overflow-hidden flex-warp">
    <!-- Last Name -->
    <div class="mt-4">
        <x-label for="last_name" :value="__('user.last_name')" />
        <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="$user->last_name" required autofocus />
    </div>

    <!-- First Name -->
    <div class="mt-4">
        <x-label for="first_name" :value="__('user.first_name')" />
        <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="$user->first_name" required autofocus />
    </div>
</div>

<!-- Personal ID -->
<div class="mt-4">
    <x-label for="pid" :value="__('user.pid')" />
    <x-input id="pid" class="block mt-1 w-full" type="text" name="pid" :value="$user->pid" required autofocus />
</div>

<!-- Birthday -->
<div class="mt-4">
    <x-label for="birthday" :value="__('user.birthday')" />
    <x-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="$user->birthday" required autofocus />
</div>

<!-- Gender -->
<div class="mt-4">
    <x-label for="gender" :value="__('user.gender')" />
    <select name="gender" class="block mt-1 w-full" id="gender">
        <option value="{{ $user->gender }}">{{ $user->gender }}</option>
        @foreach ($genders::allCases() as $properties => $value)
            @if ($value !== $user->gender)
                <option value="{{ $value }}">{{ $value }}</option>
            @endif
        @endforeach
    </select>
</div>

<div class="flex items-center justify-between mt-4 overflow-hidden flex-warp">
    <!-- Province Name -->
    <div class="max-w-30pc">
        <x-label for="addr_province" :value="__('user.province')" />
        <select name="addr_province" id="addr_province" class="block mt-1 w-full" value="{{ $user->getAttributes()['addr_province'] }}">
        </select>
    </div>

    <!-- District Name -->
    <div class="max-w-30pc">
        <x-label for="addr_district" :value="__('user.district')" />
        <select name="addr_district" id="addr_district" class="block mt-1 w-full" value="{{ $user->getAttributes()['addr_district'] }}">
        </select>
    </div>

    <!-- Ward Name -->
    <div class="max-w-30pc">
        <x-label for="addr_ward" :value="__('user.ward')" />
        <select name="addr_ward" id="addr_ward" class="block mt-1 w-full" value="{{ $user->getAttributes()['addr_ward'] }}">
        </select>
    </div>
</div>

<!-- Address -->
<div class="mt-4">
    <x-label for="address" :value="__('user.address')" />
    <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="$user->address" autofocus />
</div>

<!-- Contact -->
<div class="mt-4">
    <x-label for="contact" :value="__('user.contact')" />
    <x-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="$user->contact" autofocus />
</div>

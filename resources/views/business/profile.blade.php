<!-- Name -->
<div class="mt-4">
    <x-label class="text-truncate" for="name" :value="__('business.name')" />
    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$business->name" required autofocus />
</div>

<!-- Tax ID -->
<div class="mt-4">
    <x-label class="text-truncate" for="tax_id" :value="__('business.tax_id')" />
    <x-input id="tax_id" class="block mt-1 w-full" type="text" name="tax_id" :value="$business->tax_id" required
        autofocus />
</div>
<div class="min-w-400px flex items-center justify-between mt-4 overflow-hidden flex-warp">
    <!-- Province Name -->
    <div class="max-w-30pc">
        <x-label class="text-truncate" for="addr_province" :value="__('business.province')" />
        <select name="addr_province" id="addr_province" class="block mt-1 w-full"
            value="{{ $business->getAttributes()['addr_province'] }}">
        </select>
    </div>

    <!-- District Name -->
    <div class="max-w-30pc">
        <x-label class="text-truncate" for="addr_district" :value="__('business.district')" />
        <select name="addr_district" id="addr_district" class="block mt-1 w-full"
            value="{{ $business->getAttributes()['addr_district'] }}">
        </select>
    </div>

    <!-- Ward Name -->
    <div class="max-w-30pc">
        <x-label class="text-truncate" for="addr_ward" :value="__('business.ward')" />
        <select name="addr_ward" id="addr_ward" class="block mt-1 w-full"
            value="{{ $business->getAttributes()['addr_ward'] }}">
        </select>
    </div>
</div>

<!-- Address -->
<div class="mt-4">
    <x-label class="text-truncate" for="address" :value="__('business.address')" />
    <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="$business->address" autofocus />
</div>

<!-- Contact -->
<div class="mt-4">
    <x-label class="text-truncate" for="contact" :value="__('business.contact')" />
    <x-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="$business->contact" autofocus />
</div>

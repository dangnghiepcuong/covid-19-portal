<!-- Password -->
<div class="mt-4">
    <x-label for="old_password" :value="__('account.old_password')" />
    <x-input id="old_password" class="block mt-1 w-full" type="password" name="password" required />
</div>

<!-- Password -->
<div class="mt-4">
    <x-label for="password" :value="__('account.new_password')" />
    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-label for="password_confirmation" :value="__('account.confirm_password')" />
    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
</div>

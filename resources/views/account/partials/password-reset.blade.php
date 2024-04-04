<!-- Hidden Account Id -->
<input type="hidden" name="id" value="{{ $account->id }}">

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

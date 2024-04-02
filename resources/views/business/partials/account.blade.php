<!-- Email Address -->
<div class="mt-4">
    <x-label for="email" :value="__('account.email')" />
    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$account->email" required />
</div>

<!-- Password -->
<div class="mt-4">
    <x-label for="password" :value="__('account.password')" />
    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-label for="password_confirmation" :value="__('account.confirm_password')" />
    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
</div>

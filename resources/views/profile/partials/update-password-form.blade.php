<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>


    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mt-3">
            <x-input-label for="current_password" :value="__('Current Password')" class="form-label" />
            <x-text-input id="current_password" name="current_password" type="password"
                class="mt-1 block w-full form-control" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 form-control" />
        </div>

        <div class="mt-3">
            <x-input-label for="password" :value="__('New Password')" class="form-label" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full form-control"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 form-control" />
        </div>

        <div class="mt-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 form-control" />
        </div>

        <div class="flex items-center gap-4 mt-3">
            <x-primary-button class="btn btn-primary mt-2">{{ __('Save') }}</x-primary-button>

        </div>
    </form>
</section>

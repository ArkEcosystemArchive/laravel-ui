<x:ark-fortify::form-wrapper x-show="recovery"
                             action="{{ isset($resetPassword)
                                    ? route('two-factor.reset-password-store', ['token' => $token])
                                    : route('two-factor.login') }}">
    <div class="mb-8">
        @isset($resetPassword)
            <input type="hidden" name="email" value="{{ $email }}"/>
        @endisset

        <div class="flex flex-1">
            <x-ark-password-toggle
                name="recovery_code"
                :label="trans('ui::forms.recovery_code')"
                class="w-full"
                :errors="$errors"
            />
        </div>
    </div>

    <div class="flex flex-col-reverse items-center justify-between sm:flex-row">
        <button @click="recovery = false" type="button" class="w-full mt-4 font-semibold link sm:w-auto sm:mt-0"
                x-cloak>
            @lang('ui::actions.enter_2fa_code')
        </button>

        <button type="submit" class="w-full button-secondary sm:w-auto">
            @lang('ui::actions.sign_in')
        </button>
    </div>
</x:ark-fortify::form-wrapper>

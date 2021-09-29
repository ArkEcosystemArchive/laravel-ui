<x:ark-fortify::form-wrapper x-show="!recovery"
                             action="{{ isset($resetPassword)
                                    ? route('two-factor.reset-password-store', ['token' => $token])
                                    : route('two-factor.login') }}">
    <div class="mb-8">
        @isset($resetPassword)
            <input type="hidden" name="email" value="{{ $email }}"/>
        @endisset

        <div class="flex flex-1">
            <x-ark-input
                type="text"
                name="code"
                :label="trans('fortify::forms.2fa_code')"
                class="w-full hide-number-input-arrows"
                :errors="$errors"
                autocomplete="one-time-code"
                input-mode="numeric"
                pattern="[0-9]{6}"
            />
        </div>
    </div>

    <div class="flex flex-col-reverse items-center justify-between sm:flex-row">
        <button @click="recovery = true" type="button" class="w-full mt-4 font-semibold link sm:w-auto sm:mt-0">
            @lang('fortify::actions.enter_recovery_code')
        </button>

        <button type="submit" class="w-full button-secondary sm:w-auto">
            @lang('fortify::actions.sign_in')
        </button>
    </div>
</x:ark-fortify::form-wrapper>

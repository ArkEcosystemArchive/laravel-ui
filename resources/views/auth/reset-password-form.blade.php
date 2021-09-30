<x:ark-fortify::form-wrapper :action="route('password.update')" x-data="{ isTyping: false }">
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="space-y-5">
        <div>
            <div class="flex flex-1">
                <x-ark-input
                    wire:model.defer="email"
                    no-model
                    type="email"
                    name="email"
                    :label="trans('ui::forms.email')"
                    autocomplete="email"
                    class="w-full"
                    :autofocus="true"
                    :required="true"
                    :errors="$errors"
                    readonly
                />
            </div>
        </div>

        <x:ark-fortify::password-rules
            :password-rules="$this->passwordRules"
            rules-wrapper-class="grid gap-4 my-4 sm:grid-cols-2"
            is-typing="isTyping"
            @typing="isTyping=true"
        >
            <x-ark-password-toggle
                model="password"
                name="password"
                :label="trans('ui::forms.password')"
                autocomplete="new-password"
                class="w-full"
                required="true"
                @keydown="isTyping=true"
                :errors="$errors"

            />
        </x:ark-fortify::password-rules>

        <div>
            <div class="flex flex-1">
                <x-ark-password-toggle
                    model="password_confirmation"
                    name="password_confirmation"
                    :label="trans('ui::forms.confirm_password')"
                    autocomplete="new-password"
                    class="w-full"
                    :required="true"
                    :errors="$errors"
                />
            </div>
        </div>

        <div class="flex flex-col-reverse items-center justify-between space-y-4 md:space-y-0 md:flex-row">
            <div class="flex-1 mt-8 md:mt-0">
                <a href="{{ route('login') }}" class="link">@lang('ui::actions.cancel')</a>
            </div>

            <button type="submit" class="w-full button-secondary md:w-auto">
                @lang('ui::actions.reset_password')
            </button>
        </div>
    </div>
</x:ark-fortify::form-wrapper>

<x:ark-fortify::form-wrapper :action="$formUrl" x-data="{isTyping: false}">
    @if($invitation)
        <input type="hidden" name="name" value="{{ $invitation->name }}" />
        <input type="hidden" name="email" value="{{ $invitation->email }}" />
    @endif

    <div class="space-y-5">
        @if(Config::get('fortify.username_alt'))
            <div>
                <div class="flex flex-1">
                    <x-ark-input
                        model="username"
                        type="text"
                        name="username"
                        :label="trans('fortify::forms.username')"
                        autocomplete="username"
                        class="w-full"
                        :errors="$errors"
                    />
                </div>
            </div>
        @endif

        @unless($invitation)
            <div>
                <div class="flex flex-1">
                    <x-ark-input
                        model="name"
                        name="name"
                        :label="trans('fortify::forms.display_name')"
                        autocomplete="name"
                        class="w-full"
                        :autofocus="true"
                        :errors="$errors"
                    />
                </div>
            </div>

            <div>
                <div class="flex flex-1">
                    <x-ark-input
                        model="email"
                        type="email"
                        name="email"
                        :label="trans('fortify::forms.email')"
                        autocomplete="email"
                        class="w-full"
                        :errors="$errors"
                    />
                </div>
            </div>
        @endunless

        <x:ark-fortify::password-rules
            :password-rules="$passwordRules"
            is-typing="isTyping"
            rules-wrapper-class="grid grid-cols-1 gap-4 my-4"
        >
            <x-ark-password-toggle
                model="password"
                name="password"
                :label="trans('fortify::forms.password')"
                autocomplete="new-password"
                class="w-full"
                @keydown="isTyping=true"
                :errors="$errors"
            />
        </x:ark-fortify::password-rules>

        <div>
            <div class="flex flex-1">
                <x-ark-password-toggle
                    model="password_confirmation"
                    name="password_confirmation"
                    :label="trans('fortify::forms.confirm_password')"
                    autocomplete="new-password"
                    class="w-full"
                    :errors="$errors"
                />
            </div>
        </div>

        <div>
            <x-ark-checkbox
                model="terms"
                name="terms"
                :errors="$errors"
            >
                @slot('label')
                    @lang('fortify::auth.register-form.conditions', ['termsOfServiceRoute' => route('terms-of-service'), 'privacyPolicyRoute' => route('privacy-policy')])
                @endslot
            </x-ark-checkbox>

            @error('terms')
                <p class="input-help--error">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right">
            <button type="submit" class="w-full button-secondary sm:w-auto">
                @lang('fortify::actions.sign_up')
            </button>
        </div>
    </div>
</x:ark-fortify::form-wrapper>

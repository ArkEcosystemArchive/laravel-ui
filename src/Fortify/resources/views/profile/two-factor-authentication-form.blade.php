@php
    use \Illuminate\View\ComponentAttributeBag;

    $twoAuthLink1 = view('ark::external-link', [
        'attributes' => new ComponentAttributeBag([]),
        'text' => 'Authy',
        'url' => 'https://authy.com',
        'inline' => true,
    ])->render();

    $twoAuthLink2 = view('ark::external-link', [
        'attributes' => new ComponentAttributeBag([]),
        'text' => 'Google Authenticator',
        'url' => 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2',
        'inline' => true,
    ])->render();
@endphp

<div dusk="two-factor-authentication-form">
    @if (! $this->enabled)
        <div class="flex flex-col w-full space-y-8">
            <div class="flex flex-col">
                <span class="header-4">
                    @lang('fortify::pages.user-settings.2fa_title')
                </span>
                <span class="mt-4">
                    @lang('fortify::pages.user-settings.2fa_description')
                </span>
            </div>

            <div class="flex flex-col sm:hidden">
                <span class="header-4">
                    @lang('fortify::pages.user-settings.2fa_not_enabled_title')
                </span>
                <div class="mt-2 text-base leading-7 text-theme-secondary-600">
                    @lang('fortify::pages.user-settings.2fa_summary', [
                        'link1' => $twoAuthLink1,
                        'link2' => $twoAuthLink2,
                    ])
                </div>
            </div>

            <div class="flex w-full mt-8 space-y-4 sm:hidden">
                <div class="w-full">
                    <x-ark-input
                        type="number"
                        name="state.otp"
                        :label="trans('fortify::pages.user-settings.one_time_password')"
                        :errors="$errors"
                        pattern="[0-9]{6}"
                        class="hide-number-input-arrows"
                    />
                </div>
            </div>

            <hr class="flex my-8 border-t sm:hidden border-theme-primary-100">

            <div class="flex flex-col items-center sm:flex-row sm:items-start sm:mt-8">
                <div class="flex flex-col items-center justify-center border rounded-xl border-theme-secondary-400 sm:mr-10">
                    <div class="px-2 py-2">
                        {!! $this->twoFactorQrCodeSvg !!}
                    </div>
                    <div class="w-full py-2 mt-1 text-center border-t border-theme-secondary-400 bg-theme-secondary-100 rounded-b-xl">
                        <span class="text-theme-secondary-900">{{ $this->state['two_factor_secret'] }}</span>
                    </div>
                </div>

                <div class="hidden w-1 h-64 mr-10 sm:flex bg-theme-primary-100"></div>

                <div class="flex-col hidden sm:flex">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                        @lang('fortify::pages.user-settings.2fa_not_enabled_title')
                    </span>


                    <div class="mt-2 text-base leading-7 text-theme-secondary-600">
                        @lang('fortify::pages.user-settings.2fa_summary', [
                            'link1' => $twoAuthLink1,
                            'link2' => $twoAuthLink2,
                        ])
                    </div>

                    <div class="hidden w-full mt-8 md:flex">
                        <div class="w-full">
                            <x-ark-input
                                type="number"
                                name="state.otp"
                                :label="trans('fortify::pages.user-settings.one_time_password')"
                                :errors="$errors"
                                pattern="[0-9]{6}"
                                class="hide-number-input-arrows"
                                dusk="one-time-password"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden w-full mt-8 space-y-4 sm:flex md:hidden">
                <div class="w-full">
                    <x-ark-input
                        type="number"
                        name="state.otp"
                        :label="trans('fortify::pages.user-settings.one_time_password')"
                        :errors="$errors"
                        pattern="[0-9]{6}"
                        class="hide-number-input-arrows"
                    />
                </div>
            </div>

            <div class="flex mt-8 sm:justify-end">
                <button
                    type="button"
                    class="w-full button-secondary sm:w-auto"
                    wire:click="enableTwoFactorAuthentication"
                    dusk="enable-two-factor-authentication"
                >
                    @lang('fortify::actions.enable')
                </button>
            </div>
        </div>
    @else
        <div class="flex flex-col">
            <span class="header-4">@lang('fortify::pages.user-settings.2fa_title')</span>
            <span class="mt-4">@lang('fortify::pages.user-settings.2fa_description')</span>

            <div class="flex flex-col items-center mt-4 space-y-4 sm:mt-8 sm:items-start sm:flex-row sm:space-y-0 sm:space-x-6">
                <img src="{{ asset('/images/profile/2fa.svg') }}" class="w-24 h-24" alt="">
                <div class="flex flex-col">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                        @lang('fortify::pages.user-settings.2fa_enabled_title')
                    </span>
                    <div class="mt-2 text-theme-secondary-600">

                        @lang('fortify::pages.user-settings.2fa_summary', [
                            'link1' => $twoAuthLink1,
                            'link2' => $twoAuthLink2,
                        ])
                    </div>
                </div>
            </div>

            <div class="flex flex-col w-full mt-8 space-y-3 sm:flex-row sm:justify-end sm:space-y-0 sm:space-x-3">
                <button type="button" class="w-full button-secondary sm:w-auto" wire:click="showConfirmPassword">
                    @lang('fortify::actions.recovery_codes')
                </button>

                <button
                    type="submit"
                    class="w-full button-primary sm:w-auto"
                    wire:click="showDisableConfirmPassword"
                    dusk="disable-two-factor-authentication"
                >
                    @lang('fortify::actions.disable')
                </button>
            </div>
        </div>
    @endif

    <div dusk="recovery-codes-modal">
        @if($this->modalShown)
            <x:ark-fortify::modals.2fa-recovery-codes />
        @endif
    </div>

    @if($this->confirmPasswordShown)
        <x:ark-fortify::modals.password-confirmation
            :title="trans('fortify::forms.confirm-password.title')"
            :description="trans('fortify::forms.confirm-password.description')"
            action-method="showRecoveryCodesAfterPasswordConfirmation"
            close-method="closeConfirmPassword"
        />
    @endif

    @if($this->disableConfirmPasswordShown)
        <x:ark-fortify::modals.password-confirmation
            :title="trans('fortify::forms.disable-2fa.title')"
            :description="trans('fortify::forms.disable-2fa.description')"
            action-method="disableTwoFactorAuthentication"
            close-method="closeDisableConfirmPassword"
        />
    @endif
</div>

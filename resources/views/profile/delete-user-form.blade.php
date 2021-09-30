<div>
    <div class="flex flex-col">
        <span class="header-4">@lang('ui::pages.user-settings.delete_account_title')</span>
        <span class="mt-4">
            @lang('ui::pages.user-settings.delete_account_description')
        </span>

        <div class="flex flex-row justify-end mt-8">
            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center space-x-2 button-cancel"
                wire:click="confirmUserDeletion">
                @svg('trash', 'h-4 w-4')
                <span>@lang('ui::actions.delete_account')</span>
            </button>
        </div>
    </div>

    @if($this->modalShown)
        <x-ark-modal title-class="header-2" width-class="max-w-xl" wire-close="closeModal">
            <x-slot name="title">
                @lang('ui::forms.delete-user.title')
            </x-slot>

            <x-slot name="description">
                <div class="flex flex-col mt-4">
                    <div class="flex justify-center w-full">
                        <x-ark-icon name="fortify-modal.delete-account" class="text-theme-primary-600 w-2/3 h-auto"/>
                    </div>
                    <div class="mt-4">
                        @lang('ui::forms.delete-user.confirmation')
                    </div>
                </div>
                <form class="mt-8">
                    <div class="space-y-2">
                        <x-ark-input
                            input-class="text-center"
                            type="text"
                            name="username"
                            model="username"
                            :label="trans('ui::forms.confirm_username')"
                            readonly
                        />
                        <x-ark-input
                            type="text"
                            name="username_confirmation"
                            model="usernameConfirmation"
                            :placeholder="trans('ui::forms.delete-user.confirmation_placeholder')"
                            :errors="$errors"
                            hide-label
                        />
                    </div>
                    <div class="mt-4">
                        <x-ark-textarea
                            name="feedback"
                            model="feedback"
                            :label="trans('ui::forms.feedback.label')"
                            :placeholder="trans('ui::forms.feedback.placeholder')"
                            :auxiliary-title="trans('ui::forms.optional')"
                            rows="5"
                        />
                    </div>
                </form>
            </x-slot>

            <x-slot name="buttons">
                <div class="flex flex-col w-full sm:flex-row justify-end sm:space-x-3">
                    <button type="button" dusk="delete-user-form-cancel" class="button-secondary mb-4 sm:mb-0" wire:click="closeModal">
                        @lang('ui::actions.cancel')
                    </button>

                    <button type="button" dusk="delete-user-form-submit" class="inline-flex justify-center items-center button-cancel" wire:click="deleteUser" {{ ! $this->hasConfirmedName() ? 'disabled' : ''}}>
                        <x-ark-icon name="trash" size="sm"/>
                        <span class="ml-2">@lang('ui::actions.delete')</span>
                    </button>
                </div>
            </x-slot>
        </x-ark-modal>
    @endif
</div>

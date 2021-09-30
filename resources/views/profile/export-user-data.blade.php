<div>
    <div class="flex flex-col">
        <span class="header-4">@lang('ui::pages.user-settings.gdpr_title')</span>
        <span class="mt-4">@lang('ui::pages.user-settings.gdpr_description')</span>

        <div class="mt-4">
            <x-ark-flash />
        </div>

        <div class="flex justify-end mt-8">
            <div @if($this->rateLimitReached()) data-tippy-content="@lang('ui::messages.export_limit_reached')" @endif >
                <button @if($this->rateLimitReached()) disabled @endif wire:loading.attr="disabled" type="submit" class="w-full button-secondary sm:w-auto" wire:click="export">
                    @lang('ui::actions.export_personal_data')
                </button>
            </div>
        </div>
    </div>
</div>

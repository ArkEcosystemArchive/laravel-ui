<div class="flex max-w-xl p-8 mx-auto my-6 bg-white rounded-lg">
    <div class="flex flex-col w-full text-center space-y-6">
        <div class="space-y-4">
            <h1>@lang('ui::auth.verify.page_header')</h1>

            <p>@lang('ui::auth.verify.link_description')</p>
        </div>

        <img class="mb-5 mx-12" src="/images/auth/verify-email.svg" alt="" />

        <form wire:click.prevent="resend" wire:poll>
            <p class="text-sm text-theme-secondary-600 lg:no-wrap-span-children">
                <span>@lang('ui::auth.verify.line_1')</span>
                <span>@lang('ui::auth.verify.line_2')</span>

                @if($this->rateLimitReached())
                    <span class="link" data-tippy-content="@lang('ui::messages.resend_email_verification_limit')">
                        @lang('ui::actions.resend_email_verification')
                    </span>
                @else
                    <button wire:loading.attr="disabled" type="submit" class="link">
                        @lang('ui::actions.resend_email_verification')
                    </button>
                @endif
            </p>
        </form>
    </div>
</div>

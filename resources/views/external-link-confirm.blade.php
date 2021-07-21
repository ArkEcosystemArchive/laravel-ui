<x-ark-js-modal
    name="external-link-confirm"
    class="w-full max-w-2xl text-left rounded-xl"
    title-class="header-2"
    buttons-style="flex justify-end space-x-3"
    x-data="{
        url: null,
        hasConfirmedLinkWarning: false,
        toggle () {
            this.hasConfirmedLinkWarning = ! this.hasConfirmedLinkWarning;
        },
        onBeforeShow ([ url ]) {
            this.url = url;
        },
        onHidden () {
            this.url = null;
            this.hasConfirmedLinkWarning = false;
            document.querySelector('input[name=confirmation]').checked = false;
        },
        followLink() {
            if(this.hasConfirmedLinkWarning) {
                localStorage.setItem('has_disabled_link_warning', true)
            }
        }
    }"
    init
>
    @slot('title')
        @lang('generic.external_link')
    @endslot

    @slot('description')
        <div class="flex flex-col mt-8 space-y-4 whitespace-normal">
            <div class="font-semibold text-theme-secondary-900">
                <div class="alert-wrapper alert-warning">
                    <div class="alert-icon-wrapper alert-warning-icon">
                        <div class="p-1 rounded-full border-2 border-white">
                            <x-ark-icon
                                name="warning"
                                size="xs"
                            />
                        </div>
                    </div>
                    <div class="alert-content-wrapper alert-warning-content">
                        <span class="block leading-6 break-all" x-text="url"></span>
                    </div>
                </div>
            </div>

            <p>@lang('generic.external_link_disclaimer')</p>

            <x-ark-checkbox
                name="confirmation"
                alpine="toggle"
            >
                @slot('label')
                    @lang('ui::forms.do_not_show_message_again')
                @endslot
            </x-ark-checkbox>
        </div>
    @endslot

    @slot('buttons')
        <button
            class="button-secondary"
            @click="hide"
        >
            @lang('actions.back')
        </button>

        <a
            target="_blank"
            rel="noopener nofollow"
            class="cursor-pointer button-primary"
            :href="url"
            @click="hide(); followLink()"
        >
            @lang('actions.follow_link')
        </a>
    @endslot
</x-ark-js-modal>

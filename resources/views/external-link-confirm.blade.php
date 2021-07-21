{{--
    **Important:**
    If you ever change the template or the icon here here ensure to update:
    - regex in `src/Support/MarkdownParser.php`
    - tests in `tests/Support/MarkdownParserTest.php`
--}}

@props([
    'url',
    'text' => null,
    'noIcon' => false,
])

@php($identifier = md5($url . '-' . Str::random(8)))

<span x-data="{
        openModal() {
            Livewire.emit('openModal', '{{ $identifier }}')
        },
        redirect() {
            window.open('{{ $url }}', '_blank')
        },
        hasDisabledLinkWarning() {
            return localStorage.getItem('has_disabled_link_warning') === 'true';
        }
    }"
>
    <a
        :href="hasDisabledLinkWarning() ? '{{ $url }}' : 'javascript:;'"
        :target="hasDisabledLinkWarning() ? '_blank' : '_self'"
        rel="noopener nofollow"
        class="items-center font-semibold break-all cursor-pointer link"
        @click="hasDisabledLinkWarning() ? redirect() : openModal()"
    >
        <span>{{ $text ?? $slot ?? '' }}</span>

        @unless($noIcon)
            <x-ark-icon name="link" size="sm" class="inline flex-shrink-0 ml-1 -mt-1.5" />
        @endunless
    </a>

    @push('footer')
        <x-ark-js-modal
            :name="$identifier"
            class="w-full max-w-2xl text-left rounded-xl"
            title-class="header-2"
            buttons-style="flex justify-end space-x-3"
            x-data="{
                hasConfirmedLinkWarning: false,
                toggle () {
                    this.hasConfirmedLinkWarning = ! this.hasConfirmedLinkWarning;
                },
                onHidden () {
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
                        <x-ark-alert type="warning" :message="$url" message-class="break-all" />
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
                    href="{{ $url }}"
                    @click="hide(); followLink()"
                >
                    @lang('actions.follow_link')
                </a>
            @endslot
        </x-ark-js-modal>
    @endpush
</span>

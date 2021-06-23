@props([
    'url',
    'text' => null,
    'noIcon' => false,
])

@php($identifier = md5($url . '-' . Str::random(8)))

<div x-data="{
        openModal() {
            Livewire.emit('openModal', '{{ $identifier }}')
        },
        redirect() {
            window.open('{{ $url }}', '_blank')
        },
        hasConfirmedLinkWarning() {
            return localStorage.getItem('confirm_link_warning') == 'true';
        },
        hasDisabledLinkWarning() {
            return localStorage.getItem('disable_link_warning') == 'true';
        }
    }"
>
    <a
        href="javascript:;"
        class="inline-flex items-center space-x-2 font-semibold whitespace-nowrap cursor-pointer link"
        @click="hasDisabledLinkWarning() ? redirect() : openModal()"
    >
        <span>{{ $text ?? $slot ?? '' }}</span>

        @unless($noIcon)
            <x-ark-icon name="link" size="sm" class="mx-2" />
        @endunless
    </a>

    @push('footer')
        <x-ark-js-modal
            :name="$identifier"
            class="w-full max-w-2xl text-left rounded-xl"
            title-class="header-2"
            buttons-style="flex justify-end space-x-3"
            init
        >
            @slot('title')
                @lang('generic.external_link')
            @endslot

            @slot('description')
                <div class="flex flex-col mt-8 space-y-4 whitespace-normal">
                    <div class="font-semibold text-theme-secondary-900">
                        <x-ark-alert type="warning" :message="$url" />
                    </div>
                    <p>@lang('generic.external_link_disclaimer')</p>

                    <x-ark-checkbox
                        name="confirmation"
                        alpine="localStorage.getItem('confirm_link_warning') == 'true' ? localStorage.setItem('confirm_link_warning', false) : localStorage.setItem('confirm_link_warning', true)"
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
                    @click="hide(); localStorage.getItem('confirm_link_warning') == 'true' ? localStorage.setItem('disable_link_warning', false) : localStorage.setItem('disable_link_warning', true)"
                >
                    @lang('actions.follow_link')
                </a>
            @endslot
        </x-ark-js-modal>
    @endpush
</div>
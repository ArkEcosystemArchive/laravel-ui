@props([
    'url',
    'text' => null,
    'noIcon' => false,
])

@php($identifier = md5($url . '-' . Str::random(8)))

<a
    href="javascript:;"
    x-data="{
        openModal() {
            Livewire.emit('openModal', '{{ $identifier }}')
        }
    }"
    class="inline-block items-center space-x-2 font-semibold break-all cursor-pointer link"
    @click="openModal"
>
    <span>{{ $text ?? $slot ?? '' }}</span>

    @unless($noIcon)
        <x-ark-icon name="link" size="sm" class="inline flex-shrink-0 mr-2 ml-1 -mt-1" />
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
                    <x-ark-alert type="warning" :message="$url" message-class="break-all" />
                </div>
                <p>@lang('generic.external_link_disclaimer')</p>
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
                @click="hide"
            >
                @lang('actions.follow_link')
            </a>
        @endslot
    </x-ark-js-modal>
@endpush

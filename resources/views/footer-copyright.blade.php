@props([
    'isArkProduct' => true,
    'copyText'     => 'ARK.io | ' . trans('ui::general.all_rights_reserved'),
    'iconSize'     => 'md',
])

<div {{ $attributes->merge(['class' => 'flex flex-col py-6 space-y-2 font-semibold text-theme-secondary-700 sm:block sm:space-y-0'])}}>
    <span class="whitespace-nowrap">
        {{ date('Y') }} &copy; {{ $copyText }}
    </span>

    <div class="flex">
        @if($isArkProduct)
            <div>
                <span class="hidden mr-1 sm:inline"> | </span>
                <span class="whitespace-nowrap">
                    <x-ark-icon
                        name="ark-logo-red-square"
                        class="inline-block mr-1 -mt-1"
                        :size="$iconSize"
                    />

                    An <a href="https://ark.io/" class="underline hover:no-underline focus-visible:rounded">ARK.io</a> Product
                </span>
            </div>
        @endif
    </div>
</div>

@props([
    'isArkProduct' => true,
    'noBorder'     => '',
    'copyClass'    => '',
    'copyText'     => null,
])

<div class="flex items-center justify-between @unless ($noBorder) border-t border-theme-secondary-800 @endunless">
    <x-ark-footer-copyright
        :is-ark-product="$isArkProduct"
        :copy-text="$copyText"
        class="{{ $copyClass }}"
    />

    <x-ark-footer-social />
</div>

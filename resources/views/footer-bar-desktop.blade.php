@props([
    'copyClass'    => '',
    'copyText'     => null,
    'isArkProduct' => true,
    'noBorder'     => '',
    'socials'      => null,
])

<div
    @class([
        'flex items-center justify-between',
        'border-t border-theme-secondary-800' => ! $noBorder,
    ])
>
    <x-ark-footer-copyright
        :is-ark-product="$isArkProduct"
        :copy-text="$copyText"
        class="{{ $copyClass }}"
    />

    <x-ark-footer-social :networks="$socials" />
</div>
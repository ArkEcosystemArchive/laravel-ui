@props([
    'copyClass'    => '',
    'isArkProduct' => true,
    'noBorder'     => '',
])

<div
    @class([
        'flex items-center justify-between',
        'border-t border-theme-secondary-800' => ! $noBorder,
    ])
>
    <x-ark-footer-copyright :is-ark-product="$isArkProduct" class="{{ $copyClass }}" />
    <x-ark-footer-social />
</div>

@props([
    'isArkProduct' => true,
    'class'        => '',
    'copyClass'    => '',
    'copyText'     => null,
])

<div class="flex flex-col {{ $class }}">
    <x-ark-footer-copyright
        :is-ark-product="$isArkProduct"
        :copy-text="$copyText"
        class="{{ $copyClass }}"
    />
    <x-ark-footer-social />
</div>

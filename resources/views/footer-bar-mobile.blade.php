@props([
    'isArkProduct' => true,
    'class'        => '',
    'copyClass'    => '',
    'copyText'     => null,
    'socials'      => null,
    'extra'        => null,
    'iconSize'     => 'md',
])

<div class="flex flex-col {{ $class }}">
    <x-ark-footer-copyright
        :is-ark-product="$isArkProduct"
        :copy-text="$copyText"
        class="{{ $copyClass }}"
        :extra="$extra"
        :icon-size="$iconSize"
    />

    <x-ark-footer-social :networks="$socials" />
</div>

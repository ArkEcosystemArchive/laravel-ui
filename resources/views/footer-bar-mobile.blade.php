@props([
    'isArkProduct' => true,
    'class'        => '',
    'copyClass'    => '',
    'copyText'     => null,
    'socials'      => null,
    'extra'        => null,
])

<div class="flex flex-col {{ $class }}">
    <x-ark-footer-copyright
        :is-ark-product="$isArkProduct"
        :copy-text="$copyText"
        :class="$copyClass"
        :extra="$extra"
    />

    <x-ark-footer-social :networks="$socials" />
</div>

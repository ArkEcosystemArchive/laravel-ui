@props([
    'isArkProduct' => true,
    'class'        => '',
    'copyClass'    => '',
])

<div class="flex flex-col {{ $class }}">
    <x-ark-footer-copyright :is-ark-product="$isArkProduct" class="{{ $copyClass }}" />
    <x-ark-footer-social />
</div>

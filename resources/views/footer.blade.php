@props([
    'desktopClass' => 'px-8 max-w-7xl hidden lg:flex',
    'mobileClass' => 'px-8 pb-8 lg:hidden',
    'copyClass' => '',
    'isArkProduct' => true,
])

<div {{ $attributes->merge(['class' => 'border-t bg-theme-secondary-900 border-theme-secondary-800']) }}>
    <div @class([
        'flex-col mx-auto',
        $desktopClass,
    ])>
        {{-- Empty class to remove border --}}
        <x-ark-footer-bar-desktop no-border :is-ark-product="$isArkProduct" :copy-class="$copyClass" />
    </div>

    <x-ark-footer-bar-mobile class="{{ $mobileClass }} " :is-ark-product="$isArkProduct" :copy-class="$copyClass" />
</div>

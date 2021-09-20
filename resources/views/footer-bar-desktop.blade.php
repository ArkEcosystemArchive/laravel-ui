@props([
    'isArkProduct' => true,
    'noBorder'     => '',
    'copyClass'    => '',
    'copyText'     => null,
    'socials'      => null,
    'extra'        => null,
    'iconSize'     => 'md',
])

<div class="flex items-center justify-between @unless ($noBorder) border-t border-theme-secondary-800 @endunless">
    <x-ark-footer-copyright
        :is-ark-product="$isArkProduct"
        :copy-text="$copyText"
        :class="$copyClass"
        :extra="$extra"
        :icon-size="$iconSize"
    />

    <x-ark-footer-social :networks="$socials" />
</div>

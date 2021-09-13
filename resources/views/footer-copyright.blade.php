@props([
    'isArkProduct' => true,
    'copyText'     => 'ARK.io | All Rights Reserved',
])

<div {{ $attributes->merge(['class' => 'flex flex-col py-6 space-y-2 font-semibold text-theme-secondary-700 sm:block sm:space-y-0'])}}>
    <span class="whitespace-nowrap">
        {{ date('Y') }} &copy; {{ $copyText }}
    </span>

    @if($isArkProduct)
        <span class="hidden mr-1 sm:inline"> | </span>
        <span class="whitespace-nowrap">
            @svg('ark-logo-red-square', 'inline-block h-6 -mt-1') An <a href="https://ark.io/" class="underline hover:no-underline focus-visible:rounded">ARK.io</a> Product
        </span>
    @endif
</div>

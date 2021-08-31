@props([
    'isArkProduct' => true,
])

<div {{ $attributes->merge(['class' => 'flex flex-col py-6 space-y-2 font-semibold text-theme-secondary-700 sm:block sm:space-y-0'])}}>
    <span class="whitespace-nowrap">{{ date('Y') }} &copy; ARK.io | All rights reserved</span>
    @if($isArkProduct)
        <span class="hidden mr-1 sm:inline"> | </span>
        <span class="whitespace-nowrap">
            @svg('ark-logo-red-square', 'inline-block h-6 -mt-1') An <a href="https://ark.io/" class="underline hover:no-underline focus-visible:rounded focus-visible:ring-offset-2 focus-visible:ring-offset-theme-secondary-900">ARK.io</a> Product
        </span>
    @endif
</div>

@props([
    'breakpoint' => 'md',
])

@php
    // Exact class strings required to prevent purging
    $breakpointClass = [
        'sm' => 'sm:hidden',
        'md' => 'md:hidden',
        'lg' => 'lg:hidden',
        'xl' => 'xl:hidden',
    ][$breakpoint];
@endphp

<div class="flex items-center pr-6 border-r border-theme-secondary-300 {{ $breakpointClass }}">
    <button @click="open = !open" class="inline-flex justify-center items-center p-2 rounded-md transition duration-150 ease-in-out text-theme-secondary-900">
        <span :class="{ 'hidden': open, 'inline-flex': !open }">
            <x-ark-icon name="menu" size="sm" />
        </span>

        <span :class="{ 'hidden': !open, 'inline-flex': open }" x-cloak>
            <x-ark-icon name="menu-show" size="sm" />
        </span>
    </button>
</div>

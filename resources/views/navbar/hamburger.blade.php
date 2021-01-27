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

<div class="flex items-center {{ $breakpointClass }}">
    <button @click="open = !open" class="relative inline-flex items-center justify-center p-2 transition duration-150 ease-in-out rounded-md text-theme-secondary-900">
        <span :class="{ 'hidden': open, 'inline-flex': !open }">
            <x-ark-icon name="menu" size="sm" />
        </span>

        <span :class="{ 'hidden': !open, 'inline-flex': open }" x-cloak>
            <x-ark-icon name="menu-show" size="sm" />
        </span>

        <livewire:all-notifications-indicator :check-invitations="true" :check-notifications="true" />
    </button>

    <span class="hidden h-5 border-r md:block md:ml-6 md:mr-4 border-theme-secondary-300 dark:border-theme-secondary-800"></span>
</div>

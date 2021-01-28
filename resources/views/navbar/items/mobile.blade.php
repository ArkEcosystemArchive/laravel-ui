@props([
    'breakpoint' => 'md',
    'navigation' => [],
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

<div :class="{'block': open, 'hidden': !open}" class="border-t-2 border-theme-secondary-200 {{ $breakpointClass }}">
    <div class="pt-2 pb-4 rounded-b-lg">
        @if(isset($navbarNotificationsMobile) || isset($notifications))
            <div class="flex items-center justify-center px-2 py-0.5 mx-8 my-4 border rounded shadow-sm border-theme-secondary-300 md:hidden">
                {{ $navbarNotificationsMobile }}

                @if(isset($navbarNotificationsMobile) && isset($notifications))
                    <span class="mx-4 h-5 border-r border-theme-secondary-300 dark:border-theme-secondary-800"></span>
                @endif

                @isset($notifications)
                    @include('ark::navbar.notifications')
                @endisset
            </div>
        @endisset

        @foreach ($navigation as $navItem)
            @if(isset($navItem['children']))
                <div class="flex w-full">
                    <div class="z-10 -mr-1 w-2"></div>
                    <a
                        href="#"
                        class="flex justify-between items-center py-3 px-8 w-full font-semibold border-l-2 border-transparent"
                        @click="openDropdown = openDropdown === '{{ $navItem['label'] }}' ? null : '{{ $navItem['label'] }}'"
                    >
                        <span :class="{ 'text-theme-primary-600': openDropdown === '{{ $navItem['label'] }}' }">{{ $navItem['label'] }}</span>
                        <span class="ml-2 transition duration-150 ease-in-out text-theme-primary-600" :class="{ 'rotate-180': openDropdown === '{{ $navItem['label'] }}' }">@svg('chevron-down', 'h-3 w-3')</span>
                    </a>
                </div>
                <div x-show="openDropdown === '{{ $navItem['label'] }}'" class="pl-8" x-cloak>
                    @foreach ($navItem['children'] as $childNavItem)
                        <div @mouseenter="selectedChild = {{ json_encode($childNavItem) }}">
                            <x-ark-sidebar-link :route="$childNavItem['route']" :name="$childNavItem['label']" :params="$childNavItem['params'] ?? []" />
                        </div>
                    @endforeach
                </div>
            @else
                <x-ark-sidebar-link :route="$navItem['route']" :name="$navItem['label']" :params="$navItem['params'] ?? []" />
            @endif
        @endforeach
    </div>
</div>

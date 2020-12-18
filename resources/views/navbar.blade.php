@props([
    'breakpoint' => 'md',
    'navigation' => [],
    'content' => null,
    'desktop' => null,
    'mobile' => null,
])

@php
    // Exact class strings required to prevent purging
    $backdropClass = [
        'sm' => 'sm:hidden',
        'md' => 'md:hidden',
        'lg' => 'lg:hidden',
        'xl' => 'xl:hidden',
    ][$breakpoint];
@endphp

<div x-data="{ open: false, openDropdown: null, selectedChild: null }">
    <div
        x-show="openDropdown !== null || open"
        class="overflow-y-auto fixed inset-0 z-30 opacity-75 bg-theme-secondary-900 {{ $backdropClass }}"
        @click="openDropdown = null; open = false;"
        x-cloak
    ></div>

    <nav class="relative z-30 bg-white shadow-header-smooth dark:shadow-none dark:bg-theme-secondary-900">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex relative justify-between h-20 md:h-24">
                @include('ark::navbar.logo')

                <div class="flex justify-end">
                    <div class="flex flex-1 justify-end items-center sm:items-stretch sm:justify-between">
                        @if($desktop)
                            {{ $desktop }}
                        @else
                            @include('ark::navbar.items.desktop')
                        @endif
                    </div>

                    <div class="flex inset-y-0 right-0 items-center pr-2 sm:static sm:inset-auto sm:ml-4 sm:pr-0">
                        @include('ark::navbar.hamburger')

                        @if($content)
                            {{ $content }}
                        @else
                            @include('ark::navbar.content')
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($mobile)
            {{ $mobile }}
        @else
            @include('ark::navbar.items.mobile')
        @endif
    </nav>
</div>

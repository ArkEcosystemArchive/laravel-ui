{{-- Better not to use @props as there's too many properties in included components --}}

@php
    // Exact class strings required to prevent purging
    $backdropClass = [
        'sm' => 'sm:hidden',
        'md' => 'md:hidden',
        'lg' => 'lg:hidden',
        'xl' => 'xl:hidden',
    ][$breakpoint ?? 'md'];
@endphp

<header x-data="Navbar.dropdown()" x-init="init">
    <div
        x-show="openDropdown !== null || open"
        class="overflow-y-auto fixed inset-0 z-30 opacity-75 bg-theme-secondary-900 {{ $backdropClass }}"
        @click="openDropdown = null; open = false;"
        x-cloak
    ></div>

    {{-- Spacer for the sticky navbar  --}}
    <div class="mb-0.5 h-20"></div>
    <nav
        aria-label="{{ trans('ui::general.primary_navigation') }}"
        x-ref="nav"
        class="fixed top-0 z-30 w-full bg-white border-b border-theme-secondary-300 dark:bg-theme-secondary-900"
        dusk="navigation-bar"
    >
        <div class="relative z-10 bg-white navbar-container border-theme-secondary-300">
            <div class="flex relative justify-between h-21">
                @include('ark::navbar.logo')

                @isset($middle)
                    {{ $middle }}
                @endisset

                <div class="flex justify-end">
                    <div class="flex flex-1 justify-end items-center sm:justify-between sm:items-stretch">
                        @isset($desktop)
                            {{ $desktop }}
                        @else
                            @include('ark::navbar.items.desktop')
                        @endisset
                    </div>

                    <div class="flex inset-y-0 right-0 items-center sm:static sm:inset-auto sm:ml-3">
                        @if(is_array($navigation))
                            @include('ark::navbar.hamburger')
                        @endif

                        @isset($content)
                            {{ $content }}
                        @else
                            @include('ark::navbar.content')
                        @endisset
                    </div>
                </div>
            </div>
        </div>

        @isset($mobile)
            {{ $mobile }}
        @else
            @include('ark::navbar.items.mobile')
        @endisset
    </nav>
</header>

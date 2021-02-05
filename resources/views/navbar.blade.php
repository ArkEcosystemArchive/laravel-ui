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

<div x-data="{
        open: false,
        openDropdown: null,
        selectedChild: null,
        scrollProgress: 0,
        nav: null,
        init() {
            const { nav } = this.$refs
            this.nav = nav;
            window.onscroll = this.onScroll.bind(this);
            this.scrollProgress = this.getScrollProgress();
            this.updateShadow(this.scrollProgress);
        },
        onScroll() {
            const progress = this.getScrollProgress()
            if (progress !== this.scrollProgress) {
                this.scrollProgress = progress;
                this.updateShadow(progress);
            }
        },
        getScrollProgress() {
            const navbarHeight = 82;
            return Math.min(1, document.documentElement.scrollTop / navbarHeight);
        },
        updateShadow(progress) {
            const maxTransparency = 0.22;
            const shadowTransparency = Math.round(maxTransparency * progress * 100) / 100;
            const borderTransparency =  Math.round((1 - progress) * 100) / 100;
            this.nav.style.boxShadow = `0px 2px 10px 0px rgba(192, 200, 207, ${shadowTransparency})`;
            this.nav.style.borderColor = `rgba(219, 222, 229, ${borderTransparency})`;
        }
    }"
    x-init="init"
>
    <div
        x-show="openDropdown !== null || open"
        class="overflow-y-auto fixed inset-0 z-30 opacity-75 bg-theme-secondary-900 {{ $backdropClass }}"
        @click="openDropdown = null; open = false;"
        x-cloak
    ></div>

    {{-- Spacer for the sticky navbar  --}}
    <div class="h-20 mb-0.5"></div>
    <nav
        x-ref="nav"
        class="fixed top-0 z-30 w-full bg-white border-b dark:bg-theme-secondary-900 border-theme-secondary-300"
    >
        <div class="px-4 sm:px-6 lg:px-8 py-0.5">
            <div class="flex relative justify-between h-20">
                @include('ark::navbar.logo')

                @isset($middle)
                    {{ $middle }}
                @endisset

                <div class="flex justify-end">
                    <div class="flex flex-1 justify-end items-center sm:items-stretch sm:justify-between">
                        @isset($desktop)
                            {{ $desktop }}
                        @else
                            @include('ark::navbar.items.desktop')
                        @endisset
                    </div>

                    <div class="flex inset-y-0 right-0 items-center pr-2 sm:static sm:inset-auto sm:ml-4 sm:pr-0">
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
</div>

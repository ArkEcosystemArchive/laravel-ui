<div x-data="{ open: false, openDropdown: null, selectedChild: null }">
    <div x-show="openDropdown !== null || open" class="fixed inset-0 z-30 overflow-y-auto opacity-75 bg-theme-secondary-900" x-cloak @click="openDropdown = null; open = false;"></div>

    <nav class="relative z-30 bg-white shadow-header-smooth dark:shadow-none dark:bg-theme-secondary-900">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="relative flex justify-between h-20 md:h-24">
                @isset($logo)
                    @include('ark::navbar.logo')
                @endisset

                <div class="flex justify-end">
                    <div class="flex items-center justify-end flex-1 sm:items-stretch sm:justify-between">
                        @isset($desktop)
                            {{ $desktop }}
                        @else
                            @include('ark::navbar.items.desktop')
                        @endisset
                    </div>

                    @isset($dropdown)
                        {{ $dropdown }}
                    @else
                        @include('ark::navbar.dropdown')
                    @endisset
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

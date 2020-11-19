<div x-data="{ open: false, openDropdown: null, selectedChild: null }">
    <div x-show="openDropdown !== null || open" class="fixed inset-0 z-30 overflow-y-auto opacity-75 bg-theme-secondary-900" x-cloak @click="openDropdown = null; open = false;"></div>

    <nav class="relative z-30 bg-white shadow-header-smooth dark:shadow-none dark:bg-theme-secondary-900">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="relative flex justify-between h-20 md:h-24">
                @include('ark::navbar.logo')

                <div class="flex justify-end">
                    <div class="flex items-center justify-end flex-1 sm:items-stretch sm:justify-between">
                        @isset($desktop)
                            {{ $desktop }}
                        @else
                            @include('ark::navbar.items.desktop')
                        @endisset
                    </div>

                    <div class="inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-4 sm:pr-0">
                        @include('ark::navbar.hamburger')

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

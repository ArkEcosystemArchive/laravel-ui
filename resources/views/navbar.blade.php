<div x-data="{ open: false, openDropdown: null, selectedChild: null }">
    <div x-show="openDropdown !== null || open" class="fixed inset-0 z-30 overflow-y-auto opacity-75 bg-theme-secondary-900" x-cloak @click="openDropdown = null; open = false;"></div>

    <nav class="relative z-30 bg-white shadow-header-smooth dark:shadow-none dark:bg-theme-secondary-900">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="relative flex justify-between h-20 md:h-24">
                @isset($logo)
                    <x-ark-navbar-logo :logo="$logo" />
                @else
                    <x-ark-navbar-logo :title="$title" />
                @endisset

                <div class="flex justify-end">
                    <div class="flex items-center justify-end flex-1 sm:items-stretch sm:justify-between">
                        @isset($desktop)
                            {{ $desktop }}
                        @else
                            <x-ark-navbar-items-desktop :navigation="$navigation" />
                        @endisset
                    </div>

                    @isset($dropdown)
                        {{ $dropdown }}
                    @else
                        {{-- @TODO: pass down attributes in a separate refactor --}}
                        @isset($notifications)
                            <x-ark-navbar-dropdown
                                :profile-menu="$profileMenu"
                                :profile-menu-class="$profileMenuClass ?? null"
                                :profile-photo="$profilePhoto"
                                :notifications="$notifications"
                            />
                        @else
                            <x-ark-navbar-dropdown
                                :profile-menu="$profileMenu"
                                :profile-photo="$profilePhoto"
                                :profile-menu-class="$profileMenuClass ?? null"
                            />
                        @endisset
                    @endisset
                </div>
            </div>
        </div>

        @isset($mobile)
            {{ $mobile }}
        @else
            <x-ark-navbar-items-mobile :navigation="$navigation" />
        @endisset
    </nav>
</div>

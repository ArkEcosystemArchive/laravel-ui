<div x-data="{ open: false, openDropdown: null, selectedChild: null }">
    <div x-show="openDropdown !== null || open" class="fixed inset-0 z-30 overflow-y-auto opacity-75 bg-theme-secondary-900" x-cloak @click="openDropdown = null; open = false;"></div>

    <nav class="relative z-30 bg-white shadow-header-smooth dark:bg-theme-secondary-900">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="relative flex justify-between h-20 md:h-24">

                {{-- LOGO --}}
                <div class="flex items-center flex-shrink-0">
                    <a class="flex items-center" href="{{ route('home') }}">
                        @if($logo ?? false)
                            {{ $logo }}
                        @else
                            @svg('ark-logo-red-square', 'h-12 w-12')
                            <div class="hidden ml-6 text-lg lg:block"><span class="font-black text-theme-secondary-900">ARK</span> {{ $title }}</div>
                        @endif
                    </a>
                </div>

                <div class="flex justify-end">
                    <div class="flex items-center justify-end flex-1 sm:items-stretch sm:justify-between">
                        {{-- Desktop Navbar Items --}}
                        <div class="items-center hidden md:ml-6 md:flex">
                            @foreach ($navigation as $navItem)
                                @if(isset($navItem['children']))
                                    <a
                                        href="#"
                                        class="relative inline-flex justify-center items-center px-1 pt-1 font-semibold leading-5 border-b-2 border-transparent text-theme-secondary-700 hover:text-theme-secondary-800 hover:border-theme-secondary-300 focus:outline-none transition duration-150 ease-in-out h-full @if(!$loop->first) ml-8 @endif"
                                        @click="openDropdown = openDropdown === '{{ $navItem['label'] }}' ? null : '{{ $navItem['label'] }}'"
                                    >
                                        <span :class="{ 'text-theme-primary-600': openDropdown === '{{ $navItem['label'] }}' }">{{ $navItem['label'] }}</span>
                                        <span class="ml-2 transition duration-150 ease-in-out text-theme-primary-600" :class="{ 'rotate-180': openDropdown === '{{ $navItem['label'] }}' }">@svg('chevron-down', 'h-3 w-3')</span>
                                    </a>
                                    <div x-show="openDropdown === '{{ $navItem['label'] }}'" class="absolute top-0 right-0 z-30 pb-8 mt-24 bg-white rounded-b-lg" x-cloak>
                                        <div class="pb-8 mx-8 border-t border-theme-secondary-200"></div>
                                        <div class="flex">
                                            <div class="flex-shrink-0 w-56 border-r border-theme-secondary-300">
                                                @foreach ($navItem['children'] as $childNavItem)
                                                    <div @mouseenter="selectedChild = {{ json_encode($childNavItem) }}">
                                                        <x-ark-sidebar-link :route="$childNavItem['route']" :name="$childNavItem['label']" :params="$childNavItem['params'] ?? []"/>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex flex-col flex-shrink-0 pl-8 pr-8 w-128">
                                                <img class="w-full" :src="selectedChild ? selectedChild.image : '{{ $navItem['image'] }}'" />

                                                <template x-if="selectedChild">
                                                    <span x-text="selectedChild.label" class="mb-2 text-xl font-semibold text-theme-secondary-900"></span>
                                                    <span x-text="selectedChild.description"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a
                                        href="{{ route($navItem['route'], $navItem['params'] ?? []) }}"
                                        class="inline-flex items-center px-1 pt-1 font-semibold leading-5 border-b-2 @if(Route::current()->getName() === $navItem['route']) border-theme-primary-600 text-theme-secondary-900 @else border-transparent text-theme-secondary-700 hover:text-theme-secondary-800 hover:border-theme-secondary-300 @endif focus:outline-none transition duration-150 ease-in-out h-full @if(!$loop->first) ml-8 @endif"
                                        @click="openDropdown = null;"
                                    >
                                        {{ $navItem['label'] }}
                                    </a>
                                @endif
                            @endforeach
                            <div class="hidden h-6 ml-6 border-r border-theme-secondary-100 dark:dark:border-theme-secondary-800 md:block"></div>
                        </div>
                    </div>

                    <div class="inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-4 sm:pr-0">
                        {{-- Mobile Hamburger icon --}}
                        <div class="flex items-center pr-6 border-r border-theme-secondary-300 md:hidden">
                            <button @click="open = !open" class="inline-flex items-center justify-center p-2 transition duration-150 ease-in-out rounded-md text-theme-secondary-900">
                                <span :class="{'hidden': open, 'inline-flex': !open }">@svg('menu-open', 'h-4 w-4')</span>
                                <span :class="{'hidden': !open, 'inline-flex': open }" x-cloak>@svg('menu-close', 'h-4 w-4')</span>
                            </button>
                        </div>

                        @auth
                            @if($messages ?? false)
                                <x-ark-dropdown wrapper-class="relative ml-3" dropdown-classes="w-128 mt-4">
                                    @slot('button')
                                        @svg('envelope', 'h-6 w-6')

                                        @if(!!'has unread')
                                            <div class="absolute right-0 w-3 h-3 mr-2 -mt-2 border-white rounded-full bg-theme-danger-500 border-3"></div>
                                        @endif
                                    @endslot

                                    {{ $messages }}
                                </x-ark-dropdown>
                            @endif

                            @if($notifications ?? false)
                            <div @click="livewire.emit('markNotificationsAsSeen')">
                                <x-ark-dropdown wrapper-class="ml-3 sm:relative" dropdown-classes="mt-6 md:mt-8 {{ $dropdownClasses ?? '' }}">
                                    @slot('button')
                                        @svg('notification', 'h-6 w-6 transition-default')

                                        @livewire('notifications-indicator')
                                    @endslot

                                    {{ $slot }}
                                </x-ark-dropdown>
                            </div>
                            @endif

                            <x-ark-dropdown
                                wrapper-class="relative ml-3 whitespace-no-wrap"
                                :dropdown-classes="$profileMenuClass ?? null"
                            >
                                @slot('button')
                                    <span class="relative inline-block avatar-wrapper">
                                        @if($identifier ?? false)
                                            <div x-data="{ profilePhoto: '' }" x-init="profilePhoto = createAvatar('{{ $identifier }}')" class="w-12 h-12 overflow-hidden rounded-lg md:h-16 md:w-16 md:rounded-xl">
                                                <div x-html="profilePhoto" class="object-cover w-full h-full"></div>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 overflow-hidden rounded-lg md:h-16 md:w-16 md:rounded-xl">
                                                <img class="object-cover w-full h-full" src="{{ $profilePhoto }}" alt="Profile Avatar" />
                                            </div>
                                        @endif

                                        <span
                                            class="absolute flex items-center justify-center w-6 h-6 text-white transition duration-150 ease-in-out rounded-full avatar-circle shadow-solid"
                                            style="right: -0.5rem; bottom: 30%"
                                        >
                                            <span :class="{ 'rotate-180': open }" class="w-2 h-2 transition duration-150 ease-in-out text-theme-primary-600">
                                                @svg('chevron-down')
                                            </span>
                                        </span>
                                    </span>
                                @endslot

                                @foreach ($profileMenu as $menuItem)
                                    @if ($menuItem['isPost'] ?? false)
                                        <form method="POST" action="{{ route($menuItem['route']) }}">
                                            @csrf

                                            <button
                                                type="submit"
                                                class="dropdown-entry"
                                            >
                                                @if($menuItem['icon'] ?? false)
                                                    @svg($menuItem['icon'], 'inline w-5 mr-4')
                                                @endif

                                                <span class="flex-1">{{ $menuItem['label'] }}</span>
                                            </button>
                                        </form>
                                    @else
                                        <a
                                            href="{{ route($menuItem['route']) }}"
                                            class="dropdown-entry"
                                        >
                                            @if($menuItem['icon'] ?? false)
                                                @svg($menuItem['icon'], 'inline w-5 mr-4')
                                            @endif

                                            <span class="flex-1">{{ $menuItem['label'] }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </x-ark-dropdown>
                        @else
                            <div class="items-center hidden ml-3 md:flex">
                                @if(Route::has('login'))
                                <div>
                                    <a href="{{ route('login') }}" class="link">@lang('actions.sign_in')</a>
                                </div>
                                @endif

                                @if(Route::has('register'))
                                <div>
                                    <a href="{{ route('register') }}" class="ml-4 button-secondary">@lang('actions.get_started')</a>
                                </div>
                                @endif
                            </div>

                            <div class="flex p-2 ml-6 md:hidden">
                                @if(Route::has('login'))
                                    <a href="{{ route('login') }}">@svg('sign-in', 'h-6 w-6 text-theme-secondary-900')</a>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile dropdown --}}
        <div :class="{'block': open, 'hidden': !open}" class="border-t-2 md:hidden border-theme-secondary-200">
            <div class="pt-2 pb-4 rounded-b-lg">
                @foreach ($navigation as $navItem)
                    @if(isset($navItem['children']))
                        <div class="flex w-full">
                            <div class="z-10 w-2 -mr-1"></div>
                            <a
                                href="#"
                                class="flex items-center justify-between w-full px-8 py-3 font-semibold border-l-2 border-transparent"
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
    </nav>
</div>

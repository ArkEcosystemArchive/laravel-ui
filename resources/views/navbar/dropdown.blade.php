<div class="inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-4 sm:pr-0">
    <x-ark-navbar-hamburger />

    @auth
        @isset($notifications)
            <x-ark-navbar-dropdown-notifications>
                <x-slot name="indicator">
                    {{ $notificationsIndicator }}
                </x-slot>

                {!! $notifications !!}
            </x-ark-navbar-dropdown-notifications>
        @endisset

        @isset($profile)
            {{ $profile }}
        @else
            {{-- @TODO: consider passing $attributes from parent --}}
            <x-ark-navbar-dropdown-profile
                :profile-menu="$profileMenu"
                :profile-photo="$profilePhoto"
                :profile-menu-class="$profileMenuClass ?? null"
            />
        @endisset
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

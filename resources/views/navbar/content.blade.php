@auth
    @isset($navbarNotifications)
        {{ $navbarNotifications }}
    @endisset

    @isset($notifications)
        @include('ark::navbar.notifications')
    @endisset

    @isset($profile)
        {{ $profile }}
    @else
        @include('ark::navbar.profile')
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

@auth
    @isset($navbarNotifications)
        {{ $navbarNotifications }}
    @endisset

    @isset($notifications)
        @include('ark::navbar.notifications', ['class' => 'hidden md:block'])
    @endisset

    @isset($profile)
        {{ $profile }}
    @else
        @include('ark::navbar.profile')
    @endisset
@else
    <div class="flex items-center sm:space-x-4">
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="hidden md:block link font-semibold">@lang('actions.sign_up')</a>
        @endif

        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="button-secondary">@lang('actions.sign_in')</a>
        @endif
    </div>
@endauth

@props([
    'breakpoint' => 'md',
])

@php
// Exact class strings required to prevent purging
$backdropClass = [
    'sm' => 'sm:hidden',
    'md' => 'md:hidden',
    'lg' => 'lg:hidden',
    'xl' => 'xl:hidden',
][$breakpoint ?? 'md'];

@endphp


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
    <span class="block pr-7 ml-7 h-7 border-l border-theme-secondary-300 dark:border-theme-secondary-800"></span>

    <div class="flex items-center">
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="hidden mr-4 sm:block link">@lang('actions.sign_up')</a>
        @endif

        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="ml-2 button-secondary">@lang('actions.sign_in')</a>
        @endif
    </div>
@endauth

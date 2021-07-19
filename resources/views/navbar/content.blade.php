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
    <span class="block border-l border-theme-secondary-300 dark:border-theme-secondary-800 ml-7 pr-7 h-7"></span>

    <div class="flex items-center">
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="hidden sm:block link mr-4">@lang('actions.sign_up')</a>
        @endif

        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="button-secondary ml-2">@lang('actions.sign_in')</a>
        @endif
    </div>
@endauth

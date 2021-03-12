<div class="flex flex-shrink-0 items-center">
    <a class="flex items-center" href="{{ route('home') }}" dusk="navigation-logo-link">
        @isset($logo)
            {{ $logo }}
        @else
            @svg('ark-logo-red-square', 'h-12 w-12')
            <div class="hidden ml-6 text-lg lg:block"><span class="font-black text-theme-secondary-900">ARK</span> {{ $title }}</div>
        @endisset
    </a>
</div>

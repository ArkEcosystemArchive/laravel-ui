<div class="flex items-center flex-shrink-0">
    <a class="flex items-center" href="{{ route('home') }}">
        @isset($logo)
            {{ $logo }}
        @else
            @svg('ark-logo-red-square', 'h-12 w-12')
            <div class="hidden ml-6 text-lg lg:block"><span class="font-black text-theme-secondary-900">ARK</span> {{ $title }}</div>
        @endisset
    </a>
</div>

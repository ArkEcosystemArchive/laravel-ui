<x-ark-dropdown
    wrapper-class="relative ml-3 whitespace-nowrap"
    :dropdown-classes="$profileMenuClass ?? null"
    dusk="profile-dropdown"
>
    <x-slot name="button">
        <span class="relative inline-block avatar-wrapper">
            @isset($identifier)
                <x-ark-avatar :identifier="$identifier" />
            @else
                <div class="w-12 h-12 overflow-hidden rounded-lg md:h-16 md:w-16 md:rounded-xl">
                    <img class="object-cover w-full h-full" src="{{ $profilePhoto }}" alt="Profile Avatar" />
                </div>
            @endisset

            <span
                class="absolute flex items-center justify-center w-6 h-6 text-white transition duration-150 ease-in-out rounded-full avatar-circle shadow-solid"
                style="right: -0.5rem; bottom: 30%"
            >
                <span :class="{ 'rotate-180': open }" class="w-2 h-2 transition duration-150 ease-in-out text-theme-primary-600">
                    @svg('chevron-down')
                </span>
            </span>
        </span>
    </x-slot>

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

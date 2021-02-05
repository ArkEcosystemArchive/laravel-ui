<x-ark-dropdown
    wrapper-class="relative ml-3 whitespace-nowrap"
    :dropdown-classes="$profileMenuClass ?? null"
    dusk="profile-dropdown"
>
    <x-slot name="button">
        <span class="inline-block relative avatar-wrapper">
            @isset($identifier)
                <x-ark-avatar
                    :identifier="$identifier"
                    class="w-10 h-10 rounded-lg border-2 border-transparent md:h-11 md:w-11"
                    x-bind:class="{ 'border-theme-primary-700': dropdownOpen }"
                />
            @else
                <div
                    class="overflow-hidden w-12 h-12 rounded-lg md:h-16 md:w-16 md:rounded-xl"
                >
                    <img class="object-cover w-full h-full" src="{{ $profilePhoto }}" alt="Profile Avatar" />
                </div>
            @endisset
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

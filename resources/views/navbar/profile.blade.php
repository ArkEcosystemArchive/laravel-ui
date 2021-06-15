<x-ark-dropdown
    wrapper-class="ml-3 whitespace-nowrap md:relative"
    :dropdown-classes="'w-full md:w-auto mt-4 '.($profileMenuClass ?? null)"
    dropdown-content-classes="bg-white rounded-xl shadow-lg dark:bg-theme-secondary-800 dark:text-theme-secondary-200 py-4"
    button-class="overflow-hidden border-2 border-transparent rounded-xl hover:border-theme-primary-600"
    dusk="navbar-profile-dropdown"
>
    <x-slot name="button">
        <span class="relative inline-block avatar-wrapper">
            @isset($identifier)
                <x-ark-avatar
                    :identifier="$identifier"
                    class="w-12 h-12 -m-1 rounded-xl md:h-13 md:w-13"
                    x-bind:class="{ 'border-theme-primary-600': dropdownOpen }"
                />
            @else
                <div class="w-10 h-10 overflow-hidden border-2 border-transparent rounded-xl md:w-11 md:h-11">
                    {{ $profilePhoto->img('', ['class' => 'object-cover w-full h-full', 'alt' => trans('ui::general.profile_avatar_alt')]) }}
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
                    dusk="dropdown-entry-{{ Str::slug($menuItem['label']) }}"
                >
                    @if($menuItem['icon'] ?? false)
                        @svg($menuItem['icon'], 'inline w-5 mr-4')
                    @endif

                    <span class="flex-1">{{ $menuItem['label'] }}</span>
                </button>
            </form>
        @else
            <a
                @isset($menuItem['href'])
                    href="{{ $menuItem['href'] }}"
                @else
                    href="{{ route($menuItem['route']) }}"
                @endif
                class="dropdown-entry"
                dusk="dropdown-entry-{{ Str::slug($menuItem['label']) }}"
                @foreach(Arr::get($menuItem, 'attributes', []) as $attribute => $attributeValue)
                    {{ $attribute }}="{{ $attributeValue }}"
                @endforeach
            >
                @if($menuItem['icon'] ?? false)
                    @svg($menuItem['icon'], 'inline w-5 mr-4')
                @endif

                <span class="flex-1">{{ $menuItem['label'] }}</span>
            </a>
        @endif
    @endforeach
</x-ark-dropdown>

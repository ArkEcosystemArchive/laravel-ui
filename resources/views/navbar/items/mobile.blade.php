<div :class="{'block': open, 'hidden': !open}" class="border-t-2 md:hidden border-theme-secondary-200">
    <div class="pt-2 pb-4 rounded-b-lg">
        @foreach ($navigation as $navItem)
            @if(isset($navItem['children']))
                <div class="flex w-full">
                    <div class="z-10 -mr-1 w-2"></div>
                    <a
                        href="#"
                        class="flex justify-between items-center py-3 px-8 w-full font-semibold border-l-2 border-transparent"
                        @click="openDropdown = openDropdown === '{{ $navItem['label'] }}' ? null : '{{ $navItem['label'] }}'"
                    >
                        <span :class="{ 'text-theme-primary-600': openDropdown === '{{ $navItem['label'] }}' }">{{ $navItem['label'] }}</span>
                        <span class="ml-2 transition duration-150 ease-in-out text-theme-primary-600" :class="{ 'rotate-180': openDropdown === '{{ $navItem['label'] }}' }">@svg('chevron-down', 'h-3 w-3')</span>
                    </a>
                </div>
                <div x-show="openDropdown === '{{ $navItem['label'] }}'" class="pl-8" x-cloak>
                    @foreach ($navItem['children'] as $childNavItem)
                        <div @mouseenter="selectedChild = {{ json_encode($childNavItem) }}">
                            <x-ark-sidebar-link :route="$childNavItem['route']" :name="$childNavItem['label']" :params="$childNavItem['params'] ?? []" />
                        </div>
                    @endforeach
                </div>
            @else
                <x-ark-sidebar-link :route="$navItem['route']" :name="$navItem['label']" :params="$navItem['params'] ?? []" />
            @endif
        @endforeach
    </div>
</div>

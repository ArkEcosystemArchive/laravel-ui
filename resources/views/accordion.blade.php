@props([
    'title',
    'slot',
    'dark' => false,
    'border' => true,
    'containerClass' => 'p-6',
    'titleClass' => '',
    'circleClass' => '',
    'circleSize' => 'sm',
    'toggleTitle' => false,
])

@php ($isDark = $dark)

<div x-data="{ openPanel: null }">
    <dl>
        <div class="{{ $containerClass }} @if ($isDark === false && $border) border-2 border-theme-secondary-200 rounded-lg @endif">
            <dt>
                <button
                    class="text-left w-full flex justify-between items-center rounded
                        {{ $isDark ? 'text-theme-secondary-400' : 'text-theme-secondary-900' }}"
                    :class="{ 'mb-5': openPanel }"
                    @click="openPanel = (openPanel ? null : 1)"
                >
                    <div class="text-lg font-semibold {{ $titleClass }}">
                        @if($toggleTitle)
                            <span x-show="openPanel" x-cloak>@lang('ui::actions.hide') {{ $title }}</span>
                            <span x-show="!openPanel">@lang('ui::actions.show') {{ $title }}</span>
                        @else
                            <span>{{ $title }}</span>
                        @endif
                    </div>

                    <span class="flex items-center ml-6 h-7">
                        <span
                            :class="{ 'rotate-180 text-theme-primary-500': openPanel, 'text-theme-secondary-500': !openPanel }"
                            class="transition duration-150 ease-in-out transform {{ $circleClass }}"
                        >
                            <x-ark-icon name="chevron-down" :size="$circleSize" />
                        </span>
                    </span>
                </button>
            </dt>

            <dd class="mt-2 @if($isDark) border-l border-theme-secondary-800 pl-8 @endif" x-show.transition.opacity="openPanel" x-cloak>
                {{ $slot }}
            </dd>
        </div>
    </dl>
</div>

@props([
    'title',
    'slot',
    'dark'            => false,
    'border'          => true,
    'leftBorder'      => false,
    'containerClass'  => 'p-6',
    'titleClass'      => 'text-lg font-semibold',
    'circleClass'     => '',
    'circleSize'      => 'sm',
    'toggleTitle'     => false,
    'iconOpenClass'   => 'rotate-180 text-theme-primary-500',
    'iconClosedClass' => 'text-theme-secondary-500',
    'contentClass'    => 'mt-2',
])

<div
    class="accordion"
    x-data="{ openPanel: false }"
    :class="{ 'accordion-open': openPanel }"
>
    <dl>
        <div class="{{ $containerClass }} @if ($dark === false && $border) border-2 border-theme-secondary-200 rounded-xl @endif">
            <dt>
                <button
                    class="accordion-trigger {{ $dark ? 'text-theme-secondary-400' : 'text-theme-secondary-900' }}"
                    :class="{ 'mb-5': openPanel }"
                    @click="openPanel = !openPanel"
                >
                    <div class="{{ $titleClass }}">
                        @if($toggleTitle)
                            <span x-show="openPanel" x-cloak>@lang('ui::actions.hide') {{ $title }}</span>
                            <span x-show="!openPanel">@lang('ui::actions.show') {{ $title }}</span>
                        @else
                            <span>{{ $title }}</span>
                        @endif
                    </div>

                    <span class="flex items-center h-7">
                        <span
                            :class="{
                                '{{ $iconOpenClass }}': openPanel,
                                '{{ $iconClosedClass }}': !openPanel
                            }"
                            class="transition duration-150 ease-in-out transform {{ $circleClass }}"
                        >
                            <x-ark-icon name="chevron-down" :size="$circleSize" />
                        </span>
                    </span>
                </button>
            </dt>

            <dd
                class="{{ $contentClass }} {{ $dark ? 'border-theme-secondary-800' : 'border-theme-secondary-300' }}
                    @if($dark || $leftBorder) border-l {{ $leftPadding }} @endif"
                x-show.transition.opacity="openPanel"
                x-cloak
            >
                {{ $slot }}
            </dd>
        </div>
    </dl>
</div>

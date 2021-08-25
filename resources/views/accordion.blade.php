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
    'buttonClass'     => '',
    'buttonOpenClass' => 'mb-5',
    'onToggle'        => null,
])

<div
    class="accordion"
    x-data="{
        openPanel: false,
        toggle: function () {
            this.openPanel = ! this.openPanel;
            @if($onToggle)
                ({{ $onToggle }}).call(this);
            @endif
        },
    }"
    :class="{ 'accordion-open': openPanel }"
>
    <dl>
        <div class="{{ $containerClass }} @if ($dark === false && $border) border-2 border-theme-secondary-200 rounded-xl @endif">
            <dt>
                <button
                    @click="toggle"
                    class="accordion-trigger {{ $buttonClass }} {{ $dark ? 'text-theme-secondary-400' : 'text-theme-secondary-900' }}"
                    @if($buttonOpenClass)
                        :class="{ '{{ $buttonOpenClass }}': openPanel }"
                    @endif
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
                    @if($dark || $leftBorder) border-l @endif"
                x-show.transition.opacity="openPanel"
                x-cloak
            >
                {{ $slot }}
            </dd>
        </div>
    </dl>
</div>

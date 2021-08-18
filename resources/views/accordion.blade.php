@props([
    'title',
    'slot',
    'border'          => true,
    'buttonClass'     => '',
    'buttonOpenClass' => 'mb-5',
    'circleClass'     => '',
    'circleSize'      => 'sm',
    'containerClass'  => 'p-6',
    'contentClass'    => 'mt-2',
    'dark'            => false,
    'iconOpenClass'   => 'rotate-180 text-theme-primary-500',
    'iconClosedClass' => 'text-theme-secondary-500',
    'leftBorder'      => false,
    'onToggle'        => null,
    'titleClass'      => 'text-lg font-semibold',
    'toggleTitle'     => false,
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
        <div
            @class([
                $containerClass,
                'border-2 border-theme-secondary-200 rounded-xl' => ! $dark && $border
            ])
        >
            <dt>
                <button
                    @click="toggle"
                    @class([
                        'accordion-trigger',
                        $buttonClass,
                        'text-theme-secondary-400' => $dark,
                        'text-theme-secondary-900' => ! $dark
                    ])
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
                @class([
                    $contentClass,
                    'border-theme-secondary-800' => $dark,
                    'border-theme-secondary-300' => ! $dark
                    'border-l'                   => $dark || $leftBorder
                ])
                x-show.transition.opacity="openPanel"
                x-cloak
            >
                {{ $slot }}
            </dd>
        </div>
    </dl>
</div>

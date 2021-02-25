@props([
    'title',
    'reverse' => false,
    'iconWrapper' => null,
    'iconWrapperClass' => '',
    'iconTextClass' => '',
    'iconClass' => '',
    'icon' => null,
    'iconRaw' => null,
    'noBorder' => false,
    'shallow' => false,
    'tooltip' => null,
    'verticalPosition' => 'center',
])

<div {{ $attributes->class([
    'flex detail-box',
    'flex-row-reverse' => $reverse,
    'items-start' => $verticalPosition === 'top',
    'items-center' => $verticalPosition === 'center',
    'items-end' => $verticalPosition === 'bottom',
]) }}>
    @if ($iconWrapper)
        {{ $iconWrapper }}
    @elseif ($icon || $iconRaw)
        @if ($noBorder)
            <div class="{{ $verticalPosition === 'top' ? 'mt-0.5' : '' }} flex-shrink-0 text-theme-secondary-900 dark:text-theme-secondary-600 {{ $iconWrapperClass }} @unless ($reverse) mr-5 @else ml-5 @endif">
                @if ($icon)
                    <x-ark-icon :name="$icon" />
                @else
                    {{ $iconRaw }}
                @endif
            </div>
        @elseif ($shallow)
            <div class="{{ $verticalPosition === 'top' ? 'mt-0.5' : '' }} flex-shrink-0 circled-icon text-theme-secondary-900 dark:text-theme-secondary-600 border-theme-secondary-900 dark:border-theme-secondary-600 {{ $iconWrapperClass }} @unless ($reverse) mr-5 @else ml-5 @endif">
                @if ($icon)
                    <x-ark-icon :name="$icon" />
                @else
                    {{ $iconRaw }}
                @endif
            </div>
        @else
            <div class="{{ $verticalPosition === 'top' ? 'mt-0.5' : '' }} flex items-center justify-center p-2 rounded-full h-12 w-12 flex-shrink-0 bg-theme-secondary-200 dark:bg-theme-secondary-800 {{ $iconWrapperClass }} @unless ($reverse) mr-5 @else ml-5 @endif">
                @if ($icon)
                    <x-ark-icon :name="$icon" :class="$iconTextClass.' '.$iconClass" />
                @else
                    {{ $iconRaw }}
                @endif
            </div>
        @endif
    @endif

    <div class="flex flex-col space-y-2">
        <span class="text-sm font-semibold text-theme-secondary-500 dark:text-theme-secondary-700">
            {{ $title }}
        </span>

        <div @if ($tooltip) data-tippy-content="{{ $tooltip }}" @endif>
            @if((string) $slot === "")
                <span class="font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">
                    @lang('generic.not_specified')
                </span>
            @else
                <span class="font-semibold text-theme-secondary-700 dark:text-theme-secondary-200">
                    {{ $slot }}
                </span>
            @endif
        </div>
    </div>
</div>

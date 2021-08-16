@props([
    'type',
    'size'    => 'base',
    'tooltip' => null,
])

@php
    if ($size === 'lg') {
        $icon = Arr::get([
            'undefined' => 'circle.large.question-mark',
            'online' => 'circle.large.checkmark',
            'stopped' => 'circle.large.pause',
            'stopping' => 'circle.large.hand',
            'waiting restart' => 'circle.large.clock',
            'launching' => 'circle.large.play',
            'errored' => 'circle.large.cross',
            'one-launch-status' => 'circle.forward',
        ], $type, 'undefined');

        $size = '2xl';
    } else {
        $icon = Arr::get([
            'undefined' => 'circle.question-mark',
            'online' => 'circle.checkmark',
            'stopped' => 'circle.pause',
            'stopping' => 'circle.hand',
            'waiting restart' => 'clock',
            'launching' => 'circle.play',
            'errored' => 'circle.cross',
            'one-launch-status' => 'circle.forward',
        ], $type, 'undefined');
    }

    $iconColor = Arr::get([
        'undefined' => 'text-theme-secondary-700',
        'online' => 'text-theme-success-600',
        'stopped' => 'text-theme-warning-500',
        'stopping' => 'text-theme-warning-500',
        'waiting restart' => 'text-theme-hint-400',
        'launching' => 'text-theme-primary-500',
        'errored' => 'text-theme-danger-400',
        'one-launch-status' => 'text-theme-info-500',
    ], $type, 'text-theme-secondary-700');
@endphp

<div
    class="flex flex-shrink-0 justify-center items-center"
    @if ($tooltip)
        data-tippy-content="{{ $tooltip }}"
    @endif
>
    <x-ark-icon
        :name="$icon"
        :size="$size"
        :class="$iconColor"
    />
</div>

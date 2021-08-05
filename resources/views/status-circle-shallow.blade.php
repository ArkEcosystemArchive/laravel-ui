@props([
    'type',
    'size'          => 'base',
    'containerSize' => 'base',
    'tooltip'       => null,
])

@php
    $size = [
        'sm'   => in_array($type, ['success', 'failed', 'error']) ? 'h-1 w-1' : 'w-2 h-2',
        'md'   => in_array($type, ['success', 'failed', 'error']) ? 'h-3 w-3' : 'w-4 h-4',
        'lg'   => in_array($type, ['success', 'failed', 'error']) ? 'h-4 w-4' : 'w-5 h-5',
        'xl'   => in_array($type, ['success', 'failed', 'error']) ? 'h-5 w-5' : 'w-6 h-6',
        'base' => in_array($type, ['success', 'failed', 'error']) ? 'h-2 w-2' : 'h-3 w-3',
    ][$size];

    $containerSize = [
        'sm'   => 'w-4 h-4',
        'md'   => 'w-8 h-8',
        'lg'   => 'w-10 h-10',
        'xl'   => 'w-12 h-12',
        '2xl'  => 'w-14 h-14',
        'base' => 'w-6 h-6',
    ][$containerSize];

    $icon = Arr::get([
        'success' => 'checkmark-smooth',
        'failed' => 'cross',
        'error' => 'cross',
        'running' => 'update',
        'paused' => 'pause',
        'updated' => 'update',
        'locked' => 'lock',
        'errored' => 'errored',
        'launching' => 'launching',
        'one-launch-status' => 'one-status-launch',
        'online' => 'online',
        'stopped' => 'stopped',
        'stopping' => 'stopping',
        'waiting-restart' => 'waiting-restart',
        'emergency' => 'cross',
        'alert'     => 'cross',
        'critical'  => 'cross',
        'warning'   => 'exclamation-mark',
        'notice'    => 'question-mark',
        'info'      => 'info',
        'undefined' => 'undefined',
    ], $type, 'undefined');

    $borderColor = Arr::get([
        'success' => 'border-theme-success-600',
        'failed' => 'border-theme-danger-400',
        'error' => 'border-theme-danger-400',
        'running' => 'border-theme-warning-900',
        'paused' => 'border-theme-warning-500',
        'updated' => 'border-theme-warning-900',
        'locked' => 'border-theme-secondary-700',
        'errored' => 'border-theme-danger-400',
        'launching' => 'border-theme-primary-500',
        'one-launch-status' => 'border-theme-info-500',
        'online' => 'border-theme-success-600',
        'stopped' => 'border-theme-warning-500',
        'stopping' => 'border-theme-warning-500',
        'waiting-restart' => 'border-theme-hint-400',
        'emergency' => 'border-theme-danger-400',
        'alert'     => 'border-theme-danger-400',
        'critical'  => 'border-theme-danger-400',
        'warning'   => 'border-theme-warning-400',
        'notice'    => 'border-theme-hint-400',
        'info'      => 'border-theme-info-400',
        'undefined' => 'border-theme-secondary-700',
    ], $type, 'border-theme-secondary-700');

    $iconColor = Arr::get([
        'success' => 'text-theme-success-600',
        'failed' => 'text-theme-danger-400',
        'error' => 'text-theme-danger-400',
        'running' => 'text-theme-warning-900',
        'paused' => 'text-theme-warning-500',
        'updated' => 'text-theme-warning-900',
        'locked' => 'text-theme-secondary-700',
        'errored' => 'text-theme-danger-400',
        'launching' => 'text-theme-primary-500',
        'one-launch-status' => 'text-theme-info-500',
        'online' => 'text-theme-success-600',
        'stopped' => 'text-theme-warning-500',
        'stopping' => 'text-theme-warning-500',
        'waiting-restart' => 'text-theme-hint-400',
        'emergency' => 'text-theme-danger-400',
        'alert'     => 'text-theme-danger-400',
        'critical'  => 'text-theme-danger-400',
        'warning'   => 'text-theme-warning-400',
        'notice'    => 'text-theme-hint-400',
        'info'      => 'text-theme-info-400',
        'undefined' => 'text-theme-secondary-700',
    ], $type, 'text-theme-secondary-700');
@endphp

<div
    class="flex items-center justify-center flex-shrink-0 border-2 rounded-full {{ $borderColor }} {{ $containerSize }}"
    @if ($tooltip)
        data-tippy-content="{{ $tooltip }}"
    @endif
>
    @svg($icon, $iconColor.' '.$size)
</div>

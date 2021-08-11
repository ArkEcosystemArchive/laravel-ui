@props([
    'type',
    'size'          => 'base',
    'containerSize' => 'base',
    'tooltip'       => null,
])

@php
    $icon = Arr::get([
        'success' => 'status.success',
        'failed' => 'status.error',
        'error' => 'status.error',
        // 'running' => 'update',
        // 'paused' => 'pause',
        // 'updated' => 'update',
        // 'locked' => 'lock',
        'errored' => 'status.error',
        // 'launching' => 'launching',
        // 'one-launch-status' => 'one-status-launch',
        'online' => 'status.success',
        // 'stopped' => 'pause',
        // 'stopping' => 'stopping',
        'waiting-restart' => 'status.debug',
        'emergency' => 'status.error',
        'alert'     => 'status.error',
        'critical'  => 'status.error',
        'warning'   => 'status.warning',
        'notice'    => 'status.hint',
        'info'      => 'status.info',
        'undefined' => 'status.hint',
    ], $type, 'undefined');

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
    class="flex items-center justify-center flex-shrink-0"
    @if ($tooltip)
        data-tippy-content="{{ $tooltip }}"
    @endif
>
    <x-ark-icon
        :name="$icon"
        size="$size"
        :class="$iconColor"
    />
</div>

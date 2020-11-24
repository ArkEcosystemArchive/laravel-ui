@php
    $size = [
        'sm'   => in_array($type, ['success', 'failed', 'error']) ? 'h-1 w-1' : 'w-2 h-2',
        'md'   => in_array($type, ['success', 'failed', 'error']) ? 'h-3 w-3' : 'w-4 h-4',
        'lg'   => in_array($type, ['success', 'failed', 'error']) ? 'h-4 w-4' : 'w-5 h-5',
        'xl'   => in_array($type, ['success', 'failed', 'error']) ? 'h-5 w-5' : 'w-6 h-6',
        'base' => in_array($type, ['success', 'failed', 'error']) ? 'h-2 w-2' : 'h-3 w-3',
    ][$size ?? 'base'];

    $containerSize = [
        'sm'   => 'w-4 h-4',
        'md'   => 'w-8 h-8',
        'lg'   => 'w-10 h-10',
        'xl'   => 'w-12 h-12',
        '2xl'  => 'w-14 h-14',
        'base' => 'w-6 h-6',
    ][$containerSize ?? 'base'];

    $icon = [
        'success' => 'checkmark',
        'failed' => 'cross',
        'error' => 'cross',
        'running' => 'update',
        'paused' => 'update',
        'updated' => 'update',
        'locked' => 'lock',
    ][$type];

    $color = [
        'success' => 'success-600',
        'failed' => 'danger-400',
        'error' => 'danger-400',
        'running' => 'warning-900',
        'paused' => 'warning-500',
        'updated' => 'warning-900',
        'locked' => 'secondary-700',
    ][$type];
@endphp

<div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-{{ $color }} {{ $containerSize }}">
    @svg($icon, 'text-theme-'.$color.' '.$size)
</div>

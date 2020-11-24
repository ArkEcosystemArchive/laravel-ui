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
@endphp

@if ($type === 'success')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-success-600 {{ $containerSize }}">
        @svg('checkmark', 'text-theme-success-600 '.$size)
    </div>
@elseif ($type === 'failed' || $type === 'error')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-danger-400 {{ $containerSize }}">
        @svg('cross', 'text-theme-danger-400 '.$size)
    </div>
@elseif ($type === 'running')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-warning-900 {{ $containerSize }}">
        @svg('update', 'text-theme-warning-900 animation-spin '.$size)
    </div>
@elseif ($type === 'paused')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-warning-500 {{ $containerSize }}">
        @svg('update', 'text-theme-warning-500 '.$size)
    </div>
@elseif ($type === 'updated')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-warning-900 {{ $containerSize }}">
        @svg('update', 'text-theme-warning-900 '.$size)
    </div>
@elseif ($type === 'locked')
    <div class="flex items-center justify-center flex-shrink-0 border-2 rounded-full border-theme-secondary-700 {{ $containerSize }}">
        @svg('lock', 'text-theme-secondary-700 '.$size)
    </div>
@endif

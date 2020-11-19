@if ($type === 'success')
    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 border-2 rounded-full border-theme-success-600">
        @svg($icon, 'text-theme-success-600 h-3 w-3')
    </div>
@elseif ($type === 'failed')
    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 border-2 rounded-full border-theme-danger-400">
        @svg('cross', 'text-theme-danger-400 h-2 w-2')
    </div>
@elseif ($type === 'running')
    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 border-2 rounded-full border-theme-warning-900">
        @svg('update', 'text-theme-warning-900 h-3 w-3 animation-spin')
    </div>
@elseif ($type === 'paused')
    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 border-2 rounded-full border-theme-warning-500">
        @svg('update', 'text-theme-warning-500 h-3 w-3')
    </div>
@elseif ($type === 'updated')
    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 border-2 rounded-full border-theme-warning-900">
        @svg('update', 'text-theme-warning-900 h-3 w-3')
    </div>
@elseif ($type === 'locked')
    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 border-2 rounded-full border-theme-secondary-700">
        @svg('lock', 'text-theme-secondary-700 h-3 w-3')
    </div>
@endif

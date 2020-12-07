@if ($type === 'success')
    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full bg-theme-success-200">
        @svg('checkmark', 'text-theme-success-500 h-3 w-3')
    </div>
@elseif ($type === 'failed' || $type === 'error')
    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full bg-theme-danger-100">
        @svg('cross', 'text-theme-danger-500 h-2 w-2')
    </div>
@elseif ($type === 'running')
    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full bg-theme-warning-100">
        @svg('update', 'text-theme-warning-900 h-3 w-3 animation-spin')
    </div>
@elseif ($type === 'updated')
    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full bg-theme-warning-100">
        @svg('update', 'text-theme-warning-900 h-3 w-3')
    </div>
@elseif ($type === 'active')
    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full border-2 box-border border-theme-primary-500"></div>
@elseif ($type === 'locked')
    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full bg-theme-secondary-300">
        @svg('lock', 'text-theme-secondary-700 h-3 w-3')
    </div>
@else
    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full bg-theme-secondary-300"></div>
@endif

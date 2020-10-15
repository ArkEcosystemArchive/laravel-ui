<div class="relative inline-block pointer-events-none avatar-wrapper">
    <div class="relative w-12 h-12">
        <img class="object-cover rounded-md" src="{{ $logo }}" />

        <div
            class="absolute flex items-center justify-center text-transparent rounded-full avatar-circle shadow-solid"
            style="right: -0.5rem; bottom: -0.5rem;"
        >
            <div class="flex flex-shrink-0 items-center justify-center rounded-full {{ $stateColor ?? 'bg-white' }} h-8 w-8">
                @if ($type === 'danger')
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-danger-200">
                        @svg('exclamation', 'text-theme-danger-500 h-5 w-5')
                    </div>
                @elseif ($type === 'success')
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-success-200">
                        @svg('checkmark', 'text-theme-success-500 h-3 w-3')
                    </div>
                @elseif ($type === 'warning')
                    <div class="flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-full bg-theme-warning-200">
                        @svg('notification', 'text-theme-warning-500 h-3 w-3')
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

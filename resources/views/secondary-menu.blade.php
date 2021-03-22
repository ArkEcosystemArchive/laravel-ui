<div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block w-full text-left">
    <div>
        <button
            @click="open = !open"
            type="button"
            class="relative inline-flex items-center justify-start w-full px-4 py-3 border rounded-lg border-theme-secondary-200"
        >
            @svg('menu-open', 'h-4 w-4 text-theme-secondary-900 mr-3')
            <span class="font-semibold text-theme-secondary-900">{{ $title }}</span>
        </button>
    </div>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 w-full max-w-full mt-2 origin-top rounded-md shadow-lg"
        x-cloak
    >
        <div class="w-full py-4 bg-white rounded-md shadow-lg {{ $navigationClass ?? '' }}">
            {{ $navigation }}
        </div>
    </div>
</div>

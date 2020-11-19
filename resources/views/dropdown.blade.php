@php($dropdownProperty = $dropdownProperty ?? 'dropdownOpen')

<div
    @if ($initAlpine ?? true) x-data="{ {{ $dropdownProperty }}: false }" @endif
    @if($closeOnBlur ?? true)
        @keydown.escape="{{ $dropdownProperty }} = false"
        @click.away="{{ $dropdownProperty }} = false"
    @endif
    class="{{ $wrapperClass ?? '' ? $wrapperClass : 'absolute inline-block top-0 right-0 text-left' }}"
>
    <div>
        <button
            @click="{{ $dropdownProperty }} = !{{ $dropdownProperty }}"
            :class="{ 'text-theme-primary-500' : {{ $dropdownProperty }} }"
            class="flex text-theme-secondary-400 items-center hover:text-theme-primary-500 focus:outline-none p-3 {{ $buttonClass ?? '' ? $buttonClass : '' }}"
        >
            @if($button ?? false)
                {{ $button }}
            @else
                @svg('vertical-dots', 'h-5 w-5')
            @endif
        </button>
    </div>
    <div
        x-show="{{ $dropdownProperty }}"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 rounded-md shadow-lg z-10 {{ $dropdownClasses ?? 'w-40' }}"
    >
        <div class="bg-white rounded-md shadow-xs dark:bg-theme-secondary-800 dark:text-theme-secondary-200" x-cloak>
            <div class="py-1" @if($closeOnClick ?? true) @click="{{ $dropdownProperty }} = !{{ $dropdownProperty }}" @endif>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

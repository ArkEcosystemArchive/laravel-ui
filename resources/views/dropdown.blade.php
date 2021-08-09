@props([
    'button'                 => false,
    'dropdownProperty'       => 'dropdownOpen',
    'dropdownContentClasses' => 'bg-white rounded-xl shadow-lg dark:bg-theme-secondary-800 dark:text-theme-secondary-200',
    'buttonClassExpanded'    => 'text-theme-primary-500',
    'buttonClass'            => 'text-theme-secondary-400 hover:text-theme-primary-500',
    'dropdownClasses'        => 'w-40',
    'wrapperClass'           => 'absolute inline-block top-0 right-0 text-left',
    'fullScreen'             => false,
    'dusk'                   => false,
    'buttonTooltip'          => null,
    'initAlpine'             => true,
    'closeOnBlur'            => true,
    'closeOnClick'           => true,
    'disabled'               => false,
    'repositionOnOpen'       => true,
    'onClosed'               => null,
])

<div
    @if ($initAlpine)
        x-data="Dropdown.setup('{{ $dropdownProperty }}', {
            @if($onClosed)
                onClosed: ({{ $onClosed }}),
            @endif
            repositionOnOpen: {{ $repositionOnOpen ? 'true' : 'false' }},
        })"
        x-init="init"
    @endif
    @if($closeOnBlur)
        @keydown.escape="{{ $dropdownProperty }} = false"
        @click.away="{{ $dropdownProperty }} = false"
    @endif
    @if($dusk) dusk="{{ $dusk }}" @endif
    class="dropdown-container @if($wrapperClass) {{ $wrapperClass }} @endif"
>
    <div>
        <button
            type="button"
            :class="{ '{{ $buttonClassExpanded }}' : {{ $dropdownProperty }} }"
            class="flex items-center focus:outline-none dropdown-button transition-default {{ $buttonClass }}"
            @if($disabled) disabled @else @click="toggle" @endif
            @if($buttonTooltip) data-tippy-content="{{ $buttonTooltip }}" @endif
        >
            @if($button)
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
        class="origin-top-right absolute right-0 mt-2 z-10 dropdown {{ $dropdownClasses }} {{ $fullScreen ? 'w-screen -mx-8 md:w-auto md:mx-0' : '' }}"
    >
        <div class="{{ $dropdownContentClasses }}" x-cloak>
            <div
                class="py-1"
                @if($closeOnClick) @click="{{ $dropdownProperty }} = !{{ $dropdownProperty }}" @endif
            >
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

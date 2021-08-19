@props([
    'initAlpine'             => true,
    'button'                 => null,
    'buttonClass'            => 'text-theme-secondary-400 hover:text-theme-primary-500',
    'buttonClassExpanded'    => 'text-theme-primary-500',
    'buttonTooltip'          => null,
    'closeOnBlur'            => true,
    'disabled'               => false,
    'dropdownClasses'        => 'w-40',
    'dropdownContentClasses' => 'bg-white rounded-xl shadow-lg dark:bg-theme-secondary-800 dark:text-theme-secondary-200',
    'dropdownOriginClass'    => 'origin-top-right',
    'dropdownProperty'       => 'dropdownOpen',
    'dusk'                   => false,
    'fullScreen'             => false,
    'height'                 => null,
    'onClose'                => null,
    'wrapperClass'           => 'absolute inline-block top-0 right-0 text-left',
])

<div
    @if ($initAlpine)
        x-data="{ {{ $dropdownProperty }}: false }"
        x-init="$watch('{{ $dropdownProperty }}', (expanded) => {
            if (expanded) {
                $nextTick(() => {
                    $el.querySelectorAll('img[onload]').forEach(img => {
                        if (img.onload) {
                            img.onload();
                            img.removeAttribute('onload');
                        }
                    });
                })
            @if($onClose)
            } else {
                $nextTick(() => {
                    ({{ $onClose }})($el);
                });
            @endif
            }
        })"
    @endif
    @if($closeOnBlur)
        @keydown.escape="{{ $dropdownProperty }} = false"
        @click.away="{{ $dropdownProperty }} = false"
    @endif
    @if($wrapperClass) class="{{ $wrapperClass }}" @endif
    @if($dusk) dusk="{{ $dusk }}" @endif
>
    <div>
        <button
            type="button"
            :class="{ '{{ $buttonClassExpanded }}' : {{ $dropdownProperty }} }"
            class="flex items-center focus:outline-none dropdown-button transition-default {{ $buttonClass }}"
            @if($disabled) disabled @else @click="{{ $dropdownProperty }} = !{{ $dropdownProperty }}" @endif
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
        {{--TODO: Unable to use @class here, will make \ProfileTest > it should render the [profileMenuClass] attribute fail --}}
        class="absolute right-0 mt-2 z-10 dropdown {{ $dropdownClasses }} {{ $fullScreen ? 'w-screen -mx-8 md:w-auto md:mx-0' : '' }}"
        @if ($height) data-height="{{ $height }}" @endif
    >
        <div class="{{ $dropdownContentClasses }}" x-cloak>
            <div class="py-1" @if($closeOnClick ?? true) @click="{{ $dropdownProperty }} = !{{ $dropdownProperty }}" @endif>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
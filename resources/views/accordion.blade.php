@php ($isDark = $dark ?? false)
<div x-data="{ openPanel: null }">
    <dl>
        <div class="{{ $containerClass ?? 'p-6' }} @if($isDark === false) border-2 border-theme-secondary-200 rounded-lg @endif">
            <dt>
                <button
                    type="button"
                    class="text-left w-full flex justify-between items-center focus:outline-none
                        @if($isDark) text-theme-secondary-400 @else text-theme-secondary-900 @endif"
                    :class="{ 'mb-5': openPanel }"
                    @click="openPanel = (openPanel ? null : 1)"
                >
                    <span class="text-lg font-semibold">
                        {{ $title }}
                    </span>

                    <span class="flex items-center ml-6 h-7">
                        <span
                            :class="{ 'rotate-180 text-theme-primary-500': openPanel, 'text-theme-secondary-500': !openPanel }"
                            class="transition duration-150 ease-in-out transform"
                        >
                            @svg('chevron-down', 'h-4 w-4')
                        </span>
                    </span>
                </button>
            </dt>

            <dd class="mt-2 @if($isDark) border-l border-theme-secondary-800 pl-8 @endif" x-show.transition.opacity="openPanel" x-cloak>
                {{ $slot }}
            </dd>
        </div>
    </dl>
</div>

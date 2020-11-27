<div x-data="{ actionOpen: false, value: '{{ $time ?? '00:00' }}' }" class="flex-1">
    <x-ark-dropdown
        wrapper-class="relative w-full"
        button-class="w-full rounded shadow-sm form-select"
        dropdown-classes="left-0 w-32 z-10"
        dropdown-property="actionOpen"
        :init-alpine="false"
    >
        @slot('button')
            <div x-text="value" class="text-theme-secondary-900"></div>
        @endslot

        <div
            class="items-center justify-center block h-40 overflow-y-scroll text-theme-secondary-900 dropdown-scrolling"
            wire:model="{{ $name ?? $id }}"
        >
            @for ($hour = 0; $hour < 24; $hour++)
                @for ($minute = 0; $minute < 60; $minute += 30)
                    @php($value = str_pad($hour, 2, '0', STR_PAD_LEFT).':'.str_pad($minute, 2, '0', STR_PAD_LEFT))

                    <div
                        class="justify-center py-2 cursor-pointer dropdown-entry"
                        @click="value = '{{ $value }}'; $dispatch('input', '{{ $value }}');"
                    >
                        {{ $value }}
                    </div>
                @endfor
            @endfor

            <input type="hidden" x-bind:value="value" />
        </div>
    </x-ark-dropdown>
</div>

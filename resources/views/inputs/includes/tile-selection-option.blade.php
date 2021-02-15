<label
    wire:key="tile-selection-option-{{ $option['id'] }}"
    class="{{ $single ? 'tile-selection-single' : 'tile-selection-option' }}"
    x-bind:class="{
        @if ($mobileHidden) 'hidden sm:block': mobileHidden, @endif
        @if ($single)
            'tile-selection--checked': '{{ $option['id'] }}' === selectedOption }",
        @else
            'tile-selection--checked': options['{{ $option['id'] }}'].checked }",
        @endif
    }"
>
    @if ($single)
        <input
            id="{{ $id.'-'.$option['id'] }}"
            name="{{ $id }}"
            type="radio"
            class="hidden"
            x-model="selectedOption"
            value="{{ $option['id'] }}"
            wire:model="{{ $wireModel }}"
        />
    @else
        <input
            id="{{ $id.'-'.$option['id'] }}"
            name="{{ $option['id'] }}"
            type="checkbox"
            class="form-checkbox tile-selection-checkbox"
            x-model="options['{{ $option['id'] }}'].checked"
            wire:model="{{ $wireModel }}"
        />
    @endif

    <div class="{{ $iconWrapper ?? 'flex flex-col justify-center items-center md:space-y-2 h-full' }}">
        @unless ($withoutIcon ?? false)
            <div class="{{ $iconBreakpoints ?? '' }}">
                <x-ark-icon :name="$option['icon']" size="md" />
            </div>
        @endunless

        <div class="{{ $optionTitleClass ?? 'font-semibold' }}">{{ $option['title'] }}</div>
    </div>
</label>

<label
    wire:key="tile-selection-option-{{ $option['id'] }}"
    class="{{ $single ? 'tile-selection-single' : 'tile-selection-option' }} {{ $isDisabled && ! $option['checked'] ? 'disabled-tile' : '' }}"
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
        {{--TODO: Present in the HTML but not displayed, maybe because of the disabled of the input ?--}}
        <div
            @if($isDisabled)
                data-tippy-content="{{ $disabledCheckboxTooltip }}"
            @endif
        >
            <input
                id="{{ $id.'-'.$option['id'] }}"
                name="{{ $option['id'] }}"
                type="checkbox"
                class="form-checkbox tile-selection-checkbox"
                x-model="options['{{ $option['id'] }}'].checked"
                wire:model="{{ $wireModel }}"
                @if($isDisabled && ! $option['checked'])
                    disabled
                @endif
            />
        </div>
    @endif

    <div class="{{ $iconWrapper }}">
        @unless ($withoutIcon)
            <div class="{{ $iconBreakpoints }}">
                <x-ark-icon :name="$option['icon']" size="md" />
            </div>
        @endunless

        <div class="{{ $optionTitleClass }}">{{ $option['title'] }}</div>
    </div>
</label>

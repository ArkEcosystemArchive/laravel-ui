@props([
    'id',
    'option',
    'wireModel',
    'single' => 'false',
])

<label
    wire:key="tile-selection-option-{{ $option['name'] }}"
    class="{{ $single ? 'tile-selection-single' : 'tile-selection' }}"
    @if ($single)
        x-bind:class="{ 'tile-selection--checked': '{{ $option['name'] }}' === selectedOption }"
    @else
        x-bind:class="{ 'tile-selection--checked': options['{{ $option['name'] }}'].checked }"
    @endif
>
    @if ($single)
        <input
            id="{{ $id.'-'.$option['name'] }}"
            name="{{ $id }}"
            type="radio"
            class="hidden"
            x-model="selectedOption"
            value="{{ $option['name'] }}"
            wire:model="{{ $wireModel }}"
        />
    @else
        <input
            id="{{ $id.'-'.$option['name'] }}"
            name="{{ $option['name'] }}"
            type="checkbox"
            class="form-checkbox tile-selection-checkbox"
            x-model="options['{{ $option['name'] }}'].checked"
            wire:model="{{ $wireModel }}"
        />
    @endif

    <div class="flex flex-col justify-center items-center space-y-2 h-full font-semibold">
        @unless ($single)
            <x-ark-icon :name="$option['icon']" size="md" />
        @endunless

        <div>{{ $option['title'] }}</div>
    </div>
</label>

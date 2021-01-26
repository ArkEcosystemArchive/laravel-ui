@props([
    'id',
    'option',
    'wireModel',
    'single' => false,
    'mobileHidden' => false,
])

<label
    wire:key="tile-selection-option-{{ $option['id'] }}"
    class="{{ $single ? 'tile-selection-single' : 'tile-selection' }}"
    x-bind:class="{
        @if ($mobileHidden) 'hidden sm:block': mobileHidden, @endif
        'tile-selection--checked': {{ $single ?
                                        "'".$option['id']."' === selectedOption" :
                                        'options["'.$option['id'].'"].checked' }},
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

    <div class="flex flex-col justify-center items-center space-y-2 h-full font-semibold">
        @unless ($single)
            <x-ark-icon :name="$option['icon']" size="md" />
        @endunless

        <div>{{ $option['title'] }}</div>
    </div>
</label>

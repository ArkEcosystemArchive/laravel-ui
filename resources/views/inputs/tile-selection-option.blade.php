@props([
    'id',
    'option',
])

<label class="tile-selection" x-bind:class="{ 'tile-selection--checked': options['{{ $option['name'] }}'].checked }">
    <input
        id="{{ $id.'-'.$option['name'] }}"
        name="{{ $option['name'] }}"
        type="checkbox"
        class="form-checkbox tile-selection-checkbox"
        x-model="options['{{ $option['name'] }}'].checked"
    />

    <div class="h-full flex flex-col justify-center items-center space-y-2 font-semibold">
        <x-ark-icon :name="$option['icon']" size="md" />

        <div>{{ $option['title'] }}</div>
    </div>
</label>

@props([
    'id',
    'option',
])

{{-- @props([
    'name',
    'icon',
    'title',
    'id'       => '',
    'model'    => '',
    'value'    => null,
    'checked'  => null,
    'disabled' => null,
]) --}}

<label class="square-selection" x-bind:class="{ 'square-selection--checked': options['{{ $option['name'] }}'].checked }">
    <input
        id="{{ $id.'-'.$option['name'] }}"
        name="{{ $option['name'] }}"
        type="checkbox"
        class="form-checkbox square-selection-checkbox"
        x-model="options['{{ $option['name'] }}'].checked"
        {{-- wire:model="{{ $model ?? $name }}" --}}
        {{-- @if ($option['value']) value="{{ $option['value'] }}" @endif
        @if ($checked ?? '') checked @endif
        @if ($disabled ?? '') disabled @endif --}}
    />

    <div class="h-full flex flex-col justify-center items-center space-y-2 font-semibold">
        <x-ark-icon :name="$option['icon']" size="md" />

        <div>{{ $option['title'] }}</div>
    </div>
</label>

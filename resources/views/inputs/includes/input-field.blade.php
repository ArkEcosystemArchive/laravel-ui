@props([
    'name',
    'errors',
    'type'         => 'text',
    'id'           => null,
    'class'        => '',
    'inputClass'   => 'input-text',
    'errorClass'   => 'input-text--error',
    'noModel'      => false,
    'model'        => null,
    'keydownEnter' => null,
    'max'          => null,
    'attributes'   => $attributes,
])

<input
    type="{{ $type }}"
    id="{{ $id ?? $name }}"
    class="{{ $inputClass }} @error($name) {{ $errorClass }} @enderror {{ $class }}"
    @unless ($noModel) wire:model="{{ $model ?? $name }}" @endUnless
    {{-- @TODO: remove --}}
    @if ($keydownEnter) wire:keydown.enter="{{ $keydownEnter }}" @endif

    {{ $attributes->except([
        'class',
        'errors',
        'id',
        'model',
        'slot',
        'type',
        'wire:model',
        'keydown-enter'
    ]) }}
/>

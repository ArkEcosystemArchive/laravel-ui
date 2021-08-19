@props([
    'name',
    'attributes'     => $attributes,
    'autocapitalize' => 'none',
    'errorClass'     => 'input-text--error',
    'errors'         => null,
    'id'             => null,
    'inputClass'     => '',
    'inputTypeClass' => 'input-text',
    'keydownEnter'   => null,
    'max'            => null,
    'model'          => null,
    'noModel'        => false,
    'type'           => 'text',
    'value'          => null,
])

<input
    type="{{ $type }}"
    id="{{ $id ?? $name }}"
    name="{{ $name }}"
    class="{{ $inputClass }} {{ $inputTypeClass }} @if ($errors) @error($name) {{ $errorClass }} @enderror @endif"
    @unless ($noModel) wire:model="{{ $model ?? $name }}" @endUnless
    {{-- @TODO: remove --}}
    @if ($keydownEnter) wire:keydown.enter="{{ $keydownEnter }}" @endif
    {{-- @TODO: remove --}}
    @if ($max) maxlength="{{ $max }}" @endif
    autocapitalize="{{ $autocapitalize }}"
    @if($value) value="{{ $value }}"@endif

    {{ $attributes->except([
        'autocapitalize',
        'class',
        'container-class',
        'hide-label',
        'errors',
        'id',
        'max',
        'model',
        'slot',
        'type',
        'wire:model',
        'keydown-enter',
    ]) }}
/>

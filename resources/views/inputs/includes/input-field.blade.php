@props([
    'name',
    'errors',
    'type'           => 'text',
    'id'             => null,
    'inputClass'     => '',
    'inputTypeClass' => 'input-text',
    'errorClass'     => 'input-text--error',
    'noModel'        => false,
    'model'          => null,
    'keydownEnter'   => null,
    'max'            => null,
    'attributes'     => $attributes,
    'autocapitalize' => 'none',
])

<input
    type="{{ $type }}"
    id="{{ $id ?? $name }}"
    name="{{ $name }}"
    class="{{ $inputClass }} {{ $inputTypeClass }} @error($name) {{ $errorClass }} @enderror"
    @unless ($noModel) wire:model="{{ $model ?? $name }}" @endUnless
    {{-- @TODO: remove --}}
    @if ($keydownEnter) wire:keydown.enter="{{ $keydownEnter }}" @endif
    {{-- @TODO: remove --}}
    @if ($max) maxlength="{{ $max }}" @endif
    autocapitalize="{{ $autocapitalize }}"

    {{ $attributes->except([
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

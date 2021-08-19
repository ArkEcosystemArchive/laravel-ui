@props([
    'name',
    'alpine'           => false,
    'checked'          => false,
    'class'            => 'mt-4',
    'disabled'         => false,
    'id'               => null,
    'label'            => null,
    'labelClasses'     => '',
    'model'            => null,
    'right'            => false,
    'value'            => null,
    'verticalPosition' => 'middle',
])

@php
    if ($verticalPosition === 'middle') {
        $verticalPositionClass = 'items-center';
    }

    if ($verticalPosition === 'top') {
        $verticalPositionClass = 'items-start';
    }

    if ($verticalPosition === 'bottom') {
        $verticalPositionClass = 'items-end';
    }
@endphp

<div class="{{ $class }}">
    <div @class([
        $verticalPositionClass,
        'flex-relative',
        'flex-row-reverse' => $right,
    ])>
        <div class="flex absolute items-center h-5">
            <input
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                type="checkbox"
                class="form-checkbox input-checkbox"
                wire:model="{{ $model ?? $name }}"
                @if($value) value="{{ $value }}" @endif
                @if($checked) checked @endif
                @if($disabled) disabled @endif
                @if($alpine) @click="{{ $alpine }}" @endif
            />
        </div>

        <div @class([
            'text-sm leading-5',
            'pr-7' => $right,
            'pl-7' => ! $right,
        ])>
            <label for="{{ $id ?? $name }}" class="text-theme-secondary-700 {{ $labelClasses }}">
                {{ $label ? $label : trans('forms.' . $name) }}
            </label>
        </div>
    </div>
</div>

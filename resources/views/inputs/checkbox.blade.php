@props([
    'name',
    'class'                 => 'mt-4',
    'verticalPosition'      => 'middle',
    'id'                    => null,
    'model'                 => null,
    'label'                 => null,
    'labelClasses'          => '',
    'value'                 => null,
    'checked'               => false,
    'disabled'              => false,
    'alpine'                => false,
    'right'                 => false
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
                class="focus-visible:ring-2 form-checkbox input-checkbox focus-visible:ring-theme-primary-500"
                wire:model="{{ $model ?? $name }}"
                @if($value) value="{{ $value }}" @endif
                @if($checked) checked @endif
                @if($disabled) disabled @endif
                @if($alpine) @click="{{ $alpine }}" @endif
            />
        </div>

        <div @class([
            'text-sm leading-5 theme-secondary-700',
            'pr-7' => $right,
            'pl-7' => ! $right,
        ])>
            <label for="{{ $id ?? $name }}" class="{{ $labelClasses }}">
                {{ $label ? $label : trans('forms.' . $name) }}
            </label>
        </div>
    </div>
</div>

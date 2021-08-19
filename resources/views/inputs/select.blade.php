@props([
    'id',
    'model',
    'name',
    'class'     => null,
    'disabled'  => false,
    'label'     => trans('forms.' . $name),
    'showLabel' => true,
    'noModel'   => false,
    'onChange'  => null,
    'slot'      => null,
])

<div class="{{ $class }}">
    <div class="input-group">
        @if($showLabel)
            <label for="{{ $id ?? $name }}" class="input-label @error($name) input-label--error @enderror">
                {{ $label }}
            </label>
        @endif
        <div class="input-wrapper">
            <select
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                class="form-select block w-full pl-4 pr-8 py-3 @error($name) border-theme-danger-500 focus:border-theme-danger-300 focus:ring focus:ring-theme-danger-300 @enderror"
                @if(! isset($noModel)) wire:model="{{ $model ?? $name }}" @endif
                @if($onChange) x-on:change="{{ $onChange }}" @endif
                @if($disabled) disabled @endif
            >
                {{ $slot }}
            </select>
        </div>

        @include('ark::inputs.includes.input-error')
    </div>
</div>

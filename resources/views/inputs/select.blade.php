<div class="{{ $class ?? '' }}">
    <div class="input-group">
        @if($showLabel ?? true)
            <label for="{{ $id ?? $name }}" class="input-label @error($name) input-label--error @enderror">
                {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
            </label>
        @endif
        <div class="input-wrapper">
            <select
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                class="form-select block w-full pl-4 pr-8 py-3 @error($name) border-theme-danger-500 focus:border-theme-danger-300 focus:ring focus:ring-theme-danger-300 @enderror"
                @if(! isset($noModel)) wire:model="{{ $model ?? $name }}" @endif
                @if($onChange ?? false) x-on:change="{{ $onChange }}" @endif
                @if($disabled ?? '') disabled @endif
            >
                {{ $slot }}
            </select>
        </div>

        @include('ark::inputs.includes.input-error')
    </div>
</div>

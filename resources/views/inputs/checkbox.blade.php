<div class="{{ $class ?? 'mt-4' }}">
    <div class="relative flex items-start">
        <div class="absolute flex items-center h-5">
            <input
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                type="checkbox"
                class="form-checkbox input-checkbox"
                wire:model="{{ $model ?? $name }}"
                @if($value ?? '') value="{{ $value }}" @endif
                @if($checked ?? '') checked @endif
                @if($disabled ?? '') disabled @endif
            />
        </div>
        <div class="text-sm leading-5 pl-7">
            <label for="{{ $id ?? $name }}" class="text-theme-secondary-700 {{ $labelClasses ?? '' }}">
                {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
            </label>
        </div>
    </div>
</div>

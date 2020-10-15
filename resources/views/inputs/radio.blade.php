<div class="flex items-center {{ $class ?? 'mt-4' }}">
    <input
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        type="radio"
        class="form-radio input-radio"
        value="{{ $value ?? '' }}"
        wire:model="{{ $model ?? $name }}"
        @if($checked ?? '') checked @endif
        @if($disabled ?? '') disabled @endif
    />
    <label for="{{ $id ?? $name }}" class="ml-3">
        <span class="block text-sm font-medium leading-5 text-theme-secondary-700">
            {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
        </span>
    </label>
</div>

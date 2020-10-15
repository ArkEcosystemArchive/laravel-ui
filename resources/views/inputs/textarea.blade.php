<div class="{{ $class ?? '' }}">
    <div class="input-group">
        <label for="{{ $id ?? $name }}" class="input-label @error($name) input-label--error @enderror">
            {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
        </label>

        <div class="input-wrapper">
            <textarea
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                rows="{{ $rows ?? '10' }}"
                class="input-text @error($name) input-text--error @enderror"
                wire:model="{{ $model ?? $name }}"
                @if($placeholder ?? '') placeholder="{{ $placeholder }}" @endif
                @if($readonly ?? '') readonly @endif
                @if($required ?? false) required @endif
            >{{ $slot ?? '' }}</textarea>
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

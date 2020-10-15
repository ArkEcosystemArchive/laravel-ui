<div class="{{ $class ?? '' }}">
    <div class="input-group">
        <label for="{{ $id ?? $name }}" class="items-center input-label @error($name) input-label--error @enderror">
            {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
            @if(isset($tooltip))<div class="input-tooltip" data-tippy-content="{{ $tooltip }}">?</div>@endif
        </label>

        <div class="input-wrapper">
            <input
                type="{{ $type ?? 'text' }}"
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                class="input-text @error($name) input-text--error @enderror {{ $inputClass ?? '' }}"
                wire:model="{{ $model ?? $name }}"
                @if($max ?? false) maxlength="{{ $max }}" @endif
                @if($placeholder ?? false) placeholder="{{ $placeholder }}" @endif
                @if($value ?? false) value="{{ $value }}" @endif
                @if($autocomplete ?? false) autocomplete="{{ $autocomplete }}" @endif
                @if($autofocus ?? false) autofocus @endif
                @if($readonly ?? false) readonly @endif
                @if($required ?? false) required @endif
            />
            @error($name) @include('ark::inputs.input-error') @enderror
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

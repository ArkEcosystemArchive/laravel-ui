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
                @isset($max) maxlength="{{ $max }}" @endisset
                @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
                @isset($value) value="{{ $value }}" @endisset
                @isset($autocomplete) autocomplete="{{ $autocomplete }}" @endisset
                @isset($autofocus) autofocus @endisset
                @isset($readonly) readonly @endisset
                @isset($required) required @endisset
                @isset($accept) accept="{{ $accept }}" @endisset
                @isset($inputMode) inputmode="{{ $inputMode }}" @endisset
                @isset($pattern) pattern="{{ $pattern }}" @endisset
            />
            @error($name) @include('ark::inputs.input-error') @enderror
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

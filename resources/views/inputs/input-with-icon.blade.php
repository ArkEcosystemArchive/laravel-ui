<div class="{{ $class ?? '' }}">
    <div class="input-group">
        @if(!($hideLabel ?? false))
            <label for="{{ $id ?? $name }}" class="input-label @error($name) input-label--error @enderror">
                {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
            </label>
        @endif

        <div class="flex input-wrapper-with-icon {{ $containerClass ?? '' }}">
            <div class="flex-1">
                <input
                    type="{{ $type ?? 'text' }}"
                    id="{{ $id ?? $name }}"
                    name="{{ $name }}"
                    class="{{ $inputClass ?? '' }} input-text-with-icon @error($name) input-text-with-icon--error @enderror"
                    wire:model="{{ $model ?? $name }}"
                    @if($placeholder ?? '') placeholder="{{ $placeholder }}" @endif
                    @if($value ?? '') value="{{ $value }}" @endif
                    @if($keydownEnter ?? false) wire:keydown.enter="{{ $keydownEnter }}" @endif
                    @if($autocomplete ?? '') autocomplete="{{ $autocomplete }}" @endif
                    @if($readonly ?? false) readonly @endif
                    @isset($inputMode) inputmode="{{ $inputMode }}" @endisset
                    @isset($pattern) pattern="{{ $pattern }}" @endisset
                />
            </div>

            @if ($slot ?? false)
                <div>
                    <div class="flex {{ $slotClass ?? 'h-full bg-white' }}">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        </div>

        @error($name)
            <p class="font-semibold input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

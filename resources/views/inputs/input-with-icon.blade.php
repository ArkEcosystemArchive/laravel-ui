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
                    class="{{ $inputClass ?? '' }} input-text-with-icon @error($name) input-text-with-icon--error @enderror"
                    wire:model="{{ $model ?? $name }}"
                    {{-- @TODO: remove --}}
                    @isset($keydownEnter) wire:keydown.enter="{{ $keydownEnter }}" @endisset
                    {{-- @TODO: remove --}}
                    @isset($max) maxlength="{{ $max }}" @endisset
                    {{ $attributes->except(['class', 'errors', 'id', 'max', 'model', 'slot', 'slotClass', 'type', 'wire:model', 'wire:keydown.enter']) }}
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

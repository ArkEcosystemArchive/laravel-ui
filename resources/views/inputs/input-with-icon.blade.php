<div class="{{ $class ?? '' }}">
    <div class="input-group">
        @if(!($hideLabel ?? false))
            @include('ark::inputs.includes.input-label', [
                'name' => $name,
                'errors' => $errors,
                'id' => $id ?? $name,
                'label' => $label,
                'tooltip' => $tooltip ?? null,
            ])
        @endif

        <div class="flex input-wrapper-with-icon {{ $containerClass ?? '' }}">
            <div class="flex-1">
                <input
                    type="{{ $type ?? 'text' }}"
                    id="{{ $id ?? $name }}"
                    class="{{ $inputClass ?? '' }} input-text-with-icon @error($name) input-text-with-icon--error @enderror"
                    @unless($noModel ?? false) wire:model="{{ $model ?? $name }}" @endunless
                    {{-- @TODO: remove --}}
                    @isset($keydownEnter) wire:keydown.enter="{{ $keydownEnter }}" @endisset
                    {{-- @TODO: remove --}}
                    @isset($max) maxlength="{{ $max }}" @endisset
                    {{ $attributes->except(['class', 'errors', 'id', 'max', 'model', 'slot', 'slot-class', 'type', 'wire:model', 'keydown-enter']) }}
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

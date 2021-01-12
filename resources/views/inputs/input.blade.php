<div class="{{ $class ?? '' }}">
    <div class="input-group">
        @include('ark::inputs.includes.input-label', [
            'name' => $name,
            'errors' => $errors,
            'id' => $id ?? $name,
            'label' => $label,
            'tooltip' => $tooltip ?? null,
        ])

        <div class="input-wrapper">
            <input
                type="{{ $type ?? 'text' }}"
                id="{{ $id ?? $name }}"
                class="input-text @error($name) input-text--error @enderror {{ $inputClass ?? '' }}"
                @unless($noModel ?? false) wire:model="{{ $model ?? $name }}" @endUnless
                {{-- @TODO: remove --}}
                @isset($keydownEnter) wire:keydown.enter="{{ $keydownEnter }}" @endisset
                {{-- @TODO: remove --}}
                @isset($max) maxlength="{{ $max }}" @endisset
                {{ $attributes->except(['class', 'errors', 'id', 'max', 'model', 'slot', 'type', 'wire:model', 'keydown-enter']) }}
            />
            @error($name) @include('ark::inputs.input-error') @enderror
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

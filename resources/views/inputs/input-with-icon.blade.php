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
                @include('ark::inputs.includes.input-field', [
                    'name'         => $name,
                    'errors'       => $errors,
                    'id'           => $id ?? $name,
                    'inputClass'   => 'input-text-with-icon',
                    'errorClass'   => 'input-text-with-icon--error',
                    'class'        => $inputClass ?? '',
                    'noModel'      => $noModel ?? false,
                    'model'        => $model ?? $name,
                    'keydownEnter' => $keydownEnter ?? null,
                    'maxlength'    => $max ?? null,
                ])
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

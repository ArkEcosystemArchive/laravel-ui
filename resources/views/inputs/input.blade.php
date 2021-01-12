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
            @include('ark::inputs.includes.input-field', [
                'name' => $name,
                'errors' => $errors,
                'id' => $id ?? $name,
                'class' => $inputClass ?? '',
                'noModel' => $noModel ?? false,
                'model' => $model ?? $name,
                'keydownEnter' => $keydownEnter ?? null,
                'maxlength' => $max ?? null,
            ])

            @error($name) @include('ark::inputs.input-error') @enderror
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

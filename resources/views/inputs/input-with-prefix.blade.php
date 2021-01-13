<div {{ $attributes->only('class') }} x-data="{ value: '' }">
    <div class="input-group">
        @unless ($hideLabel ?? false)
            @include('ark::inputs.includes.input-label', [
                'name'    => $name,
                'errors'  => $errors,
                'id'      => $id ?? $name,
                'label'   => $label ?? null,
                'tooltip' => $tooltip ?? null,
            ])
        @endunless

        <div
            class="input-wrapper input-wrapper-with-prefix"
            x-bind:class="{ 'input-wrapper-with-prefix--dirty': !! value }"
        >
            @include('ark::inputs.includes.input-internal-icon', [
                'icon'     => $icon,
                'position' => 'left',
            ])

            @include('ark::inputs.includes.input-field', [
                'name'           => $name,
                'errors'         => $errors,
                'id'             => $id ?? $name,
                'inputTypeClass' => 'input-text input-text-with-prefix',
                'inputClass'     => $inputClass ?? '',
                'noModel'        => $noModel ?? false,
                'model'          => $model ?? $name,
                'keydownEnter'   => $keydownEnter ?? null,
                'max'            => $max ?? null,
                'attributes'     => $attributes->merge(['x-model' => 'value']),
            ])

            @error($name) @include('ark::inputs.input-error') @enderror
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

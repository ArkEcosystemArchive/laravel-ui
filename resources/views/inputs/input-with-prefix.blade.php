<div
    x-data="{ isDirty: {{ !! ($value ?? false) ? 'true' : 'false' }} }"
    {{ $attributes->only('class') }}
>
    <div class="input-group">
        @unless ($hideLabel ?? false)
            @include('ark::inputs.includes.input-label', [
                'name'     => $name,
                'errors'   => $errors,
                'id'       => $id ?? $name,
                'label'    => $label ?? null,
                'tooltip'  => $tooltip ?? null,
                'required' => $required ?? false,
            ])
        @endunless

        <div
            class="input-wrapper input-wrapper-with-prefix"
            x-bind:class="{ 'input-wrapper-with-prefix--dirty': !! isDirty }"
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
                'attributes'     => $attributes->merge(['x-on:change' => 'isDirty = !! $event.target.value']),
            ])

            @error($name) @include('ark::inputs.includes.input-error-tooltip', ['error' => $message]) @enderror
        </div>
    </div>
</div>

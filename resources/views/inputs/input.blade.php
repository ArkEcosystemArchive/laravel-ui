<div
    x-data="{}"
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

        <div class="input-wrapper">
            @include('ark::inputs.includes.input-field', [
                'name'         => $name,
                'errors'       => $errors,
                'id'           => $id ?? $name,
                'inputClass'   => $inputClass ?? '',
                'noModel'      => $noModel ?? false,
                'model'        => $model ?? $name,
                'keydownEnter' => $keydownEnter ?? null,
                'max'          => $max ?? null,
            ])

            @error($name) @include('ark::inputs.includes.input-error-tooltip', ['error' => $message]) @enderror
        </div>
    </div>
</div>

@props([
    'id'
    'errors',
    'model',
    'name',
    'attributes'     => null,
    'auxiliaryTitle' => null,
    'hideLabel'      => false,
    'inputClass'     => null,
    'keydownEnter'   => null,
    'label'          => null,
    'max'            => null,
    'noModel'        => false,
    'required'       => false,
    'suffix'         => null,
    'tooltip'        => null,
    'value'          => null,
])

<div
    x-data="{ isDirty: {{ !! $value ? 'true' : 'false' }} }"
    {{ $attributes->only('class') }}
>
    <div class="input-group">
        @unless ($hideLabel)
            @include('ark::inputs.includes.input-label', [
                'name'           => $name,
                'errors'         => $errors,
                'id'             => $id ?? $name,
                'label'          => $label,
                'tooltip'        => $tooltip,
                'required'       => $required,
                'auxiliaryTitle' => $auxiliaryTitle,
            ])
        @endunless

        <div
            @class([
                'input-wrapper input-wrapper-with-suffix',
                'input-text--error' => @error($name),
            ])
            x-bind:class="{ 'input-wrapper-with-suffix--dirty': !! isDirty }"
        >
            @include('ark::inputs.includes.input-field', [
                'name'           => $name,
                'errors'         => null,
                'id'             => $id ?? $name,
                'inputTypeClass' => 'input-text-with-suffix',
                'inputClass'     => $inputClass,
                'noModel'        => $noModel,
                'model'          => $model ?? $name,
                'keydownEnter'   => $keydownEnter,
                'max'            => $max,
                'attributes'     => $attributes->merge(['x-on:change' => 'isDirty = !! $event.target.value']),
            ])

            @if($suffix)
                <div class="relative input-suffix">
                    {{ $suffix }}

                    @error($name)
                        @include('ark::inputs.includes.input-error-tooltip', [
                            'error' => $message,
                            'id' => $id ?? $name
                        ])
                    @enderror
                </div>
            @else
                @error($name)
                    @include('ark::inputs.includes.input-error-tooltip', [
                        'error' => $message,
                        'id' => $id ?? $name
                    ])
                @enderror
            @endif
        </div>
    </div>
</div>

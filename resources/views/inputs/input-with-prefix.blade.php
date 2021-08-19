@props([
    'id',
    'errors',
    'model',
    'name',
    'attributes'     => null,
    'auxiliaryTitle' => null,
    'class'          => null,
    'hideLabel'      => false,
    'icon'           => null,
    'inputClass'     => null,
    'keydownEnter'   => null,
    'label'          => null,
    'max'            => null,
    'noModel'        => false,
    'prefix'         => null,
    'required'       => false,
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
            class="input-wrapper input-wrapper-with-prefix @error($name) input-text--error @enderror"
            x-bind:class="{ 'input-wrapper-with-prefix--dirty': !! isDirty }"
        >
            @if ($icon)
                @include('ark::inputs.includes.input-prefix-icon', [
                    'icon'     => $icon,
                    'position' => 'left',
                ])
            @elseif($prefix)
                <div class="input-prefix">
                    {{ $prefix }}
                </div>
            @endif

            @include('ark::inputs.includes.input-field', [
                'name'           => $name,
                'errors'         => null,
                'id'             => $id ?? $name,
                'inputTypeClass' => 'input-text-with-prefix',
                'inputClass'     => $inputClass,
                'noModel'        => $noModel,
                'model'          => $model ?? $name,
                'keydownEnter'   => $keydownEnter,
                'max'            => $max,
                'attributes'     => $attributes->merge(['x-on:change' => 'isDirty = !! $event.target.value']),
            ])

            @error($name)
                @include('ark::inputs.includes.input-error-tooltip', [
                    'error' => $message,
                    'id' => $id ?? $name,
                ])
            @enderror
        </div>
    </div>
</div>

@props([
    'name',
    'errors',
    'value' => null,
    'id' => null,
    'label' => null,
    'tooltip' => null,
    'required' => false,
    'auxiliaryTitle' => null,
    'icon' => null,
    'prefix' => null,
    'inputClass' => '',
    'noModel' => false,
    'model' => $name,
    'keydownEnter' => null,
    'max' => null,
])

<div
    x-data="{ isDirty: {{ $value ? 'true' : 'false' }} }"
    {{ $attributes->only('class') }}
>
    <div class="input-group">
        @unless ($hideLabel ?? false)
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
            class="input-wrapper input-wrapper-with-prefix"
            x-bind:class="{ 'input-wrapper-with-prefix--dirty': !! isDirty }"
        >
            @if ($icon)
                @include('ark::inputs.includes.input-internal-icon', [
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
                'errors'         => $errors,
                'id'             => $id ?? $name,
                'inputTypeClass' => 'input-text-with-prefix',
                'inputClass'     => $inputClass,
                'noModel'        => $noModel,
                'model'          => $model,
                'keydownEnter'   => $keydownEnter,
                'max'            => $max,
                'attributes'     => $attributes->merge(['x-on:change' => 'isDirty = !! $event.target.value']),
            ])

            @error($name)
                @include('ark::inputs.includes.input-error-tooltip', [
                    'error' => $message,
                    'id' => $id ?? $name
                ])
            @enderror
        </div>
    </div>
</div>

@props([
    'id',
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
    'tooltip'        => null,
    'tooltipClass'   => null,
    'tooltipType'    => null,
])

<div {{ $attributes->only('class') }} >
    <div class="input-group">
        @unless ($hideLabel)
            @include('ark::inputs.includes.input-label', [
                'name'            => $name,
                'errors'          => $errors,
                'id'              => $id ?? $name,
                'label'           => $label,
                'tooltip'         => $tooltip,
                'tooltipClass'    => $tooltipClass,
                'tooltipType'     => $tooltipType,
                'required'        => $required,
                'auxiliaryTitle'  => $auxiliaryTitle,
            ])
        @endunless

        <div class="input-wrapper">
            @include('ark::inputs.includes.input-field', [
                'name'         => $name,
                'errors'       => $errors,
                'id'           => $id ?? $name,
                'inputClass'   => $inputClass,
                'noModel'      => $noModel,
                'model'        => $model ?? $name,
                'keydownEnter' => $keydownEnter,
                'max'          => $max,
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

@props([
    'id',
    'errors',
    'model',
    'name',
    'auxiliaryTitle' => null,
    'class'          => null,
    'containerClass' => null,
    'hideLabel'      => false,
    'inputClass'     => null,
    'keydownEnter'   => null,
    'label'          => null,
    'max'            => null,
    'noModel'        => false,
    'required'       => false,
    'slot'           => null,
    'slotClass'      => 'h-full',
    'tooltip'        => null,
    'type'           => null,
    'value'          => null,
])

<div class="{{ $class }}">
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

        <div class="flex input-wrapper-with-icon {{ $containerClass }}">
            <div class="flex-1">
                @include('ark::inputs.includes.input-field', [
                    'name'           => $name,
                    'errors'         => $errors,
                    'id'             => $id ?? $name,
                    'inputTypeClass' => 'input-text-with-icon',
                    'errorClass'     => 'input-text-with-icon--error',
                    'inputClass'     => $inputClass,
                    'noModel'        => $noModel,
                    'model'          => $model ?? $name,
                    'keydownEnter'   => $keydownEnter,
                    'max'            => $max,
                    'value'          => $value,
                    'type'           => $type,
                ])
            </div>

            @if ($slot)
                <div>
                    <div class="flex {{ $slotClass }}">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        </div>

        @include('ark::inputs.includes.input-error')
    </div>
</div>

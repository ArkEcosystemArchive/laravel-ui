@props([
    'name',
    'errors',
    'class'           => '',
    'id'              => null,
    'model'           => null,
    'hideLabel'       => false,
    'label'           => null,
    'tooltip'         => null,
    'required'        => false,
    'rows'            => 10,
    'auxiliaryTitle'  => '',
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

        <div class="input-wrapper">
            <textarea
                @class([
                    'input-text',
                    'input-text--error' => $errors->has($name),
                ])
                {{ $attributes
                    ->merge([
                        'id'   => $id ?? $name,
                        'rows' => $rows,
                        'name' => $name,
                        'wire:model' => $model ?? $name,
                    ])
                    ->except([
                        'class',
                        'errors',
                        'model',
                        'slot',
                        'tooltip',
                        'label',
                        'hide-label',
                    ]) }}
            >{{ $slot ?? '' }}</textarea>
        </div>

        @include('ark::inputs.includes.input-error')
    </div>
</div>

@props([
    'name',
    'errors',
    'class'     => '',
    'id'        => null,
    'model'     => null,
    'hideLabel' => false,
    'label'     => null,
    'tooltip'   => null,
    'required'  => false,
    'rows'      => 10,
    'optional'  => false,
])

<div class="{{ $class }}">
    <div class="input-group">
        @unless ($hideLabel)
            @include('ark::inputs.includes.input-label', [
                'name'     => $name,
                'errors'   => $errors,
                'id'       => $id ?? $name,
                'label'    => $label,
                'tooltip'  => $tooltip,
                'required' => $required,
                'optional' => $optional,
            ])
        @endunless

        <div class="input-wrapper">
            <textarea class="input-text @error($name) input-text--error @enderror"
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

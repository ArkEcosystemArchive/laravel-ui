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
    'usersInContext' => [],
    'placeholder' => ''
])

<div
    x-data="Taggable({{ json_encode($usersInContext) }})"
    x-init="init"
    class="{{ $class }}"
>
    <div class="input-group">
        @unless ($hideLabel)
            @include('ark::inputs.includes.input-label', [
                'name'     => $name,
                'errors'   => $errors,
                'id'       => $id ?? $name,
                'label'    => $label,
                'tooltip'  => $tooltip,
                'required' => $required,
            ])
        @endunless

        <div class="input-wrapper" wire:ignore>
            <input x-ref="input" type="hidden" id="{{ $id ?? $name }}" wire:model="{{ $model ?? $name }}" name="{{ $name }}" />
            <div
                x-ref="editor"
                style="min-height: {{ $rows * 30 }}px"
                class="input-text @error($name) input-text--error @enderror"
                data-placeholder="{{ $placeholder }}"
            ></div>
        </div>

        @include('ark::inputs.includes.input-error')
    </div>
</div>

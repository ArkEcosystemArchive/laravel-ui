@props([
    'name',
    'errors',
    'id'      => null,
    'label'   => null,
    'tooltip' => null,
])

<label
    for="{{ $id ?? $name }}"
    class="items-center input-label @error($name) input-label--error @enderror"
>
    {{ $label ? $label : trans('forms.' . $name) }}

    @if ($tooltip)
        <div class="input-tooltip" data-tippy-content="{{ $tooltip }}">?</div>
    @endif
</label>
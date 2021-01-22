@props([
    'name',
    'errors',
    'id'       => null,
    'label'    => null,
    'tooltip'  => null,
    'required' => false,
])

<label
    for="{{ $id ?? $name }}"
    class="items-center input-label @error($name) input-label--error @enderror"
>
    {{ $label ? $label : trans('forms.' . $name) }}

    @if ($required)
        <div class="h-1 w-1 p-px ml-px mb-3 bg-theme-danger-400 rounded-full"></div>
    @endif

    @if ($tooltip)
        <div class="input-tooltip" data-tippy-content="{{ $tooltip }}">?</div>
    @endif
</label>

@props([
    'name',
    'errors',
    'id'             => null,
    'label'          => null,
    'tooltip'        => null,
    'required'       => false,
    'auxiliaryTitle' => '',
])

<label
    for="{{ $id ?? $name }}"
    class="items-center input-label @error($name) input-label--error @enderror"
>
    {{ $label ? $label : trans('forms.' . $name) }}

    @if (!empty($auxiliaryTitle))
        <span class="ml-1 text-theme-secondary-400">{{ $auxiliaryTitle }}</span>
    @endif

    @if ($required)
        <div class="p-px mb-3 ml-px w-1 h-1 rounded-full bg-theme-danger-400"></div>
    @endif

    @if ($tooltip)
        <div class="input-tooltip" data-tippy-content="{{ $tooltip }}">?</div>
    @endif
</label>

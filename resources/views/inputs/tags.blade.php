@props([
    'xData' => '{}',
    'name',
    'errors',
    'tags' => [],
    'maxTags' => null,
    'allowedTags' => [],
    'id' => null,
    'label' => null,
    'tooltip' => null,
    'required' => false,
    'placeholder' => 'Enter tags',
    'isDisabled' => false,
    'disabledInputTooltip' => null,
])

<div
    x-data="Tags({{ $xData }}, '{{ $id ?? $name }}', {{ json_encode($tags) }}, {{ json_encode($allowedTags) }}, '{{ $placeholder }}', {{ $maxTags === null ? 'null' : $maxTags }})"
    x-init="init()"
    {{ $attributes }}
    @if($isDisabled) data-tippy-content="{{ $disabledInputTooltip }}" @endif
>
    <div class="input-group {{ $isDisabled ? 'pointer-events-none' : '' }}">
        @unless ($hideLabel ?? false)
            @include('ark::inputs.includes.input-label', [
                'name'     => $name,
                'errors'   => $errors,
                'id'       => $id !== null ? $id : $name,
                'label'    => $label ?? null,
                'tooltip'  => $tooltip ?? null,
                'required' => $required ?? false,
            ])
        @endunless

        <div class="input-wrapper {{ $isDisabled ? 'disabled-tags-input' : '' }}">
            <div
                wire:ignore
                x-ref="input"
                class="relative px-3 py-2 bg-white border rounded border-theme-secondary-400"
            >
            </div>

            {{-- Hidden select used to emulate wire:model behaviour --}}
            <select
                x-ref="select"
                multiple
                class="hidden"
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                wire:model="{{ $model ?? $name }}"
            >
                <template x-for="(tag, index) in availableTags" :key="`index-${tag}`">
                    <option x-text="tag" x-bind:value="tag" />
                </template>
            </select>

            @error($name)
                @include('ark::inputs.includes.input-error-tooltip', [
                    'error' => $message,
                    'id'    => $id ?? $name,
                ])
            @enderror
        </div>
    </div>
</div>

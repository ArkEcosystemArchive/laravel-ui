@props([
    'xData' => '{}',
    'name',
    'errors',
    'tags',
    'maxTags' => null,
    'id' => null,
    'label' => null,
    'tooltip' => null,
    'required' => false,
    'containerFocusClass' => 'border-theme-primary-600',
])

<div
    x-data="Tags({{ $xData }}, {{ json_encode($tags) }}, {{ $maxTags === null ? 'null' : $maxTags }})"
    x-init="init()"
>
    <div class="input-group">
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

        <div class="input-wrapper">
            <div wire:ignore x-ref="input" class="flex w-full px-4 pt-4 pb-2 mt-6 mb-6 border-2 rounded-md md:w-2/3 border-theme-secondary-200"></div>

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

            @error($name) @include('ark::inputs.input-error') @enderror
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>

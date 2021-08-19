@props([
    'model',
    'name',
    'alpineClick' => null,
    'default'     => null,
    'description' => null,
    'hideLabel'   => false,
    'label'       => trans('forms.'.$name),
    'labelClass'  => null,
])

<div
    x-data="{ focused: false, value: {{ $default ?? 'false' }}, toggle() { this.value = !this.value; this.$refs['checkbox-livewire'].click(); } }"
    class="flex items-center"
>
    @unless($hideLabel)
        <label for="{{ $name }}" class="input-label--toggle {{ $labelClass }}">
            {{ $label }}

            @if($description)
                <div class="font-normal text-theme-secondary-500">
                    {{ $description }}
                </div>
            @endif
        </label>
    @endunless

    <span
        class="inline-flex relative flex-shrink-0 justify-center items-center w-8 h-5 ring-0 outline-none"
        role="checkbox"
        @focus="focused=true"
        @blur="focused=false"
        :aria-checked="value.toString()"
        tabindex="0"
        @click.prevent="toggle"
        @keyup.space.prevent="toggle"
    >
        <span aria-hidden="true" class="absolute mx-auto w-full h-1.5 rounded-full transition-colors duration-200 ease-in-out bg-theme-secondary-300 dark:bg-theme-secondary-800"></span>
        <span
            aria-hidden="true"
            :class="{
                'ring ring-focus outline-none': focused,
                'translate-x-full bg-theme-primary-600': value,
                'translate-x-0 bg-theme-secondary-300 dark:bg-theme-secondary-700': !value,
            }"
            class="inline-block absolute left-0 w-4 h-4 bg-white rounded-full transition duration-200 ease-in-out transform cursor-pointer"
        ></span>
    </span>

    <input
        x-ref="checkbox-livewire"
        type="checkbox"
        name="{{ $name }}"
        class="hidden"
        wire:model="{{ $model ?? $name }}"
        @if($alpineClick) x-on:click="{{ $alpineClick }}" @endif
        @if($default) checked @endif
    />
</div>

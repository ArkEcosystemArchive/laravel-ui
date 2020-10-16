<div
    x-data="{ value: {{ $default ?? 'false' }}, toggle() { this.value = !this.value; this.$refs['checkbox-livewire'].click(); }, focused: false }"
    class="flex items-center"
>
    @unless($hideLabel ?? false)
        <label for="{{ $name }}" class="input-label--toggle {{ $labelClass ?? '' }}">
            {{ ($label ?? '') ? $label : trans('forms.' . $name) }}

            @if($description ?? false)
                <div class="font-normal text-theme-secondary-500">
                    {{ $description }}
                </div>
            @endif
        </label>
    @endunless

    <span
        @focus="focused = true"
        @blur="focused = false"
        class="relative inline-flex items-center justify-center flex-shrink-0 w-10 h-5 cursor-pointer focus:outline-none"
        role="checkbox"
        tabindex="0"
        @click="toggle()"
        @keydown.space.prevent="toggle()"
        :aria-checked="value.toString()"
    >
        <span aria-hidden="true" class="absolute h-2 mx-auto transition-colors duration-200 ease-in-out rounded-full bg-theme-secondary-300 w-9"></span>
        <span
            aria-hidden="true"
            :class="{ 'translate-x-5 bg-theme-primary-600 hover:shadow-outline': value, 'translate-x-0 bg-theme-secondary-300': !value }"
            class="absolute left-0 inline-block w-5 h-5 transition-transform duration-200 ease-in-out transform bg-white rounded-full shadow"></span>
    </span>
    <input
        x-ref="checkbox-livewire"
        type="checkbox"
        name="{{ $name }}"
        class="hidden"
        wire:model="{{ $model ?? $name }}"
        @if($alpineClick ?? false) @click="{{ $alpineClick }}" @endif
        @if($default ?? false) checked @endif
    />
</div>
